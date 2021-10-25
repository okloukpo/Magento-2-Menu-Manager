<?php
/**
 * Naxero.com
 * Professional ecommerce integrations for Magento.
 *
 * PHP version 7
 *
 * @category  Magento2
 * @package   Naxero
 * @author    Platforms Development Team <contact@naxero.com>
 * @copyright © Naxero.com all rights reserved
 * @license   https://opensource.org/licenses/mit-license.html MIT License
 * @link      https://www.naxero.com
 */

namespace Naxero\MenuManager\Controller\Adminhtml\Ajax;

/**
 * LinkUrlOptions field class constructor
 */
class LinkUrlOptions extends \Magento\Backend\App\Action
{
    /**
     * @var JsonFactory
     */
    public $jsonFactory;

    /**
     * @var Menu
     */
    public $menuHelper;

    /**
     * @var Config
     */
    public $configHelper;

    /**
     * @var Block
     */
    public $blockHelper;

    /**
     * LinkUrlOptions class constructor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \Naxero\MenuManager\Helper\Menu $menuHelper,
        \Naxero\MenuManager\Helper\Config $configHelper,
        \Naxero\MenuManager\Helper\Block $blockHelper
    ) {
        parent::__construct($context);

        $this->jsonFactory = $jsonFactory;
        $this->menuHelper = $menuHelper;
        $this->configHelper = $configHelper;
        $this->blockHelper = $blockHelper;
    }

    /**
     * Index action
     */
    public function execute()
    {
        // Prepare parameters
        $response = [];
        $request = $this->getRequest();

        // Process the request
        if ($this->configHelper->isValidAdminAjaxRequest($request)) {
            $params = $request->getParams();
            if (isset($params['node']) && !empty($params['node'])) {
                $response = [
                    'success' => true,
                    'data' => $this->menuHelper->getLinkUrlOptions($params['node'])
                ];
            }
        } else {
            $response = $this->getErrorResponse();
        }

        return $this->jsonFactory->create()->setData($response);
    }

    /**
     * Get the error response.
     */
    public function getErrorResponse()
    {
        return  [
            'success' => false,
            'msg' => $this->blockHelper->getErrorHtml(
                __('Invalid or expired request. Try reloading the page.')
            )
        ];
    }
}

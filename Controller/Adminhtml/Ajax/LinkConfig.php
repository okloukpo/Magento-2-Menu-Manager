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
 * LinkConfig field class 
 */
class LinkConfig extends \Magento\Backend\App\Action
{
    /**
     * @var JsonFactory
     */
    public $jsonFactory;

    /**
     * @var Block
     */
    public $blockHelper;

    /**
     * @var Config
     */
    public $configHelper;

    /**
     * LinkConfig field class constructor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \Naxero\MenuManager\Helper\Block $blockHelper,
        \Naxero\MenuManager\Helper\Config $configHelper
    ) {
        parent::__construct($context);

        $this->jsonFactory = $jsonFactory;
        $this->blockHelper = $blockHelper;
        $this->configHelper = $configHelper;
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
            $entityId = $request->getParam('entity_id');
            $params = $request->getParams();
            if (!empty($entityId)) {
                $response = $this->blockHelper
                    ->getLinkConfigFormHtml($params);
            }
        }
        else {
            $response = $this->getErrorResponse();
        }

        return $this->jsonFactory->create()->setData($response);
    }

    /**
     * Get the error response.
     */
    public function getErrorResponse()
    {    
        return  $this->blockHelper->getErrorHtml(
            __('Invalid or expired request. Try reloading the page.')
        );
    }
}

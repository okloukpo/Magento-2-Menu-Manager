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

namespace Naxero\MenuManager\Controller\Adminhtml\Menu;

class Save extends \Magento\Backend\App\Action
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
     * Menu save class constructor.
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \Naxero\MenuManager\Helper\Menu $menuHelper,
        \Naxero\MenuManager\Helper\Config $configHelper
    ) {
        parent::__construct($context);

        $this->jsonFactory = $jsonFactory;
        $this->menuHelper = $menuHelper;
        $this->configHelper = $configHelper;
    }

    /**
     * Execute method
     */
    public function execute()
    {
        // Prepare variables
        $request = $this->getRequest();
        $data = $request->getParams();
        $entityId = $request->getParam('entity_id');
        $response = [];

        // Process the request
        if ($this->configHelper->isValidAdminAjaxRequest($request)) {
            try {
                $entityId = $this->menuHelper->saveMenu($data);
                $response = ['entity_id' => $entityId];
                $this->messageManager->addSuccess(__('Menu successfully saved.'));
            } catch (\Exception $e) {
                $this->messageManager->addError(__($e->getMessage()));
            }
        }

        return $this->jsonFactory->create()->setData($response);
    }
}

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

class Delete extends \Magento\Backend\App\Action
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
     * Menu save class constructor.
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \Naxero\MenuManager\Helper\Menu $menuHelper
    ) {
        parent::__construct($context);

        $this->jsonFactory = $jsonFactory;
        $this->menuHelper = $menuHelper;
    }

    /**
     * Execute method
     */
    public function execute()
    {
        // Prepare variables
        $request = $this->getRequest();
        $entityId = $request->getParam('entity_id');
        
        // Handle the request
        if ((int) $entityId > 0) {
            try {
                // Delete the menu
                $this->menuHelper->deleteMenu($entityId);

                // Add the message
                $this->messageManager->addSuccess(
                    __('Menu successfully deleted.')
                );
            } catch (\Exception $e) {
                $this->messageManager->addError(
                    __('The menu could not be deleted.')
                );
                $this->messageManager->addError(__($e->getMessage()));
            }

            // Handle the AJAX response
            if ($request->isAjax()) {
                return $this->jsonFactory->create()->setData([]);
            }
        }
        
        // Default redirection
        $this->_redirect('naxero-mm/menu/index');
    }
}

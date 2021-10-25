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

use Magento\Framework\Controller\ResultFactory;

class AddRow extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry;

    /**
     * @var \Naxero\MenuManager\Model\MenuEntityFactory
     */
    public $menuEntityFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Naxero\MenuManager\Model\MenuEntityFactory $MenuEntityFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Naxero\MenuManager\Model\MenuEntityFactory $menuEntityFactory
    ) {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
        $this->menuEntityFactory = $menuEntityFactory;
    }

    /**
     * Execute method
     */
    public function execute()
    {
        $entityId = (int) $this->getRequest()->getParam('id');
        $rowData = $this->menuEntityFactory->create();

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        if ($entityId) {
            $rowData = $rowData->load($entityId);
            if (!$rowData->getId()) {
                // Set the error message
                $this->messageManager->addError(
                    __('Invalid or expired request. Try refreshing the page.')
                );

                // Redirect
                $this->_redirect('naxero-mm/menu/index');

                return;
            }
        }

        $this->coreRegistry->register('row_data', $rowData);
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $title = $entityId ? __('Edit Menu') : __('Add Menu');
        $resultPage->getConfig()->getTitle()->prepend($title);
        
        return $resultPage;
    }
}

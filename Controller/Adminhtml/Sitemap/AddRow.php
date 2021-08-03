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

namespace Naxero\MenuManager\Controller\Adminhtml\Sitemap;

use Magento\Framework\Controller\ResultFactory;

class AddRow extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry;

    /**
     * @var SitemapEntityFactory
     */
	public $sitemapEntityFactory;

    /**
     * @var Config
     */
    public $configHelper;

    /**
     * Class AddRow constructor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Naxero\MenuManager\Model\SitemapEntityFactory $sitemapEntityFactory,
        \Naxero\MenuManager\Helper\Config $configHelper
    ) {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
        $this->sitemapEntityFactory = $sitemapEntityFactory;
        $this->configHelper = $configHelper;
    }

    /**
     * Execute method
     */
    public function execute()
    {
        $entityId = (int) $this->getRequest()->getParam('id');
        $rowData = $this->sitemapEntityFactory->create();

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        if ($entityId) {
            $rowData = $rowData->load($entityId);
            if (!$rowData->getId()) {
                // Set the error message
                $this->messageManager->addError(
                    __('Invalid or expired request. Try refreshing the page.')
                );

                // Redirect
                $this->_redirect('naxero-mm/sitemap/index');
                return;
            }
        }

        $this->coreRegistry->register('row_data', $rowData);
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $title = $entityId ? __('Edit Sitemap') : __('Add Sitemap');
        $resultPage->getConfig()->getTitle()->prepend($title);

        return $resultPage;
    }
}
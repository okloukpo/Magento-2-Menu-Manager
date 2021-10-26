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

/**
 * Sitemap generate class controller
 */
class Generate extends \Magento\Backend\App\Action
{
    /**
     * @var Xml
     */
    public $sitemapXmlHelper;

    /**
     * Sitemap save class controller constructor
     * 
     * @param Context $context
     * @param Xml $sitemapXmlHelper
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Naxero\MenuManager\Helper\Sitemap\Xml $sitemapXmlHelper
    ) {
        parent::__construct($context);

        $this->sitemapXmlHelper = $sitemapXmlHelper;
    }

    /**
     * Execute method
     */
    public function execute()
    {
        // Prepare variables
        $request = $this->getRequest();
        $data = $request->getParams();
        $entityId = (int) $request->getParam('id');

        // Process the request
        if ($entityId > 0) {
            try {
                $this->sitemapXmlHelper->generateSitemap($data);
                $this->messageManager->addSuccess(__('Sitemap successfully generated.'));
            } catch (\Exception $e) {
                $this->messageManager->addError(__($e->getMessage()));
            }
        } else {
            $this->messageManager->addSuccess(__('The sitemap must be saved before generating links.'));
        }

        $this->_redirect('naxero-mm/sitemap/index');
    }
}

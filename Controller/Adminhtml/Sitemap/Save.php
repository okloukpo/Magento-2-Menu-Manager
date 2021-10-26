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
 * Sitemap save class controller
 */
class Save extends \Magento\Backend\App\Action
{
    /**
     * @var JsonFactory
     */
    public $jsonFactory;

    /**
     * @var Xml
     */
    public $sitemapXmlHelper;

    /**
     * @var Config
     */
    public $configHelper;
    /**
     * Sitemap save class controller constructor
     *
     * @param Context $context
     * @param JsonFactory $jsonFactory
     * @param Xml $sitemapXmlHelper
     * @param Config $configHelper
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \Naxero\MenuManager\Helper\Sitemap\Xml $sitemapXmlHelper,
        \Naxero\MenuManager\Helper\Config $configHelper
    ) {
        parent::__construct($context);

        $this->jsonFactory = $jsonFactory;
        $this->sitemapXmlHelper = $sitemapXmlHelper;
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

        // Process the request
        if ($this->configHelper->isValidAdminRequest($request)) {
            try {
                // Save the sitemap
                $entityId = $this->sitemapXmlHelper->saveSitemap($data);
                $this->messageManager->addSuccess(__('Sitemap successfully saved.'));

                // Redirect
                return $this->_redirect('naxero-mm/sitemap/addrow/id/' . $entityId);
            } catch (\Exception $e) {
                $this->messageManager->addError(__($e->getMessage()));
            }
        } else {
            $this->messageManager->addError(
                __('Invalid or expired request. Try refreshing the page.')
            );
        }

        return $this->_redirect('naxero-mm/sitemap/index');
    }
}

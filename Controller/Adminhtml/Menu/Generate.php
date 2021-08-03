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

use Naxero\MenuManager\Helper\Config;

class Generate extends \Magento\Backend\App\Action
{
    /**
     * @var Config
     */
    public $configHelper;

    /**
     * @var Menu
     */
    public $menuHelper;

    /**
     * LinkUrlOptions class constructor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Naxero\MenuManager\Helper\Config $configHelper,
        \Naxero\MenuManager\Helper\Menu $menuHelper
    ) {
        parent::__construct($context);

        $this->configHelper = $configHelper;
        $this->menuHelper = $menuHelper;
    }

    /**
     * Execute method
     */
    public function execute()
    {
        // Prepare parameters
        $request = $this->getRequest();
        $params = $request->getParams();

        // Process the request
        if ($this->configHelper->isValidAdminRequest($request)) {
            // Prepare variables
            $entityId = (int) $request->getParam('entity_id');

            // Process the request
            if ($entityId > 0) {
                // Get the result
                $result = $this->menuHelper->generateMenuLinks($params);

                // Prepare the response
                if ($result) {
                    $this->messageManager->addSuccess(
                        __('Links successfully generated.')
                    );
                } else {
                    $this->messageManager->addError(
                        __('The link generation failed. Please check the error logs.')
                    );
                }

                // Redirect
                return $this->_redirect('naxero-mm/menu/addrow/id/' . $entityId);
            }
            else {
                $this->messageManager->addError(
                    __('Please save the menu before generating links.')
                );                
            }
        }
        else {
            $this->messageManager->addError(
                __('Invalid or expired request. Try refreshing the page.')
            );
        }

        // Redirect
        return $this->_redirect('naxero-mm/menu/index');
    }
}

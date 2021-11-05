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

namespace Naxero\MenuManager\Block\Adminhtml\Menu\Edit;

/**
 * Adminhtml add row form tabs block.
 */
class Tabs extends \Magento\Backend\Block\Template
{
    /**
     * @var Http
     */
    public $request;

    /**
     * @var Menu
     */
    public $menuHelper;

    /**
     * Form class constructor
     *
     * @param Context $context
     * @param Http $request
     * @param Menu $menuHelper
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\App\Request\Http $request,
        \Naxero\MenuManager\Helper\Menu $menuHelper,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->request = $request;
        $this->menuHelper = $menuHelper;
    }

    /**
     * Get the menu ID from request
     */
    public function getMenuId()
    {
        return (int) $this->request->getParam('id');
    }
}

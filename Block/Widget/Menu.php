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

namespace Naxero\MenuManager\Block\Widget;

/**
 * Menu widget class.
 */
class Menu extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface
{
    /**
     * @var String
     */
    // phpcs:ignore
    public $_template = 'widget/menu.phtml';

    /**
     * @var WidgetMenu
     */
    public $widgetMenuBlock;

    /**
     * @var Menu
     */
    public $menuHelper;

    /**
     * WidgetButton class constructor.
     *
     * @param Context $context
     * @param WidgetMenu $widgetMenuBlock
     * @param Menu $menuHelper
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Naxero\MenuManager\Block\Menu\WidgetMenu $widgetMenuBlock,
        \Naxero\MenuManager\Helper\Menu $menuHelper,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->widgetMenuBlock = $widgetMenuBlock;
        $this->menuHelper = $menuHelper;
    }
}

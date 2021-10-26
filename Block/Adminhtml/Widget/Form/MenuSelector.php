<?php
/**
 * Naxero.com
 * Professional ecommerce integrations for Magento
 *
 * PHP version 7
 *
 * @category  Magento2
 * @package   Naxero
 * @author    Platforms Development Team <contact@naxero.com>
 * @copyright Naxero.com
 * @license   https://opensource.org/licenses/mit-license.html MIT License
 * @link      https://www.naxero.com
 */

namespace Naxero\MenuManager\Block\Adminhtml\Widget\Form;

use Magento\Framework\Data\Form\Element\AbstractElement;

/**
 * Class widget MenuSelector
 */
class MenuSelector extends \Magento\Backend\Block\Template
{
    /**
     * @var Menu
     */
    public $menuHelper;

    /**
     * MenuSelector class constructor
     * 
     * @param Context $context
     * @param Menu $menuHelper
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Naxero\MenuManager\Helper\Menu $menuHelper,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->menuHelper = $menuHelper;
    }
    
    /**
     * Render the widget form field.
     */
    public function prepareElementHtml(AbstractElement $element)
    {
        // Prepare the separator HTML
        $blockHtml = $this->getLayout()->createBlock(Magento\Backend\Block\Template::class)
            ->setTemplate(Naming::getModuleName() . '::widget/form/category.phtml')
            ->setData('element', $element)
            ->setData('categories', $this->categoryHelper->getCategoryTree())
            ->toHtml();

        // Render the HTML
        $element->setData('after_element_html', $blockHtml);

        return $element;
    }
}

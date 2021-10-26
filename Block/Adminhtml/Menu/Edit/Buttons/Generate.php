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

namespace Naxero\MenuManager\Block\Adminhtml\Menu\Edit\Buttons;

use Magento\Backend\Block\Widget\Button\SplitButton;

class Generate extends \Magento\Backend\Block\Widget\Container
{

    /**
     * Prepare layout.
     */
    // phpcs:ignore
    public function _prepareLayout()
    {
        $addButtonProps = [
            'id' => 'mm-generate-button',
            'label' => __('Generate links'),
            'class' => 'secondary',
            'button_class' => 'mm-generate-button',
            'class_name' => SplitButton::class,
            'options' => $this->splitButtonList()
        ];

        $this->buttonList->add('add_new', $addButtonProps);

        return parent::_prepareLayout();
    }
 
    /**
     * Retrieve options for the split button
     *
     * @return array
     */
    public function splitButtonList()
    {
        return [
            'action_1' => [
                'label' => __('Categories'),
                'onclick' => $this->getActionUrl('category')
            ],
            'action_2' => [
                'label' => __('Products'),
                'onclick' => $this->getActionUrl('product')
            ],
            'action_3' => [
                'label' => __('CMS pages'),
                'onclick' => $this->getActionUrl('page')
            ],
        ];
    }
    
    /**
     * Get a split button action URL
     *
     * @param string $type
     * @return array
     */
    public function getActionUrl($type)
    {
        // Get the current menu ID
        $menuId = (int) $this->getRequest()->getParam('id');

        $url  = 'window.location.href = window.BASE_URL';
        $url .=  '+ "menu/generate' . '?type=' . $type;
        $url .=  '&menu_id=' . $menuId;
        $url .=  '&form_key=" + window.FORM_KEY';

        return $url;
    }
}

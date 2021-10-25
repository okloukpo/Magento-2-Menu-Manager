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

namespace Naxero\MenuManager\Block\Adminhtml\Menu;

class AddRow extends \Magento\Backend\Block\Widget\Form\Container
{
    /**
     * Core registry.
     *
     * @var \Magento\Framework\Registry
     */
    public $_coreRegistry = null;

    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry           $registry
     * @param array                                 $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Initialize Imagegallery Images Edit Block.
     */
    // phpcs:ignore
    public function _construct()
    {
        $this->_objectId = 'row_id';
        $this->_blockGroup = 'Naxero_MenuManager';
        $this->_controller = 'adminhtml_menu';

        // phpcs:ignore
        parent::_construct();

        // Remove the reset button
        $this->buttonList->remove('reset');
    }

    /**
     * Retrieve text for header element depending on loaded image.
     *
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText()
    {
        return __('Add Row Data');
    }
    
    /**
     * Get form action URL.
     *
     * @return string
     */
    public function getFormActionUrl()
    {
        if ($this->hasFormActionUrl()) {
            return $this->getData('form_action_url');
        }

        return $this->getUrl('*/*/save');
    }
}

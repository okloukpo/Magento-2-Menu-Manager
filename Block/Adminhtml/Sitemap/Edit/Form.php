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

namespace Naxero\MenuManager\Block\Adminhtml\Sitemap\Edit;

/**
 * Adminhtml add row form.
 */
class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    /**
     * @var Registry
     */
    public $registry;

    /**
     * @var FormFactory
     */
    public $formFactory;

    /**
     * @var IncludeImage
     */
    public $includeImageSource;

    /**
     * @var Priority
     */
    public $prioritySource;

    /**
     * @var Frequency
     */
    public $frequencySource;

    /**
     * @var MenuList
     */
    public $menuListSource;

    /**
     * Form class constructor
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Sitemap\Model\Source\Product\Image\IncludeImage $includeImageSource,
        \Naxero\MenuManager\Model\Config\Backend\Source\Priority $prioritySource,
        \Naxero\MenuManager\Model\Config\Backend\Source\Frequency $frequencySource,
        \Naxero\MenuManager\Model\Config\Backend\Source\MenuList $menuListSource,
        array $data = []
    ) {
        $this->registry = $registry;
        $this->formFactory = $formFactory;
        $this->includeImageSource = $includeImageSource;
        $this->prioritySource = $prioritySource;
        $this->frequencySource = $frequencySource;
        $this->menuListSource = $menuListSource;

        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form.
     *
     * @return $this
     */
    public function _prepareForm()
    {
        // Prepare parameters
        $model = $this->registry->registry('row_data');
        $form = $this->createForm();

        // Add a fieldset
        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => '', 'class' => 'fieldset-wide']
        );

        // Hidden entity field
        $fieldset->addField('entity_id', 'hidden', ['name' => 'entity_id']);

        // File name
        $fieldset->addField(
            'file_name',
            'text',
            [
                'name' => 'file_name',
                'label' => __('File name'),
                'id' => 'file_name',
                'title' => __('File name'),
                'class' => 'required-entry',
                'required' => true
            ]
        );

        // File path
        $fieldset->addField(
            'file_path',
            'text',
            [
                'name' => 'file_path',
                'label' => __('File path'),
                'id' => 'file_path',
                'title' => __('File path')
            ]
        );

        // File URL
        $fieldset->addField(
            'file_url',
            'text',
            [
                'name' => 'file_url',
                'label' => __('File URL'),
                'id' => 'file_url',
                'title' => __('File URL'),
                'class' => 'mm-readonly',
                'readonly' => true
            ]
        );

        // Sitemap menus
        $fieldset->addField(
            'sitemap_menus',
            'multiselect',
            [
                'name' => 'sitemap_menus',
                'label' => __('Menus'),
                'id' => 'sitemap_menus',
                'title' => __('Menus'),
                'class' => 'required-entry',
                'required' => true,
                'values' => $this->menuListSource->toOptionArray()
            ]
        );

        // Include image
        $fieldset->addField(
            'include_image',
            'select',
            [
                'name' => 'include_image',
                'label' => __('Include images'),
                'id' => 'include_image',
                'title' => __('Include images'),
                'class' => 'required-entry',
                'required' => true,
                'values' => $this->includeImageSource->toOptionArray()
            ]
        );

        // Priority
        $fieldset->addField(
            'priority',
            'select',
            [
                'name' => 'priority',
                'label' => __('Priority'),
                'id' => 'priority',
                'title' => __('Priority'),
                'class' => 'required-entry',
                'required' => true,
                'values' => $this->prioritySource->toOptionArray()
            ]
        );

        // Frequency
        $fieldset->addField(
            'frequency',
            'select',
            [
                'name' => 'frequency',
                'label' => __('Frequency'),
                'id' => 'frequency',
                'title' => __('Frequency'),
                'class' => 'required-entry',
                'required' => true,
                'values' => $this->frequencySource->toOptionArray()
            ]
        );

        // Last Update
        $fieldset->addField(
            'last_update',
            'text',
            [
                'name' => 'last_update',
                'label' => __('Last update'),
                'id' => 'frequlast_updateency',
                'title' => __('Last update'),
                'class' => 'mm-readonly',
                'readonly' => true
            ]
        );

        // Set the form
        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Create the form.
     */
    public function createForm()
    {
        return $this->formFactory->create([
            'data' => [
                'id' => 'mm-sitemap-edit-form',
                'enctype' => 'multipart/form-data',
                'action' => $this->getData('action'),
                'method' => 'post'
            ]
        ]);
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

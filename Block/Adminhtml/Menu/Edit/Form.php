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

use Naxero\MenuManager\Block\Adminhtml\Menu\Edit\Fields\Html;

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
     * @var Config
     */
    public $wysiwygConfig;
    
    /**
     * @var Fields
     */
    public $fieldsDataProvider;

    /**
     * Form class constructor
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        \Naxero\MenuManager\Block\Adminhtml\Menu\Edit\Fields $fieldsDataProvider,
        array $data = []
    ) {
        $this->registry = $registry;
        $this->formFactory = $formFactory;
        $this->wysiwygConfig = $wysiwygConfig;
        $this->fieldsDataProvider = $fieldsDataProvider;

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
        $wysiwygConfig = $this->wysiwygConfig->getConfig(['tab_id' => $this->getTabId()]);
 
        // Build the form
        $form = $this->buildForm()
            ->setValues($model->getData())
            ->setUseContainer(false);
        
        // Set the form
        $this->setForm($form);

        return parent::_prepareForm();
    }
    /**
     * Build the form.
     */
    public function buildForm()
    {
        // Create the form
        $form = $this->formFactory->create();

        // Build the form elements
        foreach ($this->fieldsDataProvider->getFieldsData() as $key => $fieldset) {
            // Fieldset
            $item = $form->addFieldset($key, $fieldset['data']);

            // Custom field types
            $item->addType('html', Html::class);

            // Fields
            foreach ($fieldset['fields'] as $field) {
                $item->addField($field['key'], $field['type'], $field['data']);
            }
        }        

        return $form;
    } 
}

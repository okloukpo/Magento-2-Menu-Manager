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

use Naxero\MenuManager\Block\Adminhtml\Menu\Edit\Fields\MenuLinks;

/**
 * Adminhtml add row form fields data provided.
 */
class Fields implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    /**
     * @var Collection
     */
    public $customerGroupCollection;

    /**
     * @var PageFactory
     */
    public $pageFactory;

    /**
     * @var Http
     */
    public $request;

    /**
     * @var Store
     */
    public $storeModel;

    /**
     * @var YesNo
     */
    public $yesNoSource;

    /**
     * @var Override
     */
    public $overrideSource;

    /**
     * @var Orientation
     */
    public $orientationSource;

    /**
     * @var Display
     */
    public $displaySource;

    /**
     * @var Menu
     */
    public $menuHelper;

    /**
     * @var Config
     */
    public $configHelper;

    /**
     * @var LinkType
     */
    public $linkTypeSource;

    /**
     * Form class constructor
     *
     * @param Collection $customerGroupCollection
     * @param PageFactory $pageFactory
     * @param Http $request
     * @param Store $storeModel
     * @param YesNo $yesNoSource
     * @param Override $overrideSource
     * @param Orientation $orientationSource
     * @param Display $displaySource
     * @param Menu $menuHelper
     * @param Config $configHelper
     * @param LinkType $linkTypeSource
     */
    public function __construct(
        \Magento\Customer\Model\ResourceModel\Group\Collection $customerGroupCollection,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Store\Model\System\Store $storeModel,
        \Naxero\MenuManager\Model\Config\Backend\Source\YesNo $yesNoSource,
        \Naxero\MenuManager\Model\Config\Backend\Source\Override $overrideSource,
        \Naxero\MenuManager\Model\Config\Backend\Source\Orientation $orientationSource,
        \Naxero\MenuManager\Model\Config\Backend\Source\Display $displaySource,
        \Naxero\MenuManager\Helper\Menu $menuHelper,
        \Naxero\MenuManager\Helper\Config $configHelper,
        \Naxero\MenuManager\Model\Config\Backend\Source\LinkType $linkTypeSource
    ) {
        $this->customerGroupCollection = $customerGroupCollection;
        $this->pageFactory = $pageFactory;
        $this->request = $request;
        $this->storeModel = $storeModel;
        $this->yesNoSource = $yesNoSource;
        $this->overrideSource = $overrideSource;
        $this->orientationSource = $orientationSource;
        $this->displaySource = $displaySource;
        $this->menuHelper = $menuHelper;
        $this->configHelper = $configHelper;
        $this->linkTypeSource = $linkTypeSource;
    }

    /**
     * Get the fields data
     */
    public function getFieldsData()
    {
        return [
            // Fieldset 1
            'fieldset1' => [
                'tab' => [
                    'title' => __('General')
                ],
                'data' => [
                    'legend' => __('General settings'),
                    'class' => 'fieldset-wide'
                ],
                'fields' => [
                    // Entity ID
                    [
                        'key' => 'entity_id',
                        'type' => 'hidden',
                        'data' => [
                            'name' => 'entity_id',
                            'id' => 'entity_id'
                        ]
                    ],

                    // Menu title
                    [
                        'key' => 'title',
                        'type' => 'text',
                        'data' => [
                            'name' => 'title',
                            'label' => __('Title'),
                            'id' => 'title',
                            'title' => __('Title'),
                            'class' => 'required-entry',
                            'required' => true,
                        ]
                    ],
            
                    // Menu active
                    [
                        'key' => 'active',
                        'type' => 'select',
                        'data' => [
                            'name' => 'active',
                            'label' => __('Active'),
                            'id' => 'active',
                            'title' => __('Active'),
                            'required' => true,
                            'values' => $this->yesNoSource->toOptionArray()
                        ]
                    ],

                    // Menu orientation
                    [
                        'key' => 'orientation',
                        'type' => 'select',
                        'data' => [
                            'name' => 'orientation',
                            'label' => __('Orientation'),
                            'id' => 'orientation',
                            'title' => __('Orientation'),
                            'class' => '',
                            'values' => $this->orientationSource->toOptionArray()
                        ]
                    ],

                    // Menu override
                    [
                        'key' => 'override',
                        'type' => 'select',
                        'data' => [
                            'name' => 'override',
                            'label' => __('Override'),
                            'id' => 'override',
                            'title' => __('Override'),
                            'class' => '',
                            'values' => $this->overrideSource->toOptionArray()
                        ]
                    ],

                    // Menu z-index
                    [
                        'key' => 'zindex',
                        'type' => 'text',
                        'data' => [
                            'name' => 'zindex',
                            'label' => __('z-index'),
                            'id' => 'zindex',
                            'title' => __('z-index')
                        ]
                    ]
                ]
            ],

            // Fieldset 2
            'fieldset2' => [
                'tab' => [
                    'title' => __('Links')
                ],
                'data' => [
                    'legend' => __('Menu links'),
                    'class' => 'fieldset-wide'
                ],
                'fields' => [
                    // Menu links table
                    [
                        'key' => 'menu_links_table',
                        'type' => 'html',
                        'data' => [
                            'name' => 'menu_links_table',
                            'id' => 'menu_links_table',
                            'html' => $this->renderMenuLinks()
                        ]
                    ],

                    // Menu links hidden data field
                    [
                        'key' => 'menu_links',
                        'type' => 'hidden',
                        'data' => [
                            'name' => 'menu_links',
                            'id' => 'menu_links'
                        ]
                    ]
                ]
            ],

            // Fieldset 3
            'fieldset3' => [
                'tab' => [
                    'title' => __('Permissions')
                ],
                'data' => [
                    'legend' => __('Permissions settings'),
                    'class' => 'fieldset-wide'
                ],
                'fields' => [
                    // User groups
                    [
                        'key' => 'user_groups',
                        'type' => 'multiselect',
                        'data' => [
                            'name' => 'user_groups',
                            'label' => __('User groups'),
                            'id' => 'user_groups',
                            'title' => __('User groups'),
                            'required' => true,
                            'class' => 'required-entry',
                            'values' => [[
                                'value' => '',
                                'label' => __('All users')
                            ]] + $this->customerGroupCollection->toOptionArray(),
                        ]
                    ],

                    // Store views
                    [
                        'key' => 'store_views',
                        'type' => 'multiselect',
                        'data' => [
                            'name' => 'store_views[]',
                            'label' => __('Store View'),
                            'title' => __('Store View'),
                            'required' => true,
                            'class' => 'required-entry',
                            'values' => $this->storeModel->getStoreValuesForForm(
                                false,
                                true
                            )
                        ]
                    ]
                ]
            ],

            // Fieldset 4
            'fieldset4' => [
                'tab' => [
                    'title' => __('Images')
                ],
                'data' => [
                    'legend' => __('Images settings'),
                    'class' => 'fieldset-wide'
                ],
                'fields' => [
                    // Category images
                    [
                        'key' => 'category_images',
                        'type' => 'select',
                        'data' => [
                            'name' => 'category_images',
                            'label' => __('Show category images'),
                            'id' => 'category_images',
                            'title' => __('Show category images'),
                            'values' => $this->yesNoSource->toOptionArray(),
                        ]
                    ],

                    // Product images
                    [
                        'key' => 'product_images',
                        'type' => 'select',
                        'data' => [
                            'name' => 'product_images',
                            'label' => __('Show product images'),
                            'id' => 'product_images',
                            'title' => __('Show product images'),
                            'values' => $this->yesNoSource->toOptionArray(),
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * Render the menu links form field
     */
    public function renderMenuLinks()
    {
        // Prepare variables
        $config = $this->getConfig();
        $entityId = (int) $this->request->getParam('id');
        $menuLinks = $this->menuHelper->getMenuLinksArray($entityId);

        // Render the block
        return $this->pageFactory->create()->getLayout()
            ->createBlock(MenuLinks::class)
            ->setTemplate('Naxero_MenuManager::menu/edit/form/fields/menu-links.phtml')
            ->setData('config', $config)
            ->setData('menu_links', $menuLinks)
            ->setData('menu_id', $entityId)
            ->toHtml();
    }

    /**
     * Get the form config
     */
    public function getConfig()
    {
        // Get the link entity fields
        $linkEntityFields = $this->configHelper->getEntityFields(
            $this->configHelper::LINK_ENTITY_TABLE
        );

        // Return the config array
        return [
            'entity' => ['link' => $linkEntityFields],
            'field' => [
                'link_type' => $this->linkTypeSource->toOptionArray()
            ],
            'icon' => [
                'spinner' => [
                    'url' => $this->configHelper->getIconUrl('icon-spinner.gif')
                ]
            ]
        ];
    }
}

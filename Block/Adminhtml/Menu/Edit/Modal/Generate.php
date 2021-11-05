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

namespace Naxero\MenuManager\Block\Adminhtml\Menu\Edit\Modal;

/**
 * Generate block class.
 */
class Generate extends \Magento\Backend\Block\Template
{
    /**
     * @var Config
     */
    public $configHelper;

    /**
     * @var LinkType
     */
    public $linkTypeSource;

    /**
     * @var YesNo
     */
    public $yesNoSource;

    /**
     * Generate class constructor
     *
     * @param Context $context
     * @param Config $configHelper
     * @param LinkType $linkTypeSource
     * @param YesNo $yesNoSource
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Naxero\MenuManager\Helper\Config $configHelper,
        \Naxero\MenuManager\Model\Config\Backend\Source\LinkType $linkTypeSource,
        \Naxero\MenuManager\Model\Config\Backend\Source\YesNo $yesNoSource,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->configHelper = $configHelper;
        $this->linkTypeSource = $linkTypeSource;
        $this->yesNoSource = $yesNoSource;
    }
}

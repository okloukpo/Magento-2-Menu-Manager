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

namespace Naxero\MenuManager\Block\Adminhtml\Link\Edit\Fields;

/**
 * Adminhtml link config row form.
 */
class Config extends \Magento\Backend\Block\Template
{
    /**
     * @var Http
     */
    public $request;

    /**
     *  @var Links
     */
	public $linksHelper;

    /**
     * @var LinkType
     */
    public $linkTypeSource;

    /**
     * @var Sublayout
     */
    public $sublayoutSource;

    /**
     * @var Blocks
     */
    public $blocksSource;

    /**
     * @var Target
     */
    public $targetSource;

    /**
     * Form class constructor
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\App\Request\Http $request,
        \Naxero\MenuManager\Helper\Links $linksHelper,
        \Naxero\MenuManager\Model\Config\Backend\Source\LinkType $linkTypeSource,
        \Naxero\MenuManager\Model\Config\Backend\Source\Sublayout $sublayoutSource,
        \Naxero\MenuManager\Model\Config\Backend\Source\Blocks $blocksSource,
        \Naxero\MenuManager\Model\Config\Backend\Source\Target $targetSource,
        array $data = []
    ) {

        parent::__construct($context, $data);

        $this->request = $request;
        $this->linksHelper = $linksHelper;
        $this->linkTypeSource = $linkTypeSource;
        $this->sublayoutSource = $sublayoutSource;
        $this->blocksSource = $blocksSource;
        $this->targetSource = $targetSource;
    }

    /**
     * Get a link data.
     */
    public function getLinkData() {
        // Prepare variables
        $data = $this->getData('link_data');
        if ((int) $data['entity_id'] > 0) {
            $data = $this->linksHelper->getLink($data['entity_id'])->getData();
        }

        return $data;
    }
}

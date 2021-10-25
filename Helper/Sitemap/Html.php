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

namespace Naxero\MenuManager\Helper\Sitemap;

use Magento\Sitemap\Model\Source\Product\Image\IncludeImage;

/**
 * Class Sitemap HTML helper.
 */
class Html extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var Links
     */
    public $linksHelper;

    /**
     * Sitemap HTML helper class constructor.
     */
    public function __construct(
        \Naxero\MenuManager\Helper\Links $linksHelper
    ) {
        $this->linksHelper = $linksHelper;
    }
}

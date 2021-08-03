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

namespace Naxero\MenuManager\Block\Adminhtml\Menu\Edit\Fields;

/**
 * Html form field class.
 */
class Html extends \Magento\Framework\Data\Form\Element\AbstractElement
{
   /**
    * Get the after element html.
    */
    public function getElementHtml()
    {
        return $this->getData('html');
    }
}

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

use Naxero\MenuManager\Block\Adminhtml\Menu\Edit\Modal\Generate;

/**
 * MenuLinks block.
 */
class MenuLinks extends \Magento\Backend\Block\Template
{
    /**
     * Render the generator modal form
     */
    public function renderGeneratorForm()
    {
        // Get the menu ID
        $menuId = $this->getRequest()->getParam('id');

        // Return the HTML
        return $this->getLayout()
        ->createBlock(Generate::class)
        ->setTemplate('Naxero_MenuManager::menu/edit/modal/generate.phtml')
        ->setData('menu_id', $menuId)
        ->toHtml();
    }
}

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

namespace Naxero\MenuManager\Helper;

use Naxero\MenuManager\Helper\Config;

/**
 * Class User helper.
 */
class User extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var AuthorizationLink
     */
    public $authLink;

    /**
     * @var Resolver
     */
    public $localeResolver;

    /**
     * @var Session
     */
    public $customerSession;

    /**
     * @var Config
     */
    public $configHelper;

    /**
     * Block helper class constructor.
     */
    public function __construct(
        \Magento\Customer\Block\Account\AuthorizationLink $authLink,
        \Magento\Framework\Locale\Resolver $localeResolver,
        \Magento\Customer\Model\Session $customerSession,
        \Naxero\MenuManager\Helper\Config $configHelper
    ) {
        $this->authLink = $authLink;
        $this->localeResolver = $localeResolver;
        $this->customerSession = $customerSession;
        $this->configHelper = $configHelper;
    }

    /**
     * Get the user locale.
     */
    public function getUserLanguage()
    {
        return $this->localeResolver->getLocale();
    }

    /**
     * Check if the cusomer is logged in.
     */
    public function isLoggedIn()
    {
        return $this->authLink->isLoggedIn();
    }

    /**
     * Check if the customer group is valid for button display.
     */
    public function userHasGroup($groups)
    {
        // Groups string to array
        $groups = explode(',', $groups);

        // Get the current user group id
        $cutomerGroupId = $this->customerSession
            ->getCustomer()->getGroupId();

        // Return the check
        return in_array($cutomerGroupId, $groups)
        || ($this->isLoggedIn() && in_array('registered', $groups))
        || $groups[0] == 'all';
    }
}

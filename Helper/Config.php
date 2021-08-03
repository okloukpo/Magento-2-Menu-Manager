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

use Magento\Framework\Module\Dir;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\UrlInterface;
/**
 * Class Config helper.
 */
class Config extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * Module name
     */
    const MODULE_NAME = 'Naxero_MenuManager';

    /**
     * Module alias
     */
    const MODULE_ALIAS = 'naxero_mm';

    /**
     * Module path
     */
    const MODULE_PATH = 'Naxero\MenuManager';

    /**
     * Module route
     */
    const MODULE_ROUTE = 'naxero-mm';

    /**
     * Module tag
     */
    const MODULE_TAG = 'naxero_mm';

    /**
     * Module title
     */
    const MODULE_TITLE = 'Naxero Menu Manager';

    /**
     * @var String
     */
    const CONFIG_FILE_NAME = 'config.xml';

    /**
     * @var String
     */
    const LINK_ENTITY_TABLE = 'naxero_menumanager_links';

    /**
     * @var String
     */
    const MENU_ENTITY_TABLE = 'naxero_menumanager_menus';   

    /**
     * @var String
     */
    const SITEMAP_ENTITY_TABLE = 'naxero_menumanager_sitemaps';   

    /**
     * @var Session
     */
	public $backendAuthSession;

    /**
     * @var Filesystem
     */
    public $filesystem;

    /**
     * @var Validator
     */
    public $formKeyValidator;

    /**
     * @var FormKey
     */
    public $formKey;

    /**
     * @var Repository
     */
    public $assetRepository;

    /**
     * @var ScopeConfigInterface
     */
    public $scopeConfig;

    /**
     * @var Parser
     */
    public $xmlParser;

    /**
     * @var Dir
     */
    public $moduleDirReader;

    /**
     * @var ResourceConnection
     */
    public $resourceConnection;

    /**
     * @var Stores
     */
	public $storesHelper;

    /**
     * Class Config constructor.
     */
    public function __construct(
        \Magento\Backend\Model\Auth\Session $backendAuthSession,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Magento\Framework\Data\Form\FormKey $formKey,
        \Magento\Framework\View\Asset\Repository $assetRepository,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\Xml\Parser $xmlParser,
        \Magento\Framework\Module\Dir\Reader $moduleDirReader,
        \Magento\Framework\App\ResourceConnection $resourceConnection,
        \Naxero\MenuManager\Helper\Stores $storesHelper
    ) {
        $this->backendAuthSession = $backendAuthSession;
        $this->filesystem = $filesystem;
        $this->formKeyValidator = $formKeyValidator;
        $this->formKey = $formKey;
        $this->assetRepository = $assetRepository;
        $this->scopeConfig = $scopeConfig;
        $this->xmlParser = $xmlParser;
        $this->moduleDirReader = $moduleDirReader;
        $this->resourceConnection = $resourceConnection;
        $this->storesHelper = $storesHelper;
    }

    /**
     * Generate a form key.
     */
    public function getFormKey()
    {
        return $this->formKey->getFormKey();
    }

    /**
     * Check if a request is valid
     */
    public function isValidRequest($request)
    {
        return $this->formKeyValidator->validate($request);
    }

    /**
     * Check if an AJAX request is valid
     */
    public function isValidAjaxRequest($request)
    {
        return $this->isValidRequest($request)
        && $request->isAjax();
    }

    /**
     * Check if an admin request is valid
     */
    public function isValidAdminRequest($request)
    {
        return $this->isValidRequest($request) 
        && $this->isAdminRequest();
    }

    /**
     * Check if an admin AJAX request is valid
     */
    public function isValidAdminAjaxRequest($request)
    {
        return $this->isValidAjaxRequest($request)
        && $this->isAdminRequest();
    }

    /**
     * Check if a request is admin
     */
    public function isAdminRequest()
    {
        return $this->backendAuthSession->isLoggedIn();
    }

    /**
     * Get a module configuration value.
     */
    public function value($field, $core = false)
    {
        // Get the path
        $path = !$core 
        ? self::MODULE_TAG . DIRECTORY_SEPARATOR . $field 
        : $field;

        return $this->scopeConfig->getValue(
            $path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get a module configuration array value.
     */
    public function arrayValue($field, $core = false)
    {
        // Get the path
        $path = !$core 
        ? self::MODULE_TAG . DIRECTORY_SEPARATOR . $field 
        : $field;

        $value = $this->scopeConfig->getValue(
            $path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        return explode(',', $value);
    }

    /**
     * Get all module configuration values.
     */
    public function getValues()
    {
        // Load the config data
        $output = [];
        $configData = $this->getConfigFieldsList();

        // Update the array with dataCategoryView values
        foreach ($configData as $group => $fields) {
            $output[$group] = [];
            foreach ($fields as $key => $value) {
                $v = $this->value($group . '/' . $key);
                $output[$group][$key] = $this->toBooleanFilter($v);
            }
        }

        return $output;
    }

    /**
     * Get the config fields array.
     */
    public function getConfigFieldsList()
    {
        return $this->xmlParser
        ->load($this->getFilePath(self::CONFIG_FILE_NAME))
        ->xmlToArray()['config']['_value']['default'][self::MODULE_TAG];
    }

    /**
     * Convert a value to boolean.
     */
    public function toBooleanFilter($value)
    {
        return $value == '1' || $value == '0'
        ? filter_var($value, FILTER_VALIDATE_BOOLEAN)
        : $value;
    }

    /**
     * Get an icon URL.
     */
    public function getIconUrl($fileName)
    {
        // Prepare the file path
        $url = self::MODULE_NAME . '::images' 
        . DIRECTORY_SEPARATOR . $fileName;
    
        // Return the URL
        return $this->assetRepository->getUrl($url);
    }

    /**
     * Finds a file path from file name.
     *
     * @param string $fileName
     * @return string
     */
    public function getFilePath($fileName, $moduleSubdir = Dir::MODULE_ETC_DIR)
    {
        return $this->getModuleDir() . DIRECTORY_SEPARATOR . $fileName;
    }

    /**
     * Get the upload path.
     */
    public function getUploadPath()
    {
        return $this->getMediaPath() . 'naxero'
        . DIRECTORY_SEPARATOR . 'menu-manager';   
    }

    /**
     * Get the core media directory.
     */
    function getMediaPath() {
        return $this->filesystem
        ->getDirectoryRead(DirectoryList::MEDIA)
        ->getAbsolutePath();
    }

    /**
     * Get the URL of a file in the media directory.
     */
    function getUploadUrl() {
        return $this->storesHelper->getStore()
        ->getBaseUrl(UrlInterface::URL_TYPE_MEDIA)
        . DIRECTORY_SEPARATOR . 'naxero'
        . DIRECTORY_SEPARATOR . 'menu-manager';
    }

    /**
     * Get the module directory.
     */
    public function getModuleDir()
    {
        return $this->moduleDirReader->getModuleDir(
            '',
            self::MODULE_NAME
        );
    }

    /**
     * Check if the module is enabled.
     */
    public function moduleEnabled()
    {
        return (bool) $this->value('general/enabled');
    }

    /**
     * Check if the CLI can run module commands.
     */
    public function canRunCommand()
    {
        return $this->moduleEnabled();
    }

    /**
     * Get an entity table fields.
     */
    public function getEntityFields($tableName, $primaryKey = true)
    {
        // Get the connection parameters
        $connection  = $this->resourceConnection->getConnection();
        $table = $connection->getTableName($tableName);

        // Get the fields array
        $fields = array_keys(
            $connection->describeTable($table)
        );

        // Handle the PK argument
        if (!$primaryKey) {
            unset($fields[0]);
        }

        return $fields;
    }
}

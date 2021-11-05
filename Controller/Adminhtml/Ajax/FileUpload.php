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

namespace Naxero\MenuManager\Controller\Adminhtml\Ajax;

use Naxero\MenuManager\Helper\Config;

/**
 * FileUpload field class
 */
class FileUpload extends \Magento\Backend\App\Action
{
    /**
     * @var UploaderFactory
     */
    public $uploaderFactory;

    /**
     * @var JsonFactory
     */
    public $jsonFactory;

    /**
     * @var Config
     */
    public $configHelper;

    /**
     * @var Block
     */
    public $blockHelper;
    
    /**
     * @var Links
     */
    public $linksHelper;

    /**
     * @var Array
     */
    public $params;

    /**
     * FileUpload field class constructor
     *
     * @param Context $context
     * @param UploaderFactory $uploaderFactory
     * @param JsonFactory $jsonFactory
     * @param Config $configHelper
     * @param Block $blockHelper
     * @param Links $linksHelper
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory,
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \Naxero\MenuManager\Helper\Config $configHelper,
        \Naxero\MenuManager\Helper\Block $blockHelper,
        \Naxero\MenuManager\Helper\Links $linksHelper
    ) {
        parent::__construct($context);

        $this->uploaderFactory = $uploaderFactory;
        $this->jsonFactory = $jsonFactory;
        $this->configHelper = $configHelper;
        $this->blockHelper = $blockHelper;
        $this->linksHelper = $linksHelper;
    }

    /**
     * Index action
     */
    public function execute()
    {
        // Prepare parameters
        $response = [];
        $request = $this->getRequest();
        $this->params = $request->getParams();

        // Process the request
        if ($this->configHelper->isValidAdminAjaxRequest($request)) {
            $response = $this->uploadFile($request);
        } else {
            return $this->getErrorResponse(
                __('Invalid or expired request. Try refreshing the page.')
            );
        }

        return $this->jsonFactory->create()->setData($response);
    }

    /**
     * Upload a file.
     *
     * @param object $request
     */
    public function uploadFile($request)
    {
        // Prepare variables
        $fileData = $request->getFiles($this->params['file_id']);

        // File upload
        try {
            $uploader = $this->uploaderFactory->create([
                'fileId' => $this->params['file_id']
                ])
                ->setAllowCreateFolders(true)
                ->setAllowedExtensions(['jpg', 'png', 'gif']);
                
            // Save the uploaded file
            $uploader->save(
                $this->linksHelper->getUploadDir($this->params),
                $fileData['name']
            );

            return $this->getUploadResponse($uploader);
        } catch (\Exception $e) {
            return $this->getErrorResponse(
                __($e->getMessage())
            );
        }

        return $this->getErrorResponse();
    }

    /**
     * Get the upload response.
     *
     * @param object $uploader
     */
    public function getUploadResponse($uploader)
    {
        // Get the file name
        $fileName = $uploader->getUploadedFileName();
        $fileUrl = $this->linksHelper->getUploadUrl($this->params)
        . '/' . $fileName;
        
        // Validate
        if (!empty($fileName)) {
            return [
                'success' => true,
                'file_url' => $fileUrl,
                'file_name' => $fileName
            ];
        }

        return $this->getErrorResponse();
    }

    /**
     * Get the error response.
     *
     * @param string $msg
     */
    public function getErrorResponse($msg = null)
    {
        // Ddefault error message
        $msg = $msg ? $msg
        : __('Server upload error. Please try again or check the logs.');
    
        // Error response array
        return [
            'success' => false,
            'msg' => $this->blockHelper->getErrorHtml($msg)
        ];
    }
}

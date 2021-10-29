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

/**
 * Class Tools helper.
 */
class Tools extends \Magento\Framework\App\Helper\AbstractHelper
{

    /**
     * Convert an array to CSV format
     *
     * @param array $data
     * @param string $delimiter
     * @param string $enclosure
     * @param string $escapeChar
     * @return string
     */
    public function arrayTocsv($data, $delimiter = ',', $enclosure = '"', $escapeChar = "\\")
    {
        $f = fopen('php://memory', 'r+');
        foreach ($data as $item) {
            fputcsv($f, $item, $delimiter, $enclosure, $escapeChar);
        }
        rewind($f);
        
        return stream_get_contents($f);
    }

    /**
     * Sanitize a file name
     *
     * @param string $str
     * @return string
     */
    public function sanitizeFileName($str)
    {
        $strip = ["~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
            "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
            "â€”", "â€“", ",", "<", ".", ">", "/", "?"];
        $clean = trim(str_replace($strip, "", strip_tags($str)));
        $clean = preg_replace('/\s+/', "-", $clean);

        return $clean;
    }
}

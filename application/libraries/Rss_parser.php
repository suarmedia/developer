<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Library feed reader
 */

require APPPATH . "third_party/Rss-parser/Feed.php";
require APPPATH . "third_party/Rss-parser/embed/autoloader.php";

// Load all required Feed classes
use YuzuruS\Rss\Feed;

class Rss_parser
{
    /**
     * @return  feed
     **/
    public function get_feeds($url)
    {
        try {
            $ua = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.106 Safari/537.36';
            return Feed::load($url, $ua, true);
        } catch (Exception $e) {
            return false;
        }
    }

    public function get_feed_image($url)
    {
        try {
            return Feed::getImgFromOg($url);
        } catch (Exception $e) {
            return false;
        }
    }

}

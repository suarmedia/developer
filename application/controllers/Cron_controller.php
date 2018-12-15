<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cron_controller extends Home_Core_Controller
{

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Get Feed Posts
     */
    public function check_feed_posts()
    {
        //load the library
        $this->load->library('rss_parser');
        $feeds = $this->rss_model->get_feeds();

        foreach ($feeds as $feed) {
            if (!empty($feed->feed_url) && $feed->auto_update == 1) {
                $this->rss_model->add_rss_feed_posts($feed, "cron");
            }
        }
        reset_cache_data_on_change();
    }


    /**
     * Update Sitemap
     */
    public function update_sitemap()
    {
        $this->load->model('sitemap_model');
        $this->sitemap_model->update_sitemap();
    }
}

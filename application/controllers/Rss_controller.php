<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rss_controller extends Admin_Core_Controller
{
    public function __construct()
    {
        parent::__construct();
        //load the library
        $this->load->library('rss_parser');
    }

    /**
     * Import Feed
     */
    public function import_feed()
    {
        check_permission('rss_feeds');
        $data['title'] = trans("import_rss_feed");
        $data['top_categories'] = $this->category_model->get_top_categories();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/rss/import_feed', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Import Feed Post
     */
    public function import_feed_post()
    {
        check_permission('rss_feeds');
        if ($this->rss_model->add_feed()) {
            $last_id = $this->db->insert_id();
            $this->rss_model->add_feed_posts($last_id);

            $this->session->set_flashdata('success', trans("feed") . " " . trans("msg_suc_added"));
            reset_cache_data_on_change();
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }


    /**
     * RSS Feeds
     */
    public function feeds()
    {
        check_permission('rss_feeds');
        $data['title'] = trans("rss_feeds");
        $data['feeds'] = $this->rss_model->get_feeds();
        $data['lang_search_column'] = 3;

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/rss/feeds', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Update RSS Feed
     */
    public function update_feed($id)
    {
        check_permission('rss_feeds');
        $data["feed"] = $this->rss_model->get_feed($id);
        if (empty($data["feed"])) {
            redirect($this->agent->referrer());
        }

        $data['title'] = trans("update_rss_feed");
        $data['categories'] = $this->category_model->get_top_categories_by_lang($data['feed']->lang_id);
        $data['subcategories'] = $this->category_model->get_subcategories_by_parent_id($data["feed"]->category_id);

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/rss/update_feed', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Update RSS Feed Post
     */
    public function update_feed_post()
    {
        check_permission('rss_feeds');
        $id = $this->input->post('id', true);
        if ($this->rss_model->update_feed($id)) {
            $this->rss_model->update_feed_posts_button($id);
            $this->session->set_flashdata('success', trans("feed") . " " . trans("msg_suc_updated"));
            reset_cache_data_on_change();
            redirect(admin_url() . 'feeds');
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }


    /**
     * Get Feed Posts
     */
    public function check_feed_posts()
    {
        check_permission('rss_feeds');
        $id = $this->input->post('id', true);
        $feed = $this->rss_model->get_feed($id);
        if ($this->rss_model->add_rss_feed_posts($feed, "update")) {
            $this->session->set_flashdata('success', trans("feed") . " " . trans("msg_suc_updated"));
            reset_cache_data_on_change();
        }
        redirect($this->agent->referrer());

    }


    /**
     * Delete Feed
     */
    public function delete_feed_post()
    {
        if (!check_user_permission('rss_feeds')) {
            exit();
        }
        $id = $this->input->post('id', true);
        if ($this->rss_model->delete_feed($id)) {
            $this->session->set_flashdata('success', trans("feed") . " " . trans("msg_suc_deleted"));
            reset_cache_data_on_change();
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }
}
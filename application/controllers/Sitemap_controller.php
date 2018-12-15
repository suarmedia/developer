<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sitemap_controller extends Admin_Core_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_permission('seo_tools');
        $this->load->model('sitemap_model');
    }


    /**
     * Generate Sitemap
     */
    public function generate_sitemap()
    {
        $data['title'] = trans("generate_sitemap");

        $this->load->view('admin/_header', $data);
        $this->load->view('admin/generate_sitemap', $data);
        $this->load->view('admin/_footer');
    }


    /**
     * Generate Sitemap Post
     */
    public function generate_sitemap_post()
    {
        $process = $this->input->post('process', true);
        if ($process == "generate"):

            $this->sitemap_model->download_sitemap();

        elseif ($process == "update"):

            $this->sitemap_model->update_sitemap();

            $this->session->set_flashdata('success_form', trans("sitemap") . " " . trans("msg_suc_updated"));
            redirect($this->agent->referrer());
        endif;
    }
}


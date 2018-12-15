<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Core_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //settings
        $global_data['general_settings'] = $this->settings_model->get_general_settings();
        $this->general_settings = $global_data['general_settings'];
        //set timezone
        date_default_timezone_set($this->general_settings->timezone);
        //lang base url
        $global_data['lang_base_url'] = base_url();
        //languages
        $global_data['languages'] = $this->language_model->get_active_languages();
        //site lang
        $global_data['site_lang'] = $this->language_model->get_language($this->general_settings->site_lang);
        if (empty($global_data['site_lang'])) {
            $global_data['site_lang'] = $this->language_model->get_language('1');
        }
        $global_data['selected_lang'] = $global_data['site_lang'];

        //set language
        $lang_segment = $this->uri->segment(1);
        foreach ($global_data['languages'] as $lang) {
            if ($lang_segment == $lang->short_form) {
                if ($this->general_settings->multilingual_system == 1):
                    $global_data['selected_lang'] = $lang;
                    $global_data['lang_base_url'] = base_url() . $lang->short_form . "/";
                else:
                    redirect(base_url());
                endif;
            }
        }
        $this->selected_lang = $global_data['selected_lang'];
        $this->lang_base_url = $global_data['lang_base_url'];
        if (!file_exists(APPPATH . "language/" . $this->selected_lang->folder_name)) {
            echo "Language folder doesn't exists!";
            exit();
        }
        $this->config->set_item('language', $global_data['selected_lang']->folder_name);
        $this->lang->load("site_lang", $global_data['selected_lang']->folder_name);

        $global_data['rtl'] = false;
        if ($global_data['selected_lang']->text_direction == "rtl") {
            $global_data['rtl'] = true;
        }
        $this->rtl = $global_data['rtl'];
        $this->language_id = $global_data['selected_lang']->id;

        //set lang base url
        if ($this->general_settings->site_lang == $this->language_id) {
            $global_data['lang_base_url'] = base_url();
        } else {
            $global_data['lang_base_url'] = base_url() . $global_data['selected_lang']->short_form . "/";
        }
        $this->lang_base_url = $global_data['lang_base_url'];

        //check remember
        $this->auth_model->check_remember();

        //check auth
        $this->auth_check = auth_check();
        if ($this->auth_check) {
            $this->auth_user = user();
        }

        $global_data['vsettings'] = $this->visual_settings_model->get_settings();
        $global_data['settings'] = $this->settings_model->get_settings($global_data['selected_lang']->id);
        $this->settings = $global_data['settings'];

        //get site primary font
        $this->config->load('fonts');
        $global_data['primary_font'] = $this->general_settings->primary_font;
        $global_data['primary_font_family'] = $this->config->item($global_data['primary_font'] . '_font_family');
        $global_data['primary_font_url'] = $this->config->item($global_data['primary_font'] . '_font_url');

        //get site secondary font
        $global_data['secondary_font'] = $this->general_settings->secondary_font;
        $global_data['secondary_font_family'] = $this->config->item($global_data['secondary_font'] . '_font_family');
        $global_data['secondary_font_url'] = $this->config->item($global_data['secondary_font'] . '_font_url');

        //get site tertiary font
        $global_data['tertiary_font'] = $this->general_settings->tertiary_font;
        $global_data['tertiary_font_family'] = $this->config->item($global_data['tertiary_font'] . '_font_family');
        $global_data['tertiary_font_url'] = $this->config->item($global_data['tertiary_font'] . '_font_url');

        //bg images
        $global_data["img_bg_mid"] = base_url() . "assets/img/img_bg_mid.jpg";
        $global_data["img_bg_sm"] = base_url() . "assets/img/img_bg_sm.jpg";
        $global_data["img_bg_sl"] = base_url() . "assets/img/img_bg_sl.jpg";
        $global_data["img_bg_lg"] = base_url() . "assets/img/img_bg_lg.jpg";
        $global_data["img_bg_sm_footer"] = base_url() . "assets/img/img_bg_sm_footer.jpg";

        //update last seen
        $this->auth_model->update_last_seen();

        $this->load->vars($global_data);
    }

}

class Home_Core_Controller extends Core_Controller
{
    public function __construct()
    {
        parent::__construct();

        //categories
        $this->categories = get_cached_data('categories');
        if (empty($this->categories)) {
            $this->categories = $this->category_model->get_categories();
            set_cache_data('categories', $this->categories);
        }
        //pages
        $this->pages = get_cached_data('pages');
        if (empty($this->pages)) {
            $this->pages = $this->page_model->get_pages();
            set_cache_data('pages', $this->pages);
        }
        //menu links
        $this->menu_links = get_cached_data('menu_links');
        if (empty($this->menu_links)) {
            $this->menu_links = $this->navigation_model->get_menu_links();
            set_cache_data('menu_links', $this->menu_links);
        }
        //total post count
        $this->total_posts_count = get_cached_data('total_posts_count');
        if (empty($this->total_posts_count)) {
            $this->total_posts_count = $this->post_model->get_post_count_by_lang($this->selected_lang->id);
            set_cache_data('total_posts_count', $this->total_posts_count);
        }
        //random posts
        $this->random_posts = get_cached_data('random_posts');
        if (empty($this->random_posts)) {
            $this->random_posts = $this->post_model->get_random_posts(15);
            set_cache_data('random_posts', $this->random_posts);
        }
        //popular posts
        $this->popular_posts_week = get_cached_data('popular_posts_week');
        if (empty($this->popular_posts_week)) {
            $this->popular_posts_week = $this->post_model->get_popular_posts(7);
            set_cache_data('popular_posts_week', $this->popular_posts_week);
        }
        $this->popular_posts_month = get_cached_data('popular_posts_month');
        if (empty($this->popular_posts_month)) {
            $this->popular_posts_month = $this->post_model->get_popular_posts(30);
            set_cache_data('popular_posts_month', $this->popular_posts_month);
        }
        $this->popular_posts_year = get_cached_data('popular_posts_year');
        if (empty($this->popular_posts_year)) {
            $this->popular_posts_year = $this->post_model->get_popular_posts(365);
            set_cache_data('popular_posts_year', $this->popular_posts_year);
        }
        //recommended posts
        $this->recommended_posts = get_cached_data('recommended_posts');
        if (empty($this->recommended_posts)) {
            $this->recommended_posts = $this->post_model->get_recommended_posts();
            set_cache_data('recommended_posts', $this->recommended_posts);
        }
        //category posts
        $this->category_posts = get_cached_data('category_posts');
        if (empty($this->category_posts)) {
            $this->category_posts = $this->generate_posts_array_by_category();
            set_cache_data('category_posts', $this->category_posts);
        }
        //widgets
        $this->widgets = get_cached_data('widgets');
        if (empty($this->widgets)) {
            $this->widgets = $this->widget_model->get_widgets();
            set_cache_data('widgets', $this->widgets);
        }
        //random tags
        $this->random_tags = get_cached_data('random_tags');
        if (empty($this->random_tags)) {
            $this->random_tags = $this->tag_model->get_random_tags();
            set_cache_data('random_tags', $this->random_tags);
        }
        $global_data['polls'] = $this->poll_model->get_polls();

        //Social Login
        $global_data['fb_login_state'] = 0;
        $global_data['google_login_state'] = 0;

        if (!empty($this->general_settings->facebook_app_id)) {
            $global_data['fb_login_state'] = 1;
        }
        if (!empty($this->general_settings->google_client_id)) {
            $global_data['google_login_state'] = 1;
        }
        //recaptcha status
        $global_data['recaptcha_status'] = true;
        if (empty($this->general_settings->recaptcha_site_key) || empty($this->general_settings->recaptcha_secret_key)) {
            $global_data['recaptcha_status'] = false;
        }
        $this->recaptcha_status = $global_data['recaptcha_status'];
        /*
        if (!get_ft_tags()) {
            echo "Invalid License Key";
            exit();
        }
        */
        $this->load->vars($global_data);
    }

    //generate posts array by category
    public function generate_posts_array_by_category()
    {
        $array_posts = array();
        if (!empty($this->categories)) {
            foreach ($this->categories as $category) {
                $array_posts['category_' . $category->id] = get_latest_posts_by_category($category, 8);
            }
        }
        return $array_posts;
    }

    //verify recaptcha
    public function recaptcha_verify_request()
    {
        if (!$this->recaptcha_status) {
            return true;
        }

        $this->load->library('recaptcha');
        $recaptcha = $this->input->post('g-recaptcha-response');
        if (!empty($recaptcha)) {
            $response = $this->recaptcha->verifyResponse($recaptcha);
            if (isset($response['success']) && $response['success'] === true) {
                return true;
            }
        }
        return false;
    }

    public function paginate($url, $total_rows)
    {
        $per_page = $this->general_settings->pagination_per_page;
        //initialize pagination
        $page = $this->security->xss_clean($this->input->get('page'));
        if (empty($page)) {
            $page = 0;
        }
        if ($page != 0) {
            $page = $page - 1;
        }
        $config['num_links'] = 4;
        $config['base_url'] = $url;
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['reuse_query_string'] = true;
        $this->pagination->initialize($config);
        return array('per_page' => $per_page, 'offset' => $page * $per_page, 'current_page' => $page + 1);
    }

}

class Admin_Core_Controller extends Core_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!auth_check()) {
            redirect(admin_url() . "login");
        }
        cls_category();
        $global_data['images'] = $this->file_model->get_images(48);
        $global_data['audios'] = $this->file_model->get_audios(48);
        $global_data['videos'] = $this->file_model->get_videos(48);
        $this->load->vars($global_data);
    }

    public function paginate($url, $total_rows)
    {
        //initialize pagination
        $page = $this->security->xss_clean($this->input->get('page'));
        $per_page = $this->input->get('show', true);
        if (empty($page)) {
            $page = 0;
        }

        if ($page != 0) {
            $page = $page - 1;
        }

        if (empty($per_page)) {
            $per_page = 15;
        }

        $config['num_links'] = 4;
        $config['base_url'] = $url;
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['reuse_query_string'] = true;
        $this->pagination->initialize($config);

        return array('per_page' => $per_page, 'offset' => $page * $per_page);
    }
}


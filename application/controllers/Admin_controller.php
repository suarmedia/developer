<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_controller extends Admin_Core_Controller
{

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Index Page
     */
    public function index()
    {
        check_permission('admin_panel');
        $data['title'] = trans("index");
        $data['last_comments'] = $this->comment_model->get_last_comments(5);
        $data['last_contacts'] = $this->contact_model->get_last_contact_messages();
        $data['last_users'] = $this->auth_model->get_last_users();
        $data['post_count'] = $this->post_admin_model->get_posts_count();
        $data['pending_post_count'] = $this->post_admin_model->get_pending_posts_count();
        $data['drafts_count'] = $this->post_admin_model->get_drafts_count();
        $data['scheduled_post_count'] = $this->post_admin_model->get_scheduled_posts_count();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Navigation
     */
    public function navigation()
    {
        check_permission('navigation');
        $data['title'] = trans("navigation");
        $data['menu_links'] = $this->navigation_model->get_menu_links_for_admin();
        $data['lang_search_column'] = 3;

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/navigation/navigation', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Add Menu Link Post
     */
    public function add_menu_link_post()
    {
        check_permission('navigation');
        //validate inputs
        $this->form_validation->set_rules('title', trans("title"), 'required|xss_clean|max_length[500]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors_form', validation_errors());
            $this->session->set_flashdata('form_data', $this->navigation_model->input_values());
        } else {
            if ($this->navigation_model->add_link()) {
                $this->session->set_flashdata('success_form', trans("link") . " " . trans("msg_suc_added"));
                reset_cache_data_on_change();
            } else {
                $this->session->set_flashdata('form_data', $this->navigation_model->input_values());
                $this->session->set_flashdata('error_form', trans("msg_error"));
            }
        }
        redirect($this->agent->referrer());
    }


    /**
     * Update Menu Link
     */
    public function update_menu_link($id)
    {
        check_permission('navigation');
        $data['title'] = trans("navigation");
        $data['page'] = $this->page_model->get_page_by_id($id);
        $data['menu_links'] = $this->navigation_model->get_menu_links_by_lang($data['page']->lang_id);

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/navigation/update_navigation', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Update Menü Link Post
     */
    public function update_menu_link_post()
    {
        check_permission('navigation');
        //validate inputs
        $this->form_validation->set_rules('title', trans("title"), 'required|xss_clean|max_length[500]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors_form', validation_errors());
            $this->session->set_flashdata('form_data', $this->navigation_model->input_values());
            redirect($this->agent->referrer());
        } else {
            $id = $this->input->post('id', true);

            if ($this->navigation_model->update_link($id)) {
                $this->session->set_flashdata('success', trans("link") . " " . trans("msg_suc_updated"));
                reset_cache_data_on_change();
                redirect(admin_url() . "navigation");
            } else {
                $this->session->set_flashdata('form_data', $this->navigation_model->input_values());
                $this->session->set_flashdata('error_form', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }


    /**
     * Delete Navigation Post
     */
    public function delete_navigation_post()
    {
        if (!check_user_permission('navigation')) {
            exit();
        }
        $id = $this->input->post('id', true);
        $data["page"] = $this->page_model->get_page_by_id($id);

        //check if exists
        if (empty($data['page'])) {
            redirect($this->agent->referrer());
        }

        if ($this->page_model->delete($id)) {
            $this->session->set_flashdata('success', trans("link") . " " . trans("msg_suc_deleted"));
            reset_cache_data_on_change();
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }


    /**
     * Menu Limit Post
     */
    public function menu_limit_post()
    {
        check_permission('navigation');
        if ($this->navigation_model->update_menu_limit()) {
            $this->session->set_flashdata('success_form', trans("menu_limit") . " " . trans("msg_suc_updated"));
            $this->session->set_flashdata("mes_menu_limit", 1);
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('form_data', $this->navigation_model->input_values());
            $this->session->set_flashdata("mes_menu_limit", 1);
            $this->session->set_flashdata('error_form', trans("msg_error"));
            redirect($this->agent->referrer());
        }

    }


    //get menu links by language
    public function get_menu_links_by_lang()
    {
        $lang_id = $this->input->post('lang_id', true);
        if (!empty($lang_id)):
            $menu_links = $this->navigation_model->get_menu_links_by_lang($lang_id);
            foreach ($menu_links as $item):
                if ($item["type"] != "category" && $item["location"] == "main" && $item['parent_id'] == "0"):
                    echo ' <option value="' . $item["id"] . '">' . $item["title"] . '</option>';
                endif;
            endforeach;
        endif;
    }


    /**
     * Comments
     */
    public function comments()
    {
        check_permission('comments_contact');
        $data['title'] = trans("comments");
        $data['comments'] = $this->comment_model->get_all_comments();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/comments', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Delete Comment Post
     */
    public function delete_comment_post()
    {
        if (!check_user_permission('comments_contact')) {
            exit();
        }
        $id = $this->input->post('id', true);
        if ($this->comment_model->delete_comment($id)) {
            $this->session->set_flashdata('success', trans("comment") . " " . trans("msg_suc_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }


    /**
     * Contact Messages
     */
    public function contact_messages()
    {
        check_permission('comments_contact');
        $data['title'] = trans("contact_messages");
        $data['messages'] = $this->contact_model->get_contact_messages();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/contact_messages', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Delete Contact Message Post
     */
    public function delete_contact_message_post()
    {
        if (!check_user_permission('comments_contact')) {
            exit();
        }
        $id = $this->input->post('id', true);

        if ($this->contact_model->delete_contact_message($id)) {
            $this->session->set_flashdata('success', trans("message") . " " . trans("msg_suc_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }


    /**
     * Ads
     */
    public function ad_spaces()
    {
        check_permission('ad_spaces');
        $data['title'] = trans("ad_spaces");
        $data['ad_space'] = $this->input->get('ad_space', true);
        if (empty($data['ad_space'])) {
            redirect(admin_url() . "ad-spaces?ad_space=header");
        }

        $data['ad_codes'] = $this->ad_model->get_ad_codes($data['ad_space']);

        if (empty($data['ad_codes'])) {
            redirect(admin_url() . "ad-spaces");
        }
        if (!get_ft_tags()) {
            exit();
        }
        $data["array_ad_spaces"] = array(
            "header" => trans("header_top_ad_space"),
            "index_top" => trans("index_top_ad_space"),
            "index_bottom" => trans("index_bottom_ad_space"),
            "post_top" => trans("post_top_ad_space"),
            "post_bottom" => trans("post_bottom_ad_space"),
            "posts_top" => trans("posts_top_ad_space"),
            "posts_bottom" => trans("posts_bottom_ad_space"),
            "category_top" => trans("category_top_ad_space"),
            "category_bottom" => trans("category_bottom_ad_space"),
            "tag_top" => trans("tag_top_ad_space"),
            "tag_bottom" => trans("tag_bottom_ad_space"),
            "search_top" => trans("search_top_ad_space"),
            "search_bottom" => trans("search_bottom_ad_space"),
            "profile_top" => trans("profile_top_ad_space"),
            "profile_bottom" => trans("profile_bottom_ad_space"),
            "reading_list_top" => trans("reading_list_top_ad_space"),
            "reading_list_bottom" => trans("reading_list_bottom_ad_space"),
            "sidebar_top" => trans("sidebar_top_ad_space"),
            "sidebar_bottom" => trans("sidebar_bottom_ad_space"),
        );

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/ad_spaces', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Ads Post
     */
    public function ad_spaces_post()
    {
        check_permission('ad_spaces');
        $ad_space = $this->input->post('ad_space', true);
        if ($this->ad_model->update_ad_spaces($ad_space)) {
            $this->session->set_flashdata('success', trans("ad_spaces") . " " . trans("msg_suc_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }

        redirect(admin_url() . "ad-spaces?ad_space=" . $ad_space);
    }


    /**
     * Settings
     */
    public function settings()
    {
        check_permission('settings');
        $data["selected_lang"] = $this->input->get("lang", true);
        if (empty($data["selected_lang"])) {
            $data["selected_lang"] = $this->general_settings->site_lang;
            redirect(admin_url() . "settings?lang=" . $data["selected_lang"]);
        }
        $data['title'] = trans("settings");
        $data['settings'] = $this->settings_model->get_settings($data["selected_lang"]);

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/settings', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Update Settings Post
     */
    public function settings_post()
    {
        check_permission('settings');
        if ($this->settings_model->update_settings()) {
            $this->session->set_flashdata('success', trans("settings") . " " . trans("msg_suc_updated"));
            $this->session->set_flashdata("mes_settings", 1);
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            $this->session->set_flashdata("mes_settings", 1);
            redirect($this->agent->referrer());
        }
    }


    /**
     * Recaptcha Settings Post
     */
    public function recaptcha_settings_post()
    {
        check_permission('settings');
        if ($this->settings_model->update_recaptcha_settings()) {
            $this->session->set_flashdata('success', trans("settings") . " " . trans("msg_suc_updated"));
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }


    /**
     * Cache System
     */
    public function cache_system()
    {
        check_admin();
        $data['title'] = trans("cache_system");
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/cache_system', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Cache System Post
     */
    public function cache_system_post()
    {
        check_admin();
        if ($this->input->post('action', true) == "reset") {
            reset_cache_data();
            $this->session->set_flashdata('success', trans("msg_reset_cache"));
        } else {
            if ($this->settings_model->update_cache_system()) {
                $this->session->set_flashdata('success', trans("msg_updated"));
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
            }
        }
        redirect($this->agent->referrer());
    }


    /**
     * Preferences
     */
    public function preferences()
    {
        check_permission('settings');
        $data['title'] = trans("preferences");
        if (!get_ft_tags()) {
            exit();
        }
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/preferences', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Preferences Post
     */
    public function preferences_post()
    {
        check_permission('settings');
        if ($this->settings_model->update_preferences()) {
            $admin_panel_link = $this->input->post('admin_panel_link', true);
            $this->settings_model->update_admin_panel_link($admin_panel_link);
            $this->session->set_flashdata('success', trans("preferences") . " " . trans("msg_suc_updated"));
            redirect(admin_url() . 'preferences');
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect(admin_url() . 'preferences');
        }
    }


    /**
     * Visual Settings
     */
    public function visual_settings()
    {
        check_permission('settings');
        $data['title'] = trans("visual_settings");
        $data['visual_settings'] = $this->visual_settings_model->get_settings();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/visual_settings', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Update Settings Post
     */
    public function visual_settings_post()
    {
        check_permission('settings');
        if ($this->visual_settings_model->update_settings()) {
            $this->session->set_flashdata('success', trans("visual_settings") . " " . trans("msg_suc_updated"));
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }

    }

    /**
     * Email Settings
     */
    public function email_settings()
    {
        check_permission('settings');
        $data['title'] = trans("email_settings");

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/email_settings', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Update Email Settings Post
     */
    public function email_settings_post()
    {
        check_permission('settings');
        if ($this->settings_model->update_email_settings()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            $this->session->set_flashdata('message_type', "email");
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            $this->session->set_flashdata('message_type', "email");
            redirect($this->agent->referrer());
        }

    }


    /**
     * Update Contact Email Settings Post
     */
    public function contact_email_settings_post()
    {
        check_permission('settings');
        if ($this->settings_model->update_contact_email_settings()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            $this->session->set_flashdata('message_type', "contact");
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            $this->session->set_flashdata('message_type', "contact");
            redirect($this->agent->referrer());
        }
    }


    /**
     * Update Email Verification Settings Post
     */
    public function email_verification_settings_post()
    {
        check_permission('settings');
        if ($this->settings_model->email_verification_settings()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            $this->session->set_flashdata('message_type', "verification");
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            $this->session->set_flashdata('message_type', "verification");
            redirect($this->agent->referrer());
        }
    }


    /*
    *-------------------------------------------------------------------------------------------------
    * NEWSLETTER
    *-------------------------------------------------------------------------------------------------
    */

    /**
     * Send Email to Subscribers
     */
    public function send_email_subscribers()
    {
        check_permission('newsletter');
        $data['title'] = trans("send_email_subscribers");

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/newsletter/send_email', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Subscribers
     */
    public function subscribers()
    {
        check_permission('newsletter');
        $data['title'] = trans("subscribers");
        $data['subscribers'] = $this->newsletter_model->get_subscribers();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/newsletter/subscribers', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Delete Newsletter Post
     */
    public function delete_newsletter_post()
    {
        if (!check_user_permission('newsletter')) {
            exit();
        }
        $id = $this->input->post('id', true);
        $data['newsletter'] = $this->newsletter_model->get_newsletter_by_id($id);

        if (empty($data['newsletter'])) {
            $this->session->set_flashdata('error', trans("msg_error"));
        } else {
            if ($this->newsletter_model->delete_from_newsletter($id)) {
                $this->session->set_flashdata('success', trans("email") . " " . trans("msg_suc_deleted"));
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
            }
        }
    }


    /**
     * Send Email to Subscribers Post
     */
    public function send_email_subscribers_post()
    {
        check_permission('newsletter');
        $subject = $this->input->post('subject', true);
        $message = $this->input->post('message', false);
        $this->load->model("email_model");
        $data['subscribers'] = $this->newsletter_model->get_subscribers();
        foreach ($data['subscribers'] as $item) {
            //send email
            if (!$this->email_model->send_email($item->email, $subject, $message, true, null)) {
                redirect($this->agent->referrer());
                exit();
            }
        }

        $this->session->set_flashdata('success', trans("msg_email_sent"));
        redirect($this->agent->referrer());
    }

    /**
     * Email Preview
     */
    public function email_preview()
    {
        check_permission('newsletter');
        $data["title"] = $this->input->post('title', true);
        $data["content"] = $this->input->post('content', false);
        $data["type"] = "preview";
        $this->load->view('email/email_template', $data);
    }


    /**
     * Seo Tools
     */
    public function seo_tools()
    {
        check_permission('seo_tools');
        $data['title'] = trans("seo_tools");
        $data["selected_lang"] = $this->input->get("lang", true);

        if (empty($data["selected_lang"])) {
            $data["selected_lang"] = $this->general_settings->site_lang;
            redirect(admin_url() . "seo-tools?lang=" . $data["selected_lang"]);
        }

        $data['settings'] = $this->settings_model->get_settings($data["selected_lang"]);


        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/seo_tools', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Seo Tools Post
     */
    public function seo_tools_post()
    {
        check_permission('seo_tools');
        if ($this->settings_model->update_seo_settings()) {
            $this->session->set_flashdata('success', trans("seo_options") . " " . trans("msg_suc_updated"));
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }


    /**
     * Social Login Configuration
     */
    public function social_login_configuration()
    {
        check_admin();
        $data['title'] = trans("social_login_configuration");

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/social_login', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Social Login Configuration Post
     */
    public function social_login_configuration_post()
    {
        check_admin();
        if ($this->settings_model->update_social_settings()) {
            $this->session->set_flashdata('success', trans("configurations") . " " . trans("msg_suc_updated"));
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }

    }


    /**
     * Font Options
     */
    public function font_options()
    {
        check_admin();
        $data['title'] = trans("font_options");

        $this->config->load('fonts');
        $data['fonts'] = $this->config->item('fonts_array');

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/font_options', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Font Options Post
     */
    public function font_options_post()
    {
        check_admin();
        if ($this->settings_model->update_font_settings()) {
            $this->session->set_flashdata('success', trans("fonts") . " " . trans("msg_suc_updated"));
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }


    /**
     * Users
     */
    public function users()
    {
        check_permission('users');
        $data['title'] = trans("users");
        $data['users'] = $this->auth_model->get_users();
        if (!get_ft_tags()) {
            exit();
        }
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/users/users');
        $this->load->view('admin/includes/_footer');

    }


    /**
     * Administrators
     */
    public function administrators()
    {
        check_admin();
        $data['title'] = trans("administrators");
        $data['users'] = $this->auth_model->get_administrators();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/users/administrators');
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Add User
     */
    public function add_user()
    {
        check_admin();
        $data['title'] = trans("add_user");
        $data['roles'] = $this->auth_model->get_roles();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/users/add_user');
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Add User Post
     */
    public function add_user_post()
    {
        check_admin();
        //validate inputs
        $this->form_validation->set_rules('username', trans("username"), 'required|xss_clean|min_length[4]|max_length[100]');
        $this->form_validation->set_rules('email', trans("email_address"), 'required|xss_clean|max_length[200]');
        $this->form_validation->set_rules('password', trans("password"), 'required|xss_clean|min_length[4]|max_length[50]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->auth_model->input_values());
            redirect($this->agent->referrer());
        } else {
            $email = $this->input->post('email', true);
            $username = $this->input->post('username', true);
            //is username unique
            if (!$this->auth_model->is_unique_username($username)) {
                $this->session->set_flashdata('form_data', $this->auth_model->input_values());
                $this->session->set_flashdata('error', trans("message_username_unique_error"));
                redirect($this->agent->referrer());
            }
            //is email unique
            if (!$this->auth_model->is_unique_email($email)) {
                $this->session->set_flashdata('form_data', $this->auth_model->input_values());
                $this->session->set_flashdata('error', trans("message_email_unique_error"));
                redirect($this->agent->referrer());
            }

            //add user
            if ($this->auth_model->add_user()) {
                $this->session->set_flashdata('success', trans("msg_user_added"));
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
            }

            redirect($this->agent->referrer());
        }
    }


    /**
     * Change User Role
     */
    public function change_user_role_post()
    {
        check_permission('users');
        $id = $this->input->post('user_id', true);
        $role = $this->input->post('role', true);
        $user = $this->auth_model->get_user($id);
        //check if exists
        if (empty($user)) {
            redirect($this->agent->referrer());
        } else {
            if ($this->auth_model->change_user_role($id, $role)) {
                $this->session->set_flashdata('success', trans("msg_role_changed"));
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }

    /**
     * Confirm User Email
     */
    public function confirm_user_email()
    {
        $id = $this->input->post('id', true);
        $user = $this->auth_model->get_user($id);
        if ($this->auth_model->verify_email($user)) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }

    /**
     * Ban User Post
     */
    public function ban_user_post()
    {
        if (!check_user_permission('users')) {
            exit();
        }
        $option = $this->input->post('option', true);
        $id = $this->input->post('id', true);

        //if option ban
        if ($option == 'ban') {
            if ($this->auth_model->ban_user($id)) {
                $this->session->set_flashdata('success', trans("msg_user_banned"));
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
            }
        }

        //if option remove ban
        if ($option == 'remove_ban') {
            if ($this->auth_model->remove_user_ban($id)) {
                $this->session->set_flashdata('success', trans("msg_ban_removed"));
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
            }
        }
    }

    /**
     * Edit User
     */
    public function edit_user($id)
    {
        check_permission('users');
        $data['title'] = trans("update_profile");
        $data['user'] = $this->auth_model->get_user($id);

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/users/edit_user');
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Edit User Post
     */
    public function edit_user_post()
    {
        check_permission('users');
        //validate inputs
        $this->form_validation->set_rules('username', trans("username"), 'required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('email', trans("email"), 'required|xss_clean');
        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            redirect($this->agent->referrer());
        } else {
            $data = array(
                'id' => $this->input->post('id', true),
                'username' => $this->input->post('username', true),
                'slug' => $this->input->post('slug', true),
                'email' => $this->input->post('email', true)
            );
            //is email unique
            if (!$this->auth_model->is_unique_email($data["email"], $data["id"])) {
                $this->session->set_flashdata('error', trans("message_email_unique_error"));
                redirect($this->agent->referrer());
                exit();
            }
            //is username unique
            if (!$this->auth_model->is_unique_username($data["username"], $data["id"])) {
                $this->session->set_flashdata('error', trans("msg_username_unique_error"));
                redirect($this->agent->referrer());
                exit();
            }
            //is slug unique
            if ($this->auth_model->check_is_slug_unique($data["slug"], $data["id"])) {
                $this->session->set_flashdata('error', trans("msg_slug_used"));
                redirect($this->agent->referrer());
                exit();
            }

            if ($this->profile_model->edit_user($data["id"])) {
                $this->session->set_flashdata('success', trans("msg_updated"));
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }


    /**
     * Delete User Post
     */
    public function delete_user_post()
    {
        if (!check_user_permission('users')) {
            exit();
        }
        $id = $this->input->post('id', true);
        if ($this->auth_model->delete_user($id)) {
            $this->session->set_flashdata('success', trans("user") . " " . trans("msg_suc_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }


    /**
     * Roles Permissions
     */
    public function roles_permissions()
    {
        check_admin();
        $data['title'] = trans("roles_permissions");
        $data['roles'] = $this->auth_model->get_roles();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/users/roles_permissions');
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Edit Role
     */
    public function edit_role($id)
    {
        check_admin();
        if ($id == 1) {
            redirect(admin_url() . 'roles-permissions');
        }
        $data['title'] = trans("edit_role");
        $data['role'] = $this->auth_model->get_role($id);

        if (empty($data['role'])) {
            redirect(admin_url() . 'roles-permissions');
        }

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/users/edit_role', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Edit Role Post
     */
    public function edit_role_post()
    {
        check_admin();
        $id = $this->input->post('id', true);
        if ($this->auth_model->update_role($id)) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }


    /**
     * Delete Selected Comments
     */
    public function delete_selected_comments()
    {
        if (check_user_permission('comments')) {
            $comment_ids = $this->input->post('comment_ids', true);
            $this->comment_model->delete_multi_comments($comment_ids);
        }
    }


    /**
     * File manager
     */
    public function file_manager()
    {
        $this->load->view('admin/includes/_header');
        $this->load->view('admin/includes/_file_manager_image');
        $this->load->view('admin/includes/_footer');
    }

}
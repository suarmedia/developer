<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_controller extends Home_Core_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Profile Page
     */
    public function profile($slug)
    {
        $slug = $this->security->xss_clean($slug);
        $data['user'] = $this->auth_model->get_user_by_slug($slug);
        if (empty($data["user"])) {
            redirect(lang_base_url());
        }
        $data['title'] = $data['user']->username;
        $data['description'] = $data['user']->username . " - " . $this->settings->site_title;
        $data['keywords'] = $data['user']->username . ', ' . $this->settings->application_name;
        $data["active_tab"] = "products";

        $count_key = 'posts_count_profile' . $data['user']->id;
        $posts_key = 'posts_profile' . $data['user']->id;

        //profile posts count
        $total_rows = get_cached_data($count_key);
        if (empty($total_rows)) {
            $total_rows = $this->post_model->get_post_count_by_user($data['user']->id);
            set_cache_data($count_key, $total_rows);
        }
        //set paginated
        $pagination = $this->paginate(lang_base_url() . 'profile/' . $data["user"]->slug, $total_rows);
        $data['posts'] = get_cached_data($posts_key . '_page' . $pagination['current_page']);
        if (empty($data['posts'])) {
            $data['posts'] = $this->post_model->get_paginated_user_posts($data["user"]->id, $pagination['per_page'], $pagination['offset']);
            set_cache_data($posts_key . '_page' . $pagination['current_page'], $data['posts']);
        }

        $data["user_posts_count"] = $total_rows;
        $data["following"] = $this->profile_model->get_following_users($data['user']->id);
        $data["followers"] = $this->profile_model->get_followers($data['user']->id);

        $this->load->view('partials/_header', $data);
        $this->load->view('profile/profile', $data);
        $this->load->view('partials/_footer');
    }


    /**
     * Update Profile
     */
    public function update_profile()
    {
        //check user
        if (!auth_check()) {
            redirect(lang_base_url());
        }
        $data['title'] = trans("update_profile");
        $data['description'] = trans("update_profile") . " - " . $this->settings->site_title;
        $data['keywords'] = trans("update_profile") . "," . $this->settings->application_name;

        $data["user"] = user();
        if (empty($data["user"])) {
            redirect(lang_base_url());
        }
        $data["active_tab"] = "update_profile";

        $this->load->view('partials/_header', $data);
        $this->load->view('settings/update_profile', $data);
        $this->load->view('partials/_footer');
    }


    /**
     * Update Profile Post
     */
    public function update_profile_post()
    {
        //check user
        if (!auth_check()) {
            redirect(lang_base_url());
        }
        $user_id = user()->id;
        $action = $this->input->post('submit', true);
        if ($action == "resend_activation_email") {
            //send activation email
            if ($this->auth_model->send_activation_email($user_id)) {
                $this->session->set_flashdata('success', trans("msg_send_confirmation_email"));
                redirect($this->agent->referrer());
            } else {
                redirect($this->agent->referrer());
            }
        }
        //validate inputs
        $this->form_validation->set_rules('username', trans("username"), 'required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('email', trans("email"), 'required|xss_clean');
        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            redirect($this->agent->referrer());
        } else {
            $data = array(
                'username' => $this->input->post('username', true),
                'slug' => $this->input->post('slug', true),
                'email' => $this->input->post('email', true),
                'about_me' => $this->input->post('about_me', true)
            );
            //is email unique
            if (!$this->auth_model->is_unique_email($data["email"], $user_id)) {
                $this->session->set_flashdata('error', trans("message_email_unique_error"));
                redirect($this->agent->referrer());
                exit();
            }
            //is username unique
            if (!$this->auth_model->is_unique_username($data["username"], $user_id)) {
                $this->session->set_flashdata('error', trans("msg_username_unique_error"));
                redirect($this->agent->referrer());
                exit();
            }
            //is slug unique
            if ($this->auth_model->check_is_slug_unique($data["slug"], $user_id)) {
                $this->session->set_flashdata('error', trans("msg_slug_used"));
                redirect($this->agent->referrer());
                exit();
            }

            if ($this->profile_model->update_profile($data, $user_id)) {
                $this->session->set_flashdata('success', trans("msg_updated"));
                //check email changed
                if ($this->profile_model->check_email_updated($user_id)) {
                    $this->session->set_flashdata('success', trans("msg_send_confirmation_email"));
                }
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }


    /**
     * Social Accounts
     */
    public function social_accounts()
    {
        //check user
        if (!auth_check()) {
            redirect(lang_base_url());
        }
        $data['title'] = trans("social_accounts");
        $data['description'] = trans("social_accounts") . " - " . $this->settings->site_title;
        $data['keywords'] = trans("social_accounts") . "," . $this->settings->application_name;

        $data["user"] = user();
        if (empty($data["user"])) {
            redirect(lang_base_url());
        }
        $data["active_tab"] = "social_accounts";

        $this->load->view('partials/_header', $data);
        $this->load->view('settings/social_accounts', $data);
        $this->load->view('partials/_footer');
    }


    /**
     * Social Accounts Post
     */
    public function social_accounts_post()
    {
        //check user
        if (!auth_check()) {
            redirect(lang_base_url());
        }
        if ($this->profile_model->update_social_accounts()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }


    /**
     * Change Password
     */
    public function change_password()
    {
        //check user
        if (!auth_check()) {
            redirect(lang_base_url());
        }

        $data['title'] = trans("change_password");
        $data['description'] = trans("change_password") . " - " . $this->settings->site_title;
        $data['keywords'] = trans("change_password") . "," . $this->settings->application_name;

        $data["user"] = user();
        if (empty($data["user"])) {
            redirect(lang_base_url());
        }
        $data["active_tab"] = "change_password";

        $this->load->view('partials/_header', $data);
        $this->load->view('settings/change_password', $data);
        $this->load->view('partials/_footer');
    }


    /**
     * Change Password Post
     */
    public function change_password_post()
    {
        //check user
        if (!auth_check()) {
            redirect(lang_base_url());
        }
        $old_password_exists = $this->input->post('old_password_exists', true);
        if ($old_password_exists == 1) {
            $this->form_validation->set_rules('old_password', trans("form_old_password"), 'required|xss_clean');
        }
        $this->form_validation->set_rules('password', trans("form_password"), 'required|xss_clean|min_length[4]|max_length[50]');
        $this->form_validation->set_rules('password_confirm', trans("form_confirm_password"), 'required|xss_clean|matches[password]');
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->profile_model->change_password_input_values());
            redirect($this->agent->referrer());
        } else {
            if ($this->profile_model->change_password($old_password_exists)) {
                $this->session->set_flashdata('success', trans("message_change_password_success"));
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('error', trans("message_change_password_error"));
                redirect($this->agent->referrer());
            }
        }
    }

    /**
     * Follow Unfollow User
     */
    public function follow_unfollow_user()
    {
        //check user
        if (!auth_check()) {
            redirect(lang_base_url());
        }

        $this->profile_model->follow_unfollow_user();
        redirect($this->agent->referrer());
    }

}

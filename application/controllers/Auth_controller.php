<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_controller extends Home_Core_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('bcrypt');
    }

    /**
     * Login Post
     */
    public function login_post()
    {
        $this->reset_flash_data();

        //validate inputs
        $this->form_validation->set_rules('email', trans("form_email"), 'required|xss_clean|max_length[200]');
        $this->form_validation->set_rules('password', trans("form_password"), 'required|xss_clean|max_length[30]');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->auth_model->input_values());
            $this->load->view('partials/_messages');
        } else {

            $result = $this->auth_model->login();

            if ($result == "banned") {
                //user banned
                $this->session->set_flashdata('error', trans("message_ban_error"));
                $this->load->view('partials/_messages');
                $this->reset_flash_data();
            } elseif ($result == "success") {
                //logged in
                if (auth_check()) {
                    $remember_me = $this->input->post('remember_me', true);
                    if ($remember_me == 1) {
                        $this->auth_model->remember_me(user()->id);
                    }
                }

                echo $result;
                $this->reset_flash_data();
            } else {
                //error
                $this->session->set_flashdata('error', trans("login_error"));
                $this->load->view('partials/_messages');
                $this->reset_flash_data();
            }
        }
    }


    /**
     * Login with Facebook
     */
    public function login_with_facebook()
    {
        $this->auth_model->login_with_facebook();
    }


    /**
     * Login with Google
     */
    public function login_with_google()
    {
        $this->auth_model->login_with_google();
    }


    /**
     * Admin Login
     */
    public function admin_login()
    {
        $data['title'] = trans("login");
        $data['description'] = trans("login") . " - " . $this->settings->site_title;
        $data['keywords'] = trans("login") . ', ' . $this->settings->application_name;
        $this->load->view('admin/login', $data);

    }


    /**
     * Admin Login Post
     */
    public function admin_login_post()
    {
        //validate inputs
        $this->form_validation->set_rules('email', trans("form_email"), 'required|xss_clean|max_length[200]');
        $this->form_validation->set_rules('password', trans("form_password"), 'required|xss_clean|max_length[30]');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->auth_model->input_values());
            redirect($this->agent->referrer());
        } else {
            if ($this->auth_model->login()) {
                redirect(admin_url());
            } else {
                //error
                $this->session->set_flashdata('form_data', $this->auth_model->input_values());
                $this->session->set_flashdata('error', trans("login_error"));
                redirect($this->agent->referrer());
            }
        }
    }

    /**
     * Register
     */
    public function register()
    {
        $this->is_registration_active();

        //check if logged in
        if (auth_check()) {
            redirect(lang_base_url());
        }

        $page = $this->page_model->get_page("register");

        //check if page exists
        if (empty($page)) {
            redirect(lang_base_url());
        }

        $data['title'] = get_page_title($page);
        $data['description'] = get_page_description($page);
        $data['keywords'] = get_page_keywords($page);

        if ($this->recaptcha_status) {
            $this->load->library('recaptcha');
            $data['recaptcha_widget'] = $this->recaptcha->getWidget();
            $data['recaptcha_script'] = $this->recaptcha->getScriptTag();
        }

        $this->load->view('partials/_header', $data);
        $this->load->view('auth/register');
        $this->load->view('partials/_footer');
    }


    /**
     * Register Post
     */
    public function register_post()
    {
        $this->reset_flash_data();

        //validate inputs
        $this->form_validation->set_rules('username', trans("form_username"), 'required|xss_clean|min_length[4]|max_length[100]');
        $this->form_validation->set_rules('email', trans("form_email"), 'required|xss_clean|max_length[200]');
        $this->form_validation->set_rules('password', trans("form_password"), 'required|xss_clean|min_length[4]|max_length[30]');
        $this->form_validation->set_rules('confirm_password', trans("form_confirm_password"), 'required|xss_clean|matches[password]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->auth_model->input_values());
            redirect($this->agent->referrer());
        } else {
            $email = $this->input->post('email', true);
            //is email unique
            if (!$this->auth_model->is_unique_email($email)) {
                $this->session->set_flashdata('form_data', $this->auth_model->input_values());
                $this->session->set_flashdata('error', trans("message_email_unique_error"));
                redirect($this->agent->referrer());
            }

            if (!$this->recaptcha_verify_request()) {
                $this->session->set_flashdata('form_data', $this->auth_model->input_values());
                $this->session->set_flashdata('error', trans("msg_recaptcha"));
                redirect($this->agent->referrer());
            } else {
                //register
                $user = $this->auth_model->register();
                if ($user) {
                    $this->auth_model->login_direct($user);
                    if ($this->general_settings->email_verification == 1) {
                        $this->session->set_flashdata('success', trans("msg_send_confirmation_email"));
                    } else {
                        $this->session->set_flashdata('success', trans("msg_register_success"));
                    }
                    redirect(base_url() . "settings");
                    redirect($this->agent->referrer());
                } else {
                    //error
                    $this->session->set_flashdata('form_data', $this->auth_model->input_values());
                    $this->session->set_flashdata('error', trans("message_register_error"));
                    redirect($this->agent->referrer());
                }

            }

        }
    }


    /**
     * Logout
     */
    public function logout()
    {
        $this->auth_model->logout();
        redirect($this->agent->referrer());
    }


    /**
     * Reset Password
     */
    public function reset_password()
    {
        $this->is_registration_active();

        //check if logged in
        if (auth_check()) {
            redirect(lang_base_url());
        }

        $page = $this->page_model->get_page("reset-password");
        //check if page exists
        if (empty($page)) {
            redirect(lang_base_url());
        }
        $data['title'] = get_page_title($page);
        $data['description'] = get_page_description($page);
        $data['keywords'] = get_page_keywords($page);

        $this->load->view('partials/_header', $data);
        $this->load->view('auth/reset_password');
        $this->load->view('partials/_footer');
    }


    /**
     * Reset Password Post
     */
    public function reset_password_post()
    {
        $this->reset_flash_data();
        $email = $this->input->post('email', true);
        //get user
        $user = $this->auth_model->get_user_by_email($email);
        //if user not exists
        if (empty($user)) {
            $this->session->set_flashdata('error', trans("reset_password_error"));
        } else {
            if ($this->auth_model->send_reset_password_email($user)) {
                $this->session->set_flashdata('success', trans("reset_password_success"));
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
            }
        }
        redirect($this->agent->referrer());
    }

    /**
     * Confirm Email
     */
    public function confirm()
    {
        $data['title'] = trans("confirm_your_email");
        $data['description'] = trans("confirm_your_email") . " - " . $this->settings->site_title;
        $data['keywords'] = trans("confirm_your_email") . "," . $this->settings->application_name;

        $email = trim($this->input->get("email", true));
        $token = trim($this->input->get("token", true));

        $data["user"] = $this->auth_model->get_user_by_email($email);

        if (empty($data["user"])) {
            redirect(lang_base_url());
        } else {
            if ($data["user"]->email_status == 1) {
                redirect(lang_base_url());
            }
            if ($data["user"]->token == $token) {
                $this->auth_model->verify_email($data["user"]);
                $data["message"] = trans("msg_confirmed");
            } else {
                $data["message"] = trans("msg_error");
            }
        }

        $this->load->view('partials/_header', $data);
        $this->load->view('auth/confirm_email', $data);
        $this->load->view('partials/_footer');
    }


    public function reset_flash_data()
    {
        $this->session->set_flashdata('errors', "");
        $this->session->set_flashdata('error', "");
        $this->session->set_flashdata('success', "");
    }


    public function is_registration_active()
    {
        if ($this->general_settings->registration_system != 1) {
            redirect(lang_base_url());
        }
    }

}

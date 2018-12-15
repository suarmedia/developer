<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model
{

    //input values
    public function input_values()
    {
        $data = array(
            'username' => $this->input->post('username', true),
            'email' => $this->input->post('email', true),
            'password' => $this->input->post('password', true)
        );
        return $data;
    }

    //change password input values
    public function change_password_input_values()
    {
        $data = array(
            'old_password' => $this->input->post('old_password', true),
            'password' => $this->input->post('password', true),
            'password_confirmation' => $this->input->post('password_confirmation', true)
        );
        return $data;
    }

    //login
    public function login()
    {
        $data = $this->input_values();
        $user = $this->get_user_by_email($data['email']);
        if (!empty($user)) {
            //check password
            if (!$this->bcrypt->check_password($data['password'], $user->password)) {
                return false;
            }
            if ($user->status == 0) {
                return "banned";
            }
            //set user data
            $user_data = array(
                'vr_sess_user_id' => $user->id,
                'vr_sess_user_email' => $user->email,
                'vr_sess_user_role' => $user->role,
                'vr_sess_logged_in' => true,
                'vr_sess_app_key' => $this->config->item('app_key'),
            );
            $this->session->set_userdata($user_data);
            return "success";
        } else {
            return false;
        }

    }

    //login direct
    public function login_direct($user)
    {
        //set user data
        $user_data = array(
            'vr_sess_user_id' => $user->id,
            'vr_sess_user_email' => $user->email,
            'vr_sess_user_role' => $user->role,
            'vr_sess_logged_in' => true,
            'vr_sess_app_key' => $this->config->item('app_key'),
        );

        $this->session->set_userdata($user_data);
    }

    //login with facebook
    public function login_with_facebook()
    {
        $id = $this->input->post('id', true);
        $email = $this->input->post('email', true);
        $first_name = $this->input->post('first_name', true);
        $last_name = $this->input->post('last_name', true);

        $user = $this->get_user_by_email($email);

        //check if user registered
        if (empty($user)) {
            $username = $this->generate_uniqe_username($first_name . " " . $last_name);
            $slug = $this->generate_uniqe_slug($username);
            //add user to database
            $data = array(
                'facebook_id' => $id,
                'email' => $email,
                'email_status' => 1,
                'token' => md5(uniqid()),
                'username' => $username,
                'slug' => $slug,
                'avatar' => "https://graph.facebook.com/" . $id . "/picture?type=large",
                'user_type' => "facebook",
            );
            $data['created_at'] = date('Y-m-d H:i:s');
            if (!empty($data['email'])) {
                $this->db->insert('users', $data);
                $user = $this->get_user_by_email($email);
                $this->login_direct($user);
            }
        } else {
            //login
            $this->login_direct($user);
        }
    }

    //login with google
    public function login_with_google()
    {
        $id = $this->input->post('id', true);
        $email = $this->input->post('email', true);
        $name = $this->input->post('name', true);
        $avatar = $this->input->post('avatar', true);

        $user = $this->get_user_by_email($email);

        //check if user registered
        if (empty($user)) {

            $username = $this->generate_uniqe_username($name);
            $slug = $this->generate_uniqe_slug($name);

            //add user to database
            $data = array(
                'google_id' => $id,
                'email' => $email,
                'email_status' => 1,
                'token' => md5(uniqid()),
                'username' => $username,
                'slug' => $slug,
                'avatar' => $avatar,
                'user_type' => "google",
            );
            $data['created_at'] = date('Y-m-d H:i:s');
            if (!empty($data['email'])) {
                $this->db->insert('users', $data);
                $user = $this->get_user_by_email($email);
                $this->login_direct($user);
            }

        } else {
            //login
            $this->login_direct($user);
        }
    }

    //register
    public function register()
    {
        $this->load->library('bcrypt');

        $data = $this->auth_model->input_values();
        //secure password
        $data['password'] = $this->bcrypt->hash_password($data['password']);
        $data['user_type'] = "registered";
        $data["slug"] = $this->generate_uniqe_slug($data["username"]);
        $data['status'] = 1;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['token'] = md5(uniqid());
        $data['role'] = 'user';

        if ($this->db->insert('users', $data)) {
            $last_id = $this->db->insert_id();
            if ($this->general_settings->email_verification == 1) {
                $data['email_status'] = 0;
                $this->send_activation_email($last_id);
            } else {
                $data['email_status'] = 1;
            }
            return $this->get_user($last_id);
        } else {
            return false;
        }
    }

    //add user
    public function add_user()
    {
        $this->load->library('bcrypt');

        $data = $this->auth_model->input_values();
        //secure password
        $data['password'] = $this->bcrypt->hash_password($data['password']);
        $data['user_type'] = "registered";
        $data["slug"] = $this->generate_uniqe_slug($data["username"]);
        $data['role'] = $this->input->post('role', true);
        $data['status'] = 1;
        $data['email_status'] = 1;
        $data['token'] = md5(uniqid());
        $data['created_at'] = date('Y-m-d H:i:s');

        return $this->db->insert('users', $data);
    }

    //generate uniqe username
    public function generate_uniqe_username($username)
    {
        $new_username = $username;
        if (!empty($this->get_user_by_username($new_username))) {
            $new_username = $username . " 1";
            if (!empty($this->get_user_by_username($new_username))) {
                $new_username = $username . " 2";
                if (!empty($this->get_user_by_username($new_username))) {
                    $new_username = $username . " 3";
                    if (!empty($this->get_user_by_username($new_username))) {
                        $new_username = $username . "-" . uniqid();
                    }
                }
            }
        }
        return $new_username;
    }

    //generate uniqe slug
    public function generate_uniqe_slug($username)
    {
        $slug = str_slug($username);
        if (!empty($this->get_user_by_slug($slug))) {
            $slug = str_slug($username . "-1");
            if (!empty($this->get_user_by_slug($slug))) {
                $slug = str_slug($username . "-2");
                if (!empty($this->get_user_by_slug($slug))) {
                    $slug = str_slug($username . "-3");
                    if (!empty($this->get_user_by_slug($slug))) {
                        $slug = str_slug($username . "-" . uniqid());
                    }
                }
            }
        }
        return $slug;
    }

    //logout
    public function logout()
    {
        //unset user data
        $this->session->unset_userdata('vr_sess_user_id');
        $this->session->unset_userdata('vr_sess_user_email');
        $this->session->unset_userdata('vr_sess_user_role');
        $this->session->unset_userdata('vr_sess_logged_in');
        $this->session->unset_userdata('vr_sess_app_key');
        helper_deletecookie("varient_remember_user_id");
        $this->session->sess_destroy();
    }

    public function send_activation_email($user_id)
    {
        $user = $this->get_user($user_id);
        if (!empty($user)) {
            $subject = trans("confirm_your_email");
            $message = "<p style='text-align: center'>" . trans("msg_confirmation_email") . "</p><br><p style='text-align: center'><a href='" . base_url() . "confirm?email=" . $user->email . "&token=" . $user->token . "' style='font-size: 14px;text-decoration: none;padding: 14px 32px;background-color: #1abc9c;color: #ffffff !important; border-radius: 4px;'>" . trans("confirm_your_email") . "</a></p>";
            //send email
            $this->load->model("email_model");
            if ($this->email_model->send_email($user->email, $subject, $message, false, null)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function send_reset_password_email($user)
    {
        //generate new password
        $new_password = bin2hex(openssl_random_pseudo_bytes(3));
        $data = array(
            'password' => $this->bcrypt->hash_password($new_password)
        );
        //change password
        $this->db->where('email', $user->email);
        if ($this->db->update('users', $data)) {
            $subject = trans("nav_reset_password");
            $message = "<p style='text-align: center'>" . trans("email_reset_password") . " <strong>" . $new_password . "</strong>" . "</p><br>";
            //send email
            $this->load->model("email_model");
            if ($this->email_model->send_email($user->email, $subject, $message, false, null)) {
                return true;
            } else {
                return false;
            }
        }
    }

    //verify email
    public function verify_email($user)
    {
        if (!empty($user)) {
            $data = array();
            $data['email_status'] = 1;
            $data['token'] = md5(uniqid());
            $this->db->where('id', $user->id);
            return $this->db->update('users', $data);
        }

        return false;
    }

    //change user role
    public function change_user_role($id, $role)
    {
        $data = array(
            'role' => $role
        );

        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    //delete user
    public function delete_user($id)
    {
        $user = $this->get_user($id);

        if (!empty($user)) {
            $this->db->where('id', $id);
            return $this->db->delete('users');
        } else {
            return false;
        }
    }

    //ban user
    public function ban_user($id)
    {
        $user = $this->get_user($id);

        if (!empty($user)) {

            $data = array(
                'status' => 0
            );

            $this->db->where('id', $id);
            return $this->db->update('users', $data);
        } else {
            return false;
        }
    }

    //remove user ban
    public function remove_user_ban($id)
    {
        $user = $this->get_user($id);

        if (!empty($user)) {

            $data = array(
                'status' => 1
            );

            $this->db->where('id', $id);
            return $this->db->update('users', $data);
        } else {
            return false;
        }
    }

    //is logged in
    public function is_logged_in()
    {
        //check if user logged in
        if ($this->session->userdata('vr_sess_logged_in') == true &&
            $this->session->userdata('vr_sess_app_key') == $this->config->item('app_key') &&
            !empty($this->get_user($this->session->userdata('vr_sess_user_id')))) {
            return true;
        } else {
            return false;
        }
    }

    //function get user
    public function get_logged_user()
    {
        if ($this->is_logged_in()) {
            $this->db->where('id', $this->session->userdata('vr_sess_user_id'));
            $query = $this->db->get('users');
            return $query->row();
        }
    }

    //is admin
    public function is_admin()
    {
        //check logged in
        if (!$this->is_logged_in()) {
            return false;
        }

        //check role
        if (user()->role == 'admin') {
            return true;
        } else {
            return false;
        }
    }

    //is author
    public function is_author()
    {
        //check logged in
        if (!$this->is_logged_in()) {
            return false;
        }

        //check role
        if (user()->role == 'author') {
            return true;
        } else {
            return false;
        }
    }

    //get user by id
    public function get_user($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('users');
        return $query->row();
    }

    //get user by email
    public function get_user_by_email($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        return $query->row();
    }

    //get user by username
    public function get_user_by_username($username)
    {
        $this->db->where('username', $username);
        $query = $this->db->get('users');
        return $query->row();
    }

    //get user by slug
    public function get_user_by_slug($slug)
    {
        $this->db->where('slug', $slug);
        $query = $this->db->get('users');
        return $query->row();
    }

    //get users
    public function get_users()
    {
        $this->db->where('role !=', 'admin');
        $query = $this->db->get('users');
        return $query->result();
    }

    //get all users
    public function get_all_users()
    {
        $query = $this->db->get('users');
        return $query->result();
    }

    //get users
    public function get_administrators()
    {
        $this->db->where('role', 'admin');
        $query = $this->db->get('users');
        return $query->result();
    }

    //get active users
    public function get_active_users()
    {
        $this->db->where('status', 1);
        $this->db->order_by('username');
        $query = $this->db->get('users');
        return $query->result();
    }

    //get last users
    public function get_last_users()
    {
        $this->db->order_by('users.id', 'DESC');
        $this->db->limit(6);
        $query = $this->db->get('users');
        return $query->result();
    }

    //user count
    public function get_user_count()
    {
        $query = $this->db->get('users');
        return $query->num_rows();
    }

    //get logged user id
    public function get_user_id()
    {
        //check logged in
        if (!$this->is_logged_in()) {
            return false;
        }

        return user()->id;
    }

    //get logged username
    public function get_username()
    {
        //check logged in
        if (!$this->is_logged_in()) {
            return false;
        }

        return user()->id;
    }

    //get roles
    public function get_roles()
    {
        $query = $this->db->get('roles_permissions');
        return $query->result();
    }

    //get role
    public function get_role($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('roles_permissions');
        return $query->row();
    }

    //get role by key
    public function get_role_by_key($key)
    {
        $this->db->where('role', $key);
        $query = $this->db->get('roles_permissions');
        return $query->row();
    }

    //update role
    public function update_role($id)
    {
        $data = array(
            'admin_panel' => $this->input->post('admin_panel', true) == 1 ? 1 : 0,
            'add_post' => $this->input->post('add_post', true) == 1 ? 1 : 0,
            'manage_all_posts' => $this->input->post('manage_all_posts', true) == 1 ? 1 : 0,
            'navigation' => $this->input->post('navigation', true) == 1 ? 1 : 0,
            'pages' => $this->input->post('pages', true) == 1 ? 1 : 0,
            'rss_feeds' => $this->input->post('rss_feeds', true) == 1 ? 1 : 0,
            'categories' => $this->input->post('categories', true) == 1 ? 1 : 0,
            'widgets' => $this->input->post('widgets', true) == 1 ? 1 : 0,
            'polls' => $this->input->post('polls', true) == 1 ? 1 : 0,
            'gallery' => $this->input->post('gallery', true) == 1 ? 1 : 0,
            'comments_contact' => $this->input->post('comments_contact', true) == 1 ? 1 : 0,
            'newsletter' => $this->input->post('newsletter', true) == 1 ? 1 : 0,
            'ad_spaces' => $this->input->post('ad_spaces', true) == 1 ? 1 : 0,
            'users' => $this->input->post('users', true) == 1 ? 1 : 0,
            'seo_tools' => $this->input->post('seo_tools', true) == 1 ? 1 : 0,
            'settings' => $this->input->post('settings', true) == 1 ? 1 : 0,
        );

        $this->db->where('id', $id);
        return $this->db->update('roles_permissions', $data);
    }

    //check permission
    public function check_permission($role_key, $section)
    {
        $role = $this->get_role_by_key($role_key);
        if (!empty($role)) {
            if ($role_key == 'admin') {
                return true;
            }
            if ($role->$section == 1) {
                return true;
            }
        }
        return false;
    }

    //check slug
    public function check_is_slug_unique($slug, $id)
    {
        $this->db->where('users.slug', $slug);
        $this->db->where('users.id !=', $id);
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    //check if email is unique
    public function is_unique_email($email, $user_id = 0)
    {
        $user = $this->auth_model->get_user_by_email($email);

        //if id doesnt exists
        if ($user_id == 0) {
            if (empty($user)) {
                return true;
            } else {
                return false;
            }
        }

        if ($user_id != 0) {
            if (!empty($user) && $user->id != $user_id) {
                //email taken
                return false;
            } else {
                return true;
            }
        }
    }

    //check if username is unique
    public function is_unique_username($username, $user_id = 0)
    {
        $user = $this->get_user_by_username($username);

        //if id doesnt exists
        if ($user_id == 0) {
            if (empty($user)) {
                return true;
            } else {
                return false;
            }
        }

        if ($user_id != 0) {
            if (!empty($user) && $user->id != $user_id) {
                //username taken
                return false;
            } else {
                return true;
            }
        }
    }

    //update last seen time
    public function update_last_seen()
    {
        if ($this->is_logged_in()) {
            $user = user();
            //update last seen
            $data = array(
                'last_seen' => date("Y-m-d H:i:s"),
            );
            $this->db->where('id', $user->id);
            $this->db->update('users', $data);
        }
    }

    //remember me
    public function remember_me($user_id)
    {
        helper_setcookie("varient_remember_user_id", $user_id);
    }

    //check remember
    public function check_remember()
    {
        if (isset($_COOKIE["varient_remember_user_id"])) {
            $user_id = $_COOKIE["varient_remember_user_id"];
            $user = $this->get_user($user_id);
            if (!empty($user)) {
                $this->login_direct($user);
            }
        }
    }
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_model extends CI_Model
{
    //update profile
    public function update_profile($data, $user_id)
    {
        //upload image
        $file = $_FILES['file'];
        if (!empty($file['name'])) {
            //delete old avatar
            delete_file_from_server(user()->avatar);
            $data["avatar"] = $this->upload_model->avatar_upload($user_id, $file);
        }
        $_SESSION["varient_user_old_email"] = user()->email;
        $this->db->where('id', $user_id);
        return $this->db->update('users', $data);
    }

    //check email updated
    public function check_email_updated($user_id)
    {
        if ($this->general_settings->email_verification == 1) {
            $user = $this->auth_model->get_user($user_id);
            if (!empty($user)) {
                if (isset($_SESSION["varient_user_old_email"]) && $_SESSION["varient_user_old_email"] != $user->email) {
                    //send confirm email
                    $this->auth_model->send_activation_email($user->id);
                    $data = array(
                        'email_status' => 0
                    );

                    $this->db->where('id', $user->id);
                    return $this->db->update('users', $data);
                }
            }

            if (isset($_SESSION["varient_user_old_email"])) {
                unset($_SESSION["varient_user_old_email"]);
            }
        }

        return false;
    }

    //update update social accounts
    public function update_social_accounts()
    {
        $user_id = user()->id;
        $data = array(
            'facebook_url' => $this->input->post('facebook_url', true),
            'twitter_url' => $this->input->post('twitter_url', true),
            'google_url' => $this->input->post('google_url', true),
            'instagram_url' => $this->input->post('instagram_url', true),
            'pinterest_url' => $this->input->post('pinterest_url', true),
            'linkedin_url' => $this->input->post('linkedin_url', true),
            'vk_url' => $this->input->post('vk_url', true),
            'youtube_url' => $this->input->post('youtube_url', true)
        );

        $this->db->where('id', $user_id);
        return $this->db->update('users', $data);
    }

    //edit user
    public function edit_user($id)
    {
        $user = $this->auth_model->get_user($id);
        if (!empty($user)) {
            $data = array(
                'username' => $this->input->post('username', true),
                'email' => $this->input->post('email', true),
                'slug' => $this->input->post('slug', true),
                'about_me' => $this->input->post('about_me', true),
                'facebook_url' => $this->input->post('facebook_url', true),
                'twitter_url' => $this->input->post('twitter_url', true),
                'google_url' => $this->input->post('google_url', true),
                'instagram_url' => $this->input->post('instagram_url', true),
                'pinterest_url' => $this->input->post('pinterest_url', true),
                'linkedin_url' => $this->input->post('linkedin_url', true),
                'vk_url' => $this->input->post('vk_url', true),
                'youtube_url' => $this->input->post('youtube_url', true)
            );
            //upload image
            $file = $_FILES['file'];
            if (!empty($file['name'])) {
                //delete old avatar
                delete_file_from_server($user->avatar);
                $data["avatar"] = $this->upload_model->avatar_upload($user->id, $file);
            }

            $this->db->where('id', $id);
            return $this->db->update('users', $data);
        }
    }

    //change password input values
    public function change_password_input_values()
    {
        $data = array(
            'old_password' => $this->input->post('old_password', true),
            'password' => $this->input->post('password', true),
            'password_confirm' => $this->input->post('password_confirm', true)
        );
        return $data;
    }

    //change password
    public function change_password($old_password_exists)
    {
        $this->load->library('bcrypt');
        $user = user();
        if (!empty($user)) {
            $data = $this->change_password_input_values();
            if ($old_password_exists == 1) {
                //password does not match stored password.
                if (!$this->bcrypt->check_password($data['old_password'], $user->password)) {
                    $this->session->set_flashdata('error', trans("wrong_password_error"));
                    $this->session->set_flashdata('form_data', $this->change_password_input_values());
                    redirect($this->agent->referrer());
                }
            }
            $data = array(
                'password' => $this->bcrypt->hash_password($data['password'])
            );
            $this->db->where('id', $user->id);
            return $this->db->update('users', $data);
        } else {
            return false;
        }
    }

    //follow user
    public function follow_unfollow_user()
    {
        $data = array(
            'following_id' => $this->input->post('following_id', true),
            'follower_id' => $this->input->post('follower_id', true)
        );

        $follow = $this->get_follow($data["following_id"], $data["follower_id"]);
        if (empty($follow)) {
            //add follower
            $this->db->insert('followers', $data);
        } else {
            $this->db->where('id', $follow->id);
            $this->db->delete('followers');
        }
    }

    //follow
    public function get_follow($following_id, $follower_id)
    {
        $this->db->where('following_id', $following_id);
        $this->db->where('follower_id', $follower_id);
        $query = $this->db->get('followers');
        return $query->row();
    }

    //is user follows
    public function is_user_follows($following_id, $follower_id)
    {
        $follow = $this->get_follow($following_id, $follower_id);
        if (empty($follow)) {
            return false;
        } else {
            return true;
        }
    }

    //get followers
    public function get_followers($following_id)
    {
        $this->db->join('users', 'followers.follower_id = users.id');
        $this->db->select('users.*');
        $this->db->where('following_id', $following_id);
        $query = $this->db->get('followers');
        return $query->result();
    }

    //get followers count
    public function get_followers_count($following_id)
    {
        $this->db->join('users', 'followers.follower_id = users.id');
        $this->db->select('users.*');
        $this->db->where('following_id', $following_id);
        $query = $this->db->get('followers');
        return $query->num_rows();
    }

    //get following users
    public function get_following_users($follower_id)
    {
        $this->db->join('users', 'followers.following_id = users.id');
        $this->db->select('users.*');
        $this->db->where('follower_id', $follower_id);
        $query = $this->db->get('followers');
        return $query->result();
    }

    //get following users
    public function get_following_users_count($follower_id)
    {
        $this->db->join('users', 'followers.following_id = users.id');
        $this->db->select('users.*');
        $this->db->where('follower_id', $follower_id);
        $query = $this->db->get('followers');
        return $query->num_rows();
    }
}
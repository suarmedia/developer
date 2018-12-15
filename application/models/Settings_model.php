<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings_model extends CI_Model
{
    //input values
    public function input_values()
    {
        $data = array(
            'application_name' => $this->input->post('application_name', true),
            'about_footer' => $this->input->post('about_footer', true),
            'optional_url_button_name' => $this->input->post('optional_url_button_name', true),
            'copyright' => $this->input->post('copyright', true),
            'contact_address' => $this->input->post('contact_address', true),
            'contact_email' => $this->input->post('contact_email', true),
            'contact_phone' => $this->input->post('contact_phone', true),
            'contact_text' => $this->input->post('contact_text', false),
            'facebook_url' => $this->input->post('facebook_url', true),
            'twitter_url' => $this->input->post('twitter_url', true),
            'google_url' => $this->input->post('google_url', true),
            'instagram_url' => $this->input->post('instagram_url', true),
            'pinterest_url' => $this->input->post('pinterest_url', true),
            'linkedin_url' => $this->input->post('linkedin_url', true),
            'vk_url' => $this->input->post('vk_url', true),
            'youtube_url' => $this->input->post('youtube_url', true),
            'cookies_warning' => $this->input->post('cookies_warning', true),
            'cookies_warning_text' => $this->input->post('cookies_warning_text', true),
        );
        return $data;
    }

    //get settings
    public function get_settings($lang_id)
    {
        $this->db->where('lang_id', $lang_id);
        $query = $this->db->get('settings');
        return $query->row();
    }

    //get settings
    public function get_general_settings()
    {
        $this->db->where('id', 1);
        $query = $this->db->get('general_settings');
        return $query->row();
    }

    //update settings
    public function update_settings()
    {
        $general = array(
            'timezone' => $this->input->post('timezone', false),
            'facebook_comment' => $this->input->post('facebook_comment', false),
            'head_code' => $this->input->post('head_code', false)
        );

        $this->db->where('id', 1);
        $this->db->update('general_settings', $general);

        $lang_id = $this->input->post('lang_id', true);
        $data = $this->input_values();

        $this->db->where('lang_id', $lang_id);
        return $this->db->update('settings', $data);
    }

    //update preferences
    public function update_preferences()
    {
        $data = array(
            'multilingual_system' => $this->input->post('multilingual_system', true),
            'registration_system' => $this->input->post('registration_system', true),
            'comment_system' => $this->input->post('comment_system', true),
            'facebook_comment_active' => $this->input->post('facebook_comment_active', true),
            'emoji_reactions' => $this->input->post('emoji_reactions', true),
            'newsletter' => $this->input->post('newsletter', true),
            'show_rss' => $this->input->post('show_rss', true),
            'show_featured_section' => $this->input->post('show_featured_section', true),
            'show_latest_posts' => $this->input->post('show_latest_posts', true),
            'show_newsticker' => $this->input->post('show_newsticker', true),
            'show_post_author' => $this->input->post('show_post_author', true),
            'show_post_date' => $this->input->post('show_post_date', true),
            'show_hits' => $this->input->post('show_hits', true),
            'approve_added_user_posts' => $this->input->post('approve_added_user_posts', true),
            'approve_updated_user_posts' => $this->input->post('approve_updated_user_posts', true),
            'file_manager_show_files' => $this->input->post('file_manager_show_files', true),
            'pagination_per_page' => $this->input->post('pagination_per_page', true),
        );

        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update cache system
    public function update_cache_system()
    {
        $data = array(
            'cache_system' => $this->input->post('cache_system', true),
            'refresh_cache_database_changes' => $this->input->post('refresh_cache_database_changes', true),
            'cache_refresh_time' => $this->input->post('cache_refresh_time', true) * 60
        );

        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update social settings
    public function update_social_settings()
    {
        $data = array(
            'facebook_app_id' => $this->input->post('facebook_app_id', true),
            'facebook_app_secret' => $this->input->post('facebook_app_secret', true),
            'google_app_name' => $this->input->post('google_app_name', true),
            'google_client_id' => $this->input->post('google_client_id', true),
            'google_client_secret' => $this->input->post('google_client_secret', true),
        );

        //update
        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update font settings
    public function update_font_settings()
    {
        $data = array(
            'primary_font' => $this->input->post('primary_font', true),
            'secondary_font' => $this->input->post('secondary_font', true),
            'tertiary_font' => $this->input->post('tertiary_font', true),
        );

        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update email settings
    public function update_email_settings()
    {
        $data = array(
            'mail_protocol' => $this->input->post('mail_protocol', true),
            'mail_title' => $this->input->post('mail_title', true),
            'mail_host' => $this->input->post('mail_host', true),
            'mail_port' => $this->input->post('mail_port', true),
            'mail_username' => $this->input->post('mail_username', true),
            'mail_password' => $this->input->post('mail_password', true)
        );

        //update
        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update contact email settings
    public function update_contact_email_settings()
    {
        $data = array(
            'mail_contact' => $this->input->post('mail_contact', true),
            'mail_contact_status' => $this->input->post('mail_contact_status', true)
        );

        //update
        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update email verification settings
    public function email_verification_settings()
    {
        $data = array(
            'email_verification' => $this->input->post('email_verification', true)
        );

        //update
        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update seo settings
    public function update_seo_settings()
    {
        $general = array(
            'google_analytics' => $this->input->post('google_analytics', false),
        );

        $this->db->where('id', 1);
        $this->db->update('general_settings', $general);

        $data = array(
            'site_title' => $this->input->post('site_title', true),
            'home_title' => $this->input->post('home_title', true),
            'site_description' => $this->input->post('site_description', true),
            'keywords' => $this->input->post('keywords', true),
        );

        $lang_id = $this->input->post('lang_id', true);

        $this->db->where('lang_id', $lang_id);
        return $this->db->update('settings', $data);
    }

    //update recaptcha settings
    public function update_recaptcha_settings()
    {
        $data = array(
            'recaptcha_site_key' => $this->input->post('recaptcha_site_key', true),
            'recaptcha_secret_key' => $this->input->post('recaptcha_secret_key', true),
            'recaptcha_lang' => $this->input->post('recaptcha_lang', true),
        );

        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update admin panel link
    public function update_admin_panel_link($link)
    {
        $link = str_slug($link);
        if (empty($link)) {
            $link = "admin";
        }
        $start = '<?php defined("BASEPATH") OR exit("No direct script access allowed");' . PHP_EOL;
        $keys = '$custom_slug_array["admin"] = "' . $link . '";';
        $end = '?>';

        $content = $start . $keys . $end;

        file_put_contents(FCPATH . "application/config/route_slugs.php", $content);
    }

}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Language_model extends CI_Model
{
    //input values
    public function input_values()
    {
        $data = array(
            'name' => $this->input->post('name', true),
            'short_form' => $this->input->post('short_form', true),
            'language_code' => $this->input->post('language_code', true),
            'language_order' => $this->input->post('language_order', true),
            'text_direction' => $this->input->post('text_direction', true),
            'status' => $this->input->post('status', true),
        );
        return $data;
    }

    //add language
    public function add_language()
    {
        $data = $this->input_values();

        $folder_name = str_slug($data["name"]);

        if (empty($folder_name)) {
            $folder_name = "lang_" . uniqid();
        }

        $data["folder_name"] = $folder_name;

        if ($this->create_language_folder($folder_name)) {
            return $this->db->insert('languages', $data);
        } else {
            return false;
        }
    }

    public function add_language_rows($lang_id)
    {
        //add widgets
        $data = array(
            'lang_id' => $lang_id,
            'content' => " ",
            'visibility' => 1,
            'is_custom' => 0,
        );

        $data["title"] = "Follow Us";
        $data["widget_order"] = 1;
        $data["type"] = "follow-us";
        $this->db->insert('widgets', $data);

        $data["title"] = "Popular Posts";
        $data["widget_order"] = 2;
        $data["type"] = "popular-posts";
        $this->db->insert('widgets', $data);

        $data["title"] = "Recommended Posts";
        $data["widget_order"] = 3;
        $data["type"] = "recommended-posts";
        $this->db->insert('widgets', $data);

        $data["title"] = "Random Posts";
        $data["widget_order"] = 4;
        $data["type"] = "random-slider-posts";
        $this->db->insert('widgets', $data);

        $data["title"] = "Tags";
        $data["widget_order"] = 5;
        $data["type"] = "tags";
        $this->db->insert('widgets', $data);

        $data["title"] = "Voting Poll";
        $data["widget_order"] = 6;
        $data["type"] = "poll";
        $this->db->insert('widgets', $data);

        //add settings
        $settings = array(
            'lang_id' => $lang_id,
            'site_title' => "Varient - News Magazine",
            'home_title' => "Index",
            'site_description' => "Varient - News Magazine",
            'keywords' => "Varient, News, Magazine",
            'application_name' => "Varient",
            'facebook_url' => "",
            'twitter_url' => "",
            'google_url' => "",
            'instagram_url' => "",
            'pinterest_url' => "",
            'linkedin_url' => "",
            'vk_url' => "",
            'youtube_url' => "",
            'optional_url_button_name' => "Click Here To See More",
            'about_footer' => "",
            'contact_text' => "",
            'contact_address' => "",
            'contact_email' => "",
            'contact_phone' => "",
            'copyright' => "",
        );

        $this->db->insert('settings', $settings);

        //add pages
        $this->add_language_pages($lang_id);

    }

    public function add_language_pages($lang_id)
    {
        //add pages
        $page = array(
            'lang_id' => $lang_id, 'title' => "Gallery", 'slug' => "gallery", 'description' => "Varient Gallery Page", 'keywords' => "varient, gallery , page", 'is_custom' => 0, 'page_content' => "", 'page_order' => 2, 'visibility' => 1, 'title_active' => 1, 'breadcrumb_active' => 1, 'right_column_active' => 0, 'need_auth' => 0, 'location' => "main", 'parent_id' => 0, 'page_type' => "page",
        );
        $this->db->insert('pages', $page);
        $page = array(
            'lang_id' => $lang_id, 'title' => "Contact", 'slug' => "contact", 'description' => "Varient Contact Page", 'keywords' => "varient, contact, page", 'is_custom' => 0, 'page_content' => "", 'page_order' => 0, 'visibility' => 1, 'title_active' => 1, 'breadcrumb_active' => 1, 'right_column_active' => 0, 'need_auth' => 0, 'location' => "top", 'parent_id' => 0, 'page_type' => "page",
        );
        $this->db->insert('pages', $page);

        $page = array(
            'lang_id' => $lang_id, 'title' => "User Agreement", 'slug' => "user-agreement", 'description' => "Varient User Agreement Page", 'keywords' => "varient, user agreement, terms", 'is_custom' => 0, 'page_content' => "", 'page_order' => 0, 'visibility' => 1, 'title_active' => 1, 'breadcrumb_active' => 1, 'right_column_active' => 0, 'need_auth' => 0, 'location' => "none", 'parent_id' => 0, 'page_type' => "page",
        );
        $this->db->insert('pages', $page);
    }

    //get language
    public function get_language($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('languages');
        return $query->row();
    }

    //get language by short
    public function get_language_by_short($short)
    {
        $this->db->where('short_form', $short);
        $query = $this->db->get('languages');
        return $query->row();
    }

    //get languages
    public function get_languages()
    {
        $this->db->order_by('languages.language_order');
        $query = $this->db->get('languages');
        return $query->result();
    }

    //get active languages
    public function get_active_languages()
    {
        $this->db->where('status', 1);
        $this->db->order_by('languages.language_order');
        $query = $this->db->get('languages');
        return $query->result();
    }

    //check short form
    public function check_short_form()
    {
        $short_form = $this->input->post('short_form', true);

        $pages = $this->page_model->get_all_pages();
        foreach ($pages as $page) {
            if ($page->slug == trim($short_form)) {
                return false;
            }
        }
        return true;
    }

    //update language
    public function update_language($id)
    {
        $data = $this->input_values();

        $this->db->where('id', $id);
        return $this->db->update('languages', $data);
    }

    //set language
    public function set_language()
    {
        $data = array(
            'site_lang' => $this->input->post('site_lang', true),
        );

        $lang = $this->language_model->get_language($data["site_lang"]);

        if (!empty($lang)) {
            $this->db->where('id', 1);
            if ($this->db->update('general_settings', $data)) {
                return true;
            }
        }

        return false;
    }

    //delete language
    public function delete_language($id)
    {
        $language = $this->get_language($id);

        if (!empty($language)) {

            //delete widgets
            $widgets = $this->widget_model->get_widgets_by_lang($id);
            foreach ($widgets as $widget) {
                $this->db->where('id', $widget->id);
                $this->db->delete('widgets');
            }

            //delete pages
            $pages = $this->page_model->get_pages_by_lang($id);
            foreach ($pages as $page) {
                $this->db->where('id', $page->id);
                $this->db->delete('pages');
            }

            $this->remove_language_folder($language->folder_name);

            $this->db->where('id', $id);
            return $this->db->delete('languages');
        } else {
            return false;
        }
    }

    //create language folder
    public function create_language_folder($lang_name)
    {
        $root = FCPATH . "application/language/" . $lang_name;
        $default = FCPATH . "application/language/default";

        if (!file_exists($root) && is_writable("application/language")) {
            mkdir($root, 0777, true);
            copy($default . '/db_lang.php', $root . '/db_lang.php');
            copy($default . '/email_lang.php', $root . '/email_lang.php');
            copy($default . '/form_validation_lang.php', $root . '/form_validation_lang.php');
            copy($default . '/upload_lang.php', $root . '/upload_lang.php');
            copy($default . '/site_lang.php', $root . '/site_lang.php');
            copy($default . '/index.html', $root . '/index.html');
            return true;
        } else {
            return false;
        }
    }

    //remove language folder
    public function remove_language_folder($lang_name)
    {
        $root = FCPATH . "application/language/" . $lang_name;

        //delete files
        $files = glob($root . '/*');
        if (!empty($files)) {
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file); //delete file
                }
            }
        }

        //delete folder
        if (is_dir($root)) {
            rmdir($root);
        }
    }

    //get phrases
    public function get_phrases($lang_name)
    {
        $lang = array();
        $phrases = array();
        include 'application/language/' . $lang_name . '/site_lang.php';

        foreach ($lang as $key => $value) {
            $phrases[] = array(
                'phrase' => $key,
                'label' => $value
            );
        }

        return $phrases;
    }

    //create language file
    public function create_language_file($lang_name, $phrases, $labels)
    {
        $start = '<?php defined("BASEPATH") OR exit("No direct script access allowed");' . PHP_EOL . PHP_EOL;
        $keys = '';
        $end = '?>';

        $i = 0;
        foreach ($phrases["phrase"] as $item) {
            if (!empty($item) && !empty($labels["label"][$i])) {
                //escape
                if (strpos($labels["label"][$i], '"') !== false) {
                    $labels["label"][$i] = str_replace('"', '&quot;', $labels["label"][$i]);
                }
                $keys .= '$lang["' . $item . '"] = "' . $labels["label"][$i] . '";' . PHP_EOL;
            }

            $i++;
        }

        $content = $start . $keys . $end;

        file_put_contents(FCPATH . "application/language/" . $lang_name . "/site_lang.php", $content);
    }

    //update language file
    public function update_language_file($lang_name, $phrases, $labels)
    {
        $start = '<?php defined("BASEPATH") OR exit("No direct script access allowed");' . PHP_EOL . PHP_EOL;
        $keys = '';
        $end = '?>';

        $old_phrases = $this->get_phrases($lang_name);

        foreach ($old_phrases as $old_item) {

            $i = 0;

            foreach ($phrases["phrase"] as $item) {

                if (!empty($item) && !empty($labels["label"][$i])) {

                    if ($old_item["phrase"] == $item) {
                        //echo $labels["label"][$i];
                        $old_item["label"] = $labels["label"][$i];
                    }

                    //escape
                    if (strpos($labels["label"][$i], '"') !== false) {
                        $labels["label"][$i] = str_replace('"', '&quot;', $labels["label"][$i]);
                    }

                }

                $i++;
            }

            $keys .= '$lang["' . $old_item["phrase"] . '"] = "' . $old_item["label"] . '";' . PHP_EOL;

        }

        $content = $start . $keys . $end;

        file_put_contents(FCPATH . "application/language/" . $lang_name . "/site_lang.php", $content);
    }
}
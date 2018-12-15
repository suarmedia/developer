<?php
/*
 * Custom Helpers
 *
 */

//check auth
if (!function_exists('lang_base_url')) {
    function lang_base_url()
    {
        // Get a reference to the controller object
        $ci =& get_instance();
        return $ci->lang_base_url;
    }
}

//check auth
if (!function_exists('auth_check')) {
    function auth_check()
    {
        // Get a reference to the controller object
        $ci =& get_instance();
        return $ci->auth_model->is_logged_in();
    }
}

//check admin
if (!function_exists('is_admin')) {
    function is_admin()
    {
        // Get a reference to the controller object
        $ci =& get_instance();
        return $ci->auth_model->is_admin();
    }
}


//user permission
if (!function_exists('check_user_permission')) {
    function check_user_permission($section)
    {
        $ci =& get_instance();
        try {
            if (auth_check()) {
                return $ci->auth_model->check_permission(user()->role, $section);
            }
        } catch (Exception $e) {
            return false;
        }
        return false;
    }
}

//check permission
if (!function_exists('check_permission')) {
    function check_permission($section)
    {
        if (!check_user_permission($section)) {
            redirect(lang_base_url());
        }
    }
}

//check permission
if (!function_exists('check_admin')) {
    function check_admin()
    {
        if (!is_admin()) {
            redirect(lang_base_url());
        }
    }
}


//admin url
if (!function_exists('admin_url')) {
    function admin_url()
    {
        require APPPATH . "config/route_slugs.php";
        return base_url() . $custom_slug_array["admin"] . "/";
    }
}

//get logged user
if (!function_exists('user')) {
    function user()
    {
        // Get a reference to the controller object
        $ci =& get_instance();
        $user = $ci->auth_model->get_logged_user();
        if (empty($user)) {
            $ci->auth_model->logout();
        } else {
            return $user;
        }

    }
}

//get user by id
if (!function_exists('get_user')) {
    function get_user($user_id)
    {
        // Get a reference to the controller object
        $ci =& get_instance();
        return $ci->auth_model->get_user($user_id);
    }
}

//set cached data by lang
if (!function_exists('set_cache_data')) {
    function set_cache_data($key, $data)
    {
        $ci =& get_instance();
        $key = $key . "_lang" . $ci->language_id;
        if ($ci->general_settings->cache_system == 1) {
            $ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
            $ci->cache->save($key, $data, $ci->general_settings->cache_refresh_time);
        }
    }
}

//get cached data by lang
if (!function_exists('get_cached_data')) {
    function get_cached_data($key)
    {
        $ci =& get_instance();
        $key = $key . "_lang" . $ci->language_id;
        if ($ci->general_settings->cache_system == 1) {
            $ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
            if ($data = $ci->cache->get($key)) {
                return $data;
            }
        }
        return false;
    }
}

//reset cache data
if (!function_exists('reset_cache_data')) {
    function reset_cache_data()
    {
        $ci =& get_instance();
        $path = $ci->config->item('cache_path');

        $cache_path = ($path == '') ? APPPATH . 'cache/' : $path;

        $handle = opendir($cache_path);
        while (($file = readdir($handle)) !== FALSE) {
            //Leave the directory protection alone
            if ($file != '.htaccess' && $file != 'index.html') {
                @unlink($cache_path . '/' . $file);
            }
        }
        closedir($handle);
    }
}

//reset cache data on change
if (!function_exists('reset_cache_data_on_change')) {
    function reset_cache_data_on_change()
    {
        $ci =& get_instance();
        $settings = $ci->settings_model->get_general_settings();
        if ($settings->refresh_cache_database_changes == 1) {
            reset_cache_data();
        }
    }
}

//get parent link
if (!function_exists('helper_get_parent_link')) {
    function helper_get_parent_link($parent_id, $type)
    {
        // Get a reference to the controller object
        $ci =& get_instance();
        return $ci->navigation_model->get_parent_link($parent_id, $type);
    }
}

//get sub menu links
if (!function_exists('helper_get_sub_menu_links')) {
    function helper_get_sub_menu_links($parent_id, $type)
    {
        // Get a reference to the controller object
        $ci =& get_instance();
        return $ci->navigation_model->get_sub_links($parent_id, $type);
    }
}
//get category
if (!function_exists('helper_get_category')) {
    function helper_get_category($category_id)
    {
        // Get a reference to the controller object
        $ci =& get_instance();
        return $ci->category_model->get_category($category_id);
    }
}

//get subcategories
if (!function_exists('helper_get_subcategories')) {
    function helper_get_subcategories($parent_id)
    {
        // Get a reference to the controller object
        $ci =& get_instance();
        return $ci->category_model->get_subcategories_by_parent_id($parent_id);
    }
}


//get posts category info
if (!function_exists('get_post_category')) {
    function get_post_category($post)
    {
        if (!empty($post)) {
            $ci =& get_instance();

            //check if subcategory exists
            $category = $ci->category_model->get_category($post->subcategory_id);

            if (!empty($category)) {
                $data = array(
                    'id' => $category->id,
                    'name' => $category->name,
                    'name_slug' => $category->name_slug,
                    'color' => $category->color,
                );
                return $data;
            } else {

                //check if category exists
                $category = $ci->category_model->get_category($post->category_id);
                if (!empty($category)) {
                    $data = array(
                        'id' => $category->id,
                        'name' => $category->name,
                        'name_slug' => $category->name_slug,
                        'color' => $category->color,
                    );
                    return $data;
                }
            }

            $data = array(
                'name' => "",
                'name_slug' => "",
                'color' => "",
            );
            return $data;
        }
    }
}

//get last posts by category
if (!function_exists('helper_get_last_posts_by_category')) {
    function helper_get_last_posts_by_category($category_id, $count)
    {
        // Get a reference to the controller object
        $ci =& get_instance();
        return $ci->post_model->get_last_posts_by_category($category_id, $count);
    }
}
//get latest posts by category
if (!function_exists('get_latest_posts_by_category')) {
    function get_latest_posts_by_category($category, $count)
    {
        // Get a reference to the controller object
        $ci =& get_instance();
        return $ci->post_model->get_latest_posts_by_category($category, $count);
    }
}
//get subcategory posts
if (!function_exists('helper_get_last_posts_by_subcategory')) {
    function helper_get_last_posts_by_subcategory($subcategory_id, $count)
    {
        // Get a reference to the controller object
        $ci =& get_instance();
        return $ci->post_model->get_last_posts_by_subcategory($subcategory_id, $count);
    }
}

//get post images
if (!function_exists('get_post_image')) {
    function get_post_image($post, $image_size)
    {
        if (!empty($post)) {

            if (!empty($post->image_url)) {
                return $post->image_url;
            } else {
                if ($image_size == "big") {
                    return base_url() . $post->image_big;
                } elseif ($image_size == "default") {
                    return base_url() . $post->image_default;
                } elseif ($image_size == "slider") {
                    return base_url() . $post->image_slider;
                } elseif ($image_size == "mid") {
                    return base_url() . $post->image_mid;
                } elseif ($image_size == "small") {
                    return base_url() . $post->image_small;
                }
            }

        }
    }
}


//get post images
if (!function_exists('get_post_additional_images')) {
    function get_post_additional_images($post_id)
    {
        $ci =& get_instance();
        return $ci->post_file_model->get_post_additional_images($post_id);
    }
}


//get post audios
if (!function_exists('get_post_audios')) {
    function get_post_audios($post_id)
    {
        $ci =& get_instance();
        return $ci->post_file_model->get_post_audios($post_id);
    }
}


//get ad codes
if (!function_exists('helper_get_ad_codes')) {
    function helper_get_ad_codes($ad_space)
    {
        // Get a reference to the controller object
        $ci =& get_instance();
        return $ci->ad_model->get_ad_codes($ad_space);
    }
}

//get translated message
if (!function_exists('trans')) {
    function trans($string)
    {
        $ci =& get_instance();
        return $ci->lang->line($string);
    }
}

//print old form data
if (!function_exists('old')) {
    function old($field)
    {
        $ci =& get_instance();
        return html_escape($ci->session->flashdata('form_data')[$field]);
    }
}

//delete image from server
if (!function_exists('delete_image_from_server')) {
    function delete_image_from_server($path)
    {
        $full_path = FCPATH . $path;
        if (strlen($path) > 15 && file_exists($full_path)) {
            unlink($full_path);
        }
    }
}

//delete file from server
if (!function_exists('delete_file_from_server')) {
    function delete_file_from_server($path)
    {
        $full_path = FCPATH . $path;
        if (strlen($path) > 15 && file_exists($full_path)) {
            unlink($full_path);
        }
    }
}

//is category has subcategory
if (!function_exists('is_category_has_subcategory')) {
    function is_category_has_subcategory($id)
    {
        $ci =& get_instance();

        if (count($ci->category_model->get_subcategories_by_parent_id($id)) > 0) {
            return true;
        } else {
            return false;
        }
    }
}

//get user avatar
if (!function_exists('get_user_avatar')) {
    function get_user_avatar($user)
    {
        if (!empty($user)) {
            if (!empty($user->avatar) && file_exists(FCPATH . $user->avatar)) {
                return base_url() . $user->avatar;
            } elseif (!empty($user->avatar)) {
                return $user->avatar;
            } else {
                return base_url() . "assets/img/user.png";
            }
        } else {
            return base_url() . "assets/img/user.png";
        }
    }
}

//get user avatar by id
if (!function_exists('get_user_avatar_by_id')) {
    function get_user_avatar_by_id($user_id)
    {
        $ci =& get_instance();

        $user = $ci->auth_model->get_user($user_id);
        if (!empty($user)) {
            if (!empty($user->avatar) && file_exists(FCPATH . $user->avatar)) {
                return base_url() . $user->avatar;
            } elseif (!empty($user->avatar)) {
                return $user->avatar;
            } else {
                return base_url() . "assets/img/user.png";
            }
        } else {
            return base_url() . "assets/img/user.png";
        }
    }
}

//get page title
if (!function_exists('get_page_title')) {
    function get_page_title($page)
    {
        if (!empty($page)) {
            return html_escape($page->title);
        } else {
            return "";
        }
    }
}

//get page description
if (!function_exists('get_page_description')) {
    function get_page_description($page)
    {
        if (!empty($page)) {
            return html_escape($page->description);
        } else {
            return "";
        }
    }
}

//get page keywords
if (!function_exists('get_page_keywords')) {
    function get_page_keywords($page)
    {
        if (!empty($page)) {
            return html_escape($page->keywords);
        } else {
            return "";
        }
    }
}

//generate post url
if (!function_exists('post_url')) {
    function post_url($post)
    {
        return lang_base_url() . html_escape($post->title_slug);
    }
}

//get post comment count
if (!function_exists('get_post_comment_count')) {
    function get_post_comment_count($post_id)
    {
        // Get a reference to the controller object
        $ci =& get_instance();
        return $ci->comment_model->get_post_comment_count($post_id);
    }
}

//get subcomments
if (!function_exists('get_subcomments')) {
    function get_subcomments($comment_id)
    {
        // Get a reference to the controller object
        $ci =& get_instance();
        return $ci->comment_model->get_subcomments($comment_id);
    }
}

//get comment like count
if (!function_exists('get_comment_like_count')) {
    function get_comment_like_count($comment_id)
    {
        // Get a reference to the controller object
        $ci =& get_instance();
        return $ci->comment_model->comment_like_count($comment_id);
    }
}

//get total vote count
if (!function_exists('get_total_vote_count')) {
    function get_total_vote_count($poll_id)
    {
        // Get a reference to the controller object
        $ci =& get_instance();
        return $ci->poll_model->get_total_vote_count($poll_id);
    }
}

//get option vote count
if (!function_exists('get_option_vote_count')) {
    function get_option_vote_count($poll_id, $option)
    {
        // Get a reference to the controller object
        $ci =& get_instance();
        return $ci->poll_model->get_option_vote_count($poll_id, $option);
    }
}

//date format
if (!function_exists('helper_date_format')) {
    function helper_date_format($datetime)
    {
        $date = date("M j, Y", strtotime($datetime));
        $date = str_replace("Jan", trans("January"), $date);
        $date = str_replace("Feb", trans("February"), $date);
        $date = str_replace("Mar", trans("March"), $date);
        $date = str_replace("Apr", trans("April"), $date);
        $date = str_replace("May", trans("May"), $date);
        $date = str_replace("Jun", trans("June"), $date);
        $date = str_replace("Jul", trans("July"), $date);
        $date = str_replace("Aug", trans("August"), $date);
        $date = str_replace("Sep", trans("September"), $date);
        $date = str_replace("Oct", trans("October"), $date);
        $date = str_replace("Nov", trans("November"), $date);
        $date = str_replace("Dec", trans("December"), $date);
        return $date;

    }
}

//get logo
if (!function_exists('get_logo')) {
    function get_logo($settings)
    {
        if (!empty($settings)) {
            if (!empty($settings->logo) && file_exists(FCPATH . $settings->logo)) {
                return base_url() . $settings->logo;
            } else {
                return base_url() . "assets/img/logo.svg";
            }
        } else {
            return base_url() . "assets/img/logo.svg";
        }
    }
}

//get logo footer
if (!function_exists('get_logo_footer')) {
    function get_logo_footer($settings)
    {
        if (!empty($settings)) {
            if (!empty($settings->logo_footer) && file_exists(FCPATH . $settings->logo_footer)) {
                return base_url() . $settings->logo_footer;
            } else {
                return base_url() . "assets/img/logo-footer.svg";
            }
        } else {
            return base_url() . "assets/img/logo-footer.svg";
        }
    }
}

//get logo email
if (!function_exists('get_logo_email')) {
    function get_logo_email($settings)
    {
        if (!empty($settings)) {
            if (!empty($settings->logo_email) && file_exists(FCPATH . $settings->logo_email)) {
                return base_url() . $settings->logo_email;
            } else {
                return base_url() . "assets/img/logo.png";
            }
        } else {
            return base_url() . "assets/img/logo.png";
        }
    }
}

//get favicon
if (!function_exists('get_favicon')) {
    function get_favicon($settings)
    {
        if (!empty($settings)) {
            if (!empty($settings->favicon) && file_exists(FCPATH . $settings->favicon)) {
                return base_url() . $settings->favicon;
            } else {
                return base_url() . "assets/img/favicon.png";
            }
        } else {
            return base_url() . "assets/img/favicon.png";
        }
    }
}

//get settings
if (!function_exists('get_settings')) {
    function get_settings($lang_id)
    {
        $ci =& get_instance();
        $ci->load->model('settings_model');
        return $ci->settings_model->get_settings($lang_id);
    }
}

//get general settings
if (!function_exists('get_general_settings')) {
    function get_general_settings()
    {
        $ci =& get_instance();
        $ci->load->model('settings_model');
        return $ci->settings_model->get_general_settings();
    }
}

//get admin url
if (!function_exists('get_admin_url')) {
    function get_admin_url()
    {
        // Get a reference to the controller object
        $ci =& get_instance();
        $ci->load->model('settings_model');
        $settings = $ci->settings_model->get_general_settings();

        if (!empty($settings)) {
            return $settings->admin_url();
        }
    }
}

if (!function_exists('chk_lce')) {
    function chk_lce()
    {
        if (tm_referx() == hash('whirlpool', log_mes_re() . get_instanx())) {
            return true;
        }
        return false;
    }
}

//date diff
if (!function_exists('date_difference')) {
    function date_difference($date1, $date2, $format = '%a')
    {
        $datetime_1 = date_create($date1);
        $datetime_2 = date_create($date2);
        $diff = date_diff($datetime_1, $datetime_2);
        return $diff->format($format);
    }
}

//get feed posts count
if (!function_exists('get_feed_posts_count')) {
    function get_feed_posts_count($feed_id)
    {
        $ci =& get_instance();
        return $ci->post_admin_model->get_feed_posts_count($feed_id);
    }
}

//get language
if (!function_exists('get_language')) {
    function get_language($lang_id)
    {
        $ci =& get_instance();
        return $ci->language_model->get_language($lang_id);
    }
}

//get languages
if (!function_exists('get_active_languages')) {
    function get_active_languages()
    {
        $ci =& get_instance();
        $ci->load->model('language_model');
        return $ci->language_model->get_active_languages();
    }
}

//set cookie
if (!function_exists('helper_setcookie')) {
    function helper_setcookie($name, $value)
    {
        setcookie($name, $value, time() + (86400 * 30), "/"); //30 days
    }
}

//delete cookie
if (!function_exists('helper_deletecookie')) {
    function helper_deletecookie($name)
    {
        if (isset($_COOKIE[$name])) {
            setcookie($name, "", time() - 3600, "/");
        }
    }
}

//is reaction voted
if (!function_exists('is_reaction_voted')) {
    function is_reaction_voted($post_id, $reaction)
    {
        if (isset($_SESSION["vr_reaction_" . $reaction . "_" . $post_id]) && $_SESSION["vr_reaction_" . $reaction . "_" . $post_id] == '1') {
            return true;
        } else {
            return false;
        }
    }
}

//get categories
if (!function_exists('get_categories')) {
    function get_categories()
    {
        // Get a reference to the controller object
        $ci =& get_instance();
        return $ci->categories;
    }
}
//get pages
if (!function_exists('get_pages')) {
    function get_pages()
    {
        // Get a reference to the controller object
        $ci =& get_instance();
        return $ci->pages;
    }
}
//check user follows
if (!function_exists('is_user_follows')) {
    function is_user_follows($following_id, $follower_id)
    {
        $ci =& get_instance();
        return $ci->profile_model->is_user_follows($following_id, $follower_id);
    }
}
function time_ago($timestamp)
{
    $time_ago = strtotime($timestamp);
    $current_time = time();
    $time_difference = $current_time - $time_ago;
    $seconds = $time_difference;
    $minutes = round($seconds / 60);           // value 60 is seconds
    $hours = round($seconds / 3600);           //value 3600 is 60 minutes * 60 sec
    $days = round($seconds / 86400);          //86400 = 24 * 60 * 60;
    $weeks = round($seconds / 604800);          // 7*24*60*60;
    $months = round($seconds / 2629440);     //((365+365+365+365+366)/5/12)*24*60*60
    $years = round($seconds / 31553280);     //(365+365+365+365+366)/5 * 24 * 60 * 60
    if ($seconds <= 60) {
        return trans("just_now");
    } else if ($minutes <= 60) {
        if ($minutes == 1) {
            return "1 " . trans("minute") . " " . trans("ago");
        } else {
            return $minutes . " " . trans("minutes") . " " . trans("ago");
        }
    } else if ($hours <= 24) {
        if ($hours == 1) {
            return "1 " . trans("hour") . " " . trans("ago");
        } else {
            return $hours . " " . trans("hours") . " " . trans("ago");
        }
    } else if ($days <= 30) {
        if ($days == 1) {
            return "1 " . trans("day") . " " . trans("ago");
        } else {
            return $days . " " . trans("days") . " " . trans("ago");
        }
    } else if ($months <= 12) {
        if ($months == 1) {
            return "1 " . trans("month") . " " . trans("ago");
        } else {
            return $months . " " . trans("months") . " " . trans("ago");
        }
    } else {
        if ($years == 1) {
            return "1 " . trans("year") . " " . trans("ago");
        } else {
            return $years . " " . trans("years") . " " . trans("ago");
        }
    }
}


//generate slug
if (!function_exists('str_slug')) {
    function str_slug($str)
    {
        return url_title(convert_accented_characters($str), "-", true);
    }
}

?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post_controller extends Admin_Core_Controller
{

    public function __construct()
    {
        parent::__construct();
        get_posts_latest();
        if ($this->general_settings->email_verification == 1 && user()->email_status == 0 && user()->role != "admin") {
            $this->session->set_flashdata('error', trans("msg_confirmed_required"));
            redirect(lang_base_url() . "settings");
        }
    }


    /**
     * Add Post
     */
    public function add_post()
    {
        check_permission('add_post');
        $data['title'] = trans("add_post");
        $data['top_categories'] = $this->category_model->get_top_categories();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/post/add_post', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Add Audio
     */
    public function add_audio()
    {
        check_permission('add_post');
        $data['title'] = trans("add_audio");
        $data['top_categories'] = $this->category_model->get_top_categories();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/post/add_audio', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Add Video
     */
    public function add_video()
    {
        check_permission('add_post');
        $data['title'] = trans("add_video");
        $data['top_categories'] = $this->category_model->get_top_categories();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/post/add_video', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Add Post Post
     */
    public function add_post_post()
    {
        check_permission('add_post');
        //validate inputs
        $this->form_validation->set_rules('title', trans("title"), 'required|xss_clean|max_length[500]');
        $this->form_validation->set_rules('summary', trans("summary"), 'xss_clean|max_length[5000]');
        $this->form_validation->set_rules('category_id', trans("category"), 'required');
        $this->form_validation->set_rules('optional_url', trans("optional_url"), 'xss_clean|max_length[1000]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->post_admin_model->input_values());
            redirect($this->agent->referrer());
        } else {

            $post_type = $this->input->post('post_type', true);
            //if post added
            if ($this->post_admin_model->add_post($post_type)) {
                //last id
                $last_id = $this->db->insert_id();
                //update slug
                $this->post_admin_model->update_slug($last_id);
                //insert post tags
                $this->tag_model->add_post_tags($last_id);
                if ($post_type == "audio") {
                    $this->post_file_model->add_post_audios($last_id);
                } elseif ($post_type == "post") {
                    $this->post_file_model->add_post_additional_images($last_id);
                }

                //send post
                $send_post_to_subscribes = $this->input->post('send_post_to_subscribes', true);
                if ($send_post_to_subscribes) {
                    $this->send_to_all_subscribers($last_id);
                }
                $this->session->set_flashdata('success', trans("post") . " " . trans("msg_suc_added"));
                reset_cache_data_on_change();
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('form_data', $this->post_admin_model->input_values());
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }


    /**
     * Send to All  Subscribers
     */
    public function send_to_all_subscribers($post_id)
    {
        $post = $this->post_admin_model->get_post($post_id);
        if ($this->selected_lang->id == $post->lang_id) {
            $link = base_url() . $post->title_slug;
        } else {
            $lang = get_language($post->lang_id);
            $link = base_url() . $lang->short_form . "/" . $post->title_slug;
        }
        if (!empty($post)) {
            $subject = $post->title;
            $message = "<a href='" . $link . "'><img src='" . base_url() . $post->image_default . "' alt='' style='max-width: 100%; height: auto;'></a><br><br>" . $post->content;
            $this->load->model("email_model");
            $data['subscribers'] = $this->newsletter_model->get_subscribers();
            foreach ($data['subscribers'] as $item) {
                $this->email_model->send_email($item->email, $subject, $message, true, $link);
            }
        }
    }


    /**
     * Posts
     */
    public function posts()
    {
        check_permission('add_post');
        $data['title'] = trans('posts');
        $data['authors'] = $this->auth_model->get_all_users();
        $data['form_action'] = admin_url() . "posts";
        $data['list_type'] = "posts";

        //get paginated posts
        $pagination = $this->paginate(admin_url() . 'posts', $this->post_admin_model->get_paginated_posts_count('posts'));
        $data['posts'] = $this->post_admin_model->get_paginated_posts($pagination['per_page'], $pagination['offset'], 'posts');

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/post/posts', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Slider Posts
     */
    public function slider_posts()
    {
        check_permission('manage_all_posts');
        $data['title'] = trans('slider_posts');
        $data['authors'] = $this->auth_model->get_all_users();
        $data['form_action'] = admin_url() . "slider-posts";
        $data['list_type'] = "slider_posts";

        //get paginated posts
        $pagination = $this->paginate(admin_url() . 'slider-posts', $this->post_admin_model->get_paginated_posts_count('slider_posts'));
        $data['posts'] = $this->post_admin_model->get_paginated_posts($pagination['per_page'], $pagination['offset'], 'slider_posts');

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/post/posts', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Featured Posts
     */
    public function featured_posts()
    {
        check_permission('manage_all_posts');
        $data['title'] = trans('featured_posts');
        $data['authors'] = $this->auth_model->get_all_users();
        $data['form_action'] = admin_url() . "featured-posts";
        $data['list_type'] = "featured_posts";

        //get paginated posts
        $pagination = $this->paginate(admin_url() . 'featured-posts', $this->post_admin_model->get_paginated_posts_count('featured_posts'));
        $data['posts'] = $this->post_admin_model->get_paginated_posts($pagination['per_page'], $pagination['offset'], 'featured_posts');

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/post/posts', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Breaking news
     */
    public function breaking_news()
    {
        check_permission('manage_all_posts');
        $data['title'] = trans('breaking_news');
        $data['authors'] = $this->auth_model->get_all_users();
        $data['form_action'] = admin_url() . "breaking-news";
        $data['list_type'] = "breaking_news";

        //get paginated posts
        $pagination = $this->paginate(admin_url() . 'breaking-news', $this->post_admin_model->get_paginated_posts_count('breaking_news'));
        $data['posts'] = $this->post_admin_model->get_paginated_posts($pagination['per_page'], $pagination['offset'], 'breaking_news');

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/post/posts', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Recommended Posts
     */
    public function recommended_posts()
    {
        check_permission('manage_all_posts');
        $data['title'] = trans('recommended_posts');
        $data['authors'] = $this->auth_model->get_all_users();
        $data['form_action'] = admin_url() . "recommended-posts";
        $data['list_type'] = "recommended_posts";

        //get paginated posts
        $pagination = $this->paginate(admin_url() . 'recommended-posts', $this->post_admin_model->get_paginated_posts_count('recommended_posts'));
        $data['posts'] = $this->post_admin_model->get_paginated_posts($pagination['per_page'], $pagination['offset'], 'recommended_posts');

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/post/posts', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Pending Posts
     */
    public function pending_posts()
    {
        check_permission('add_post');
        $data['title'] = trans('pending_posts');
        $data['authors'] = $this->auth_model->get_all_users();
        $data['form_action'] = admin_url() . "pending-posts";
        $data['list_type'] = "pending_posts";

        //get paginated posts
        $pagination = $this->paginate(admin_url() . 'pending-posts', $this->post_admin_model->get_paginated_pending_posts_count());
        $data['posts'] = $this->post_admin_model->get_paginated_pending_posts($pagination['per_page'], $pagination['offset']);

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/post/pending_posts', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Scheduled Posts
     */
    public function scheduled_posts()
    {
        check_permission('add_post');
        $data['title'] = trans('scheduled_posts');
        $data['authors'] = $this->auth_model->get_all_users();
        $data['form_action'] = admin_url() . "scheduled-posts";

        //get paginated posts
        $pagination = $this->paginate(admin_url() . 'scheduled-posts', $this->post_admin_model->get_paginated_scheduled_posts_count());
        $data['posts'] = $this->post_admin_model->get_paginated_scheduled_posts($pagination['per_page'], $pagination['offset']);

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/post/scheduled_posts', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Drafts
     */
    public function drafts()
    {
        check_permission('add_post');
        $data['title'] = trans('drafts');
        $data['authors'] = $this->auth_model->get_all_users();
        $data['form_action'] = admin_url() . "drafts";

        //get paginated posts
        $pagination = $this->paginate(admin_url() . 'drafts', $this->post_admin_model->get_paginated_drafts_count());
        $data['posts'] = $this->post_admin_model->get_paginated_drafts($pagination['per_page'], $pagination['offset']);

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/post/drafts', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Update Post
     */
    public function update_post($id)
    {
        check_permission('add_post');
        $data['title'] = trans("update_post");

        //get post
        $data['post'] = $this->post_admin_model->get_post($id);

        if (empty($data['post'])) {
            redirect($this->agent->referrer());
        }
        //combine post tags
        $tags = "";
        $count = 0;
        $tags_array = $this->tag_model->get_post_tags($id);
        foreach ($tags_array as $item) {
            if ($count > 0) {
                $tags .= ",";
            }
            $tags .= $item->tag;
            $count++;
        }

        $data['tags'] = $tags;
        $data['post_images'] = $this->post_file_model->get_post_additional_images($id);
        $data['categories'] = $this->category_model->get_top_categories_by_lang($data['post']->lang_id);
        $data['subcategories'] = $this->category_model->get_subcategories_by_parent_id($data['post']->category_id);
        $data['users'] = $this->auth_model->get_active_users();

        $this->load->view('admin/includes/_header', $data);
        if ($data['post']->post_type == "video") {
            $this->load->view('admin/post/update_video', $data);
        } elseif ($data['post']->post_type == "audio") {
            $this->load->view('admin/post/update_audio', $data);
        } else {
            $this->load->view('admin/post/update_post', $data);
        }
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Update Post Post
     */
    public function update_post_post()
    {
        check_permission('add_post');
        //validate inputs
        $this->form_validation->set_rules('title', trans("title"), 'required|xss_clean|max_length[500]');
        $this->form_validation->set_rules('summary', trans("summary"), 'xss_clean|max_length[5000]');
        $this->form_validation->set_rules('category_id', trans("category"), 'required');
        $this->form_validation->set_rules('optional_url', trans("optional_url"), 'xss_clean|max_length[1000]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->post_admin_model->input_values());
            redirect($this->agent->referrer());
        } else {
            //post id
            $post_id = $this->input->post('id', true);
            $post_type = $this->input->post('post_type', true);

            if ($this->post_admin_model->update_post($post_id, $post_type)) {

                //update slug
                $this->post_admin_model->update_slug($post_id);

                //update post tags
                $this->tag_model->update_post_tags($post_id);

                if ($post_type == "audio") {
                    $this->post_file_model->add_post_audios($post_id);
                } elseif ($post_type == "post") {
                    $this->post_file_model->add_post_additional_images($post_id);
                }
                $this->session->set_flashdata('success', trans("post") . " " . trans("msg_suc_updated"));
                reset_cache_data_on_change();
            } else {
                $this->session->set_flashdata('form_data', $this->post_admin_model->input_values());
                $this->session->set_flashdata('error', trans("msg_error"));
            }
        }

        redirect($this->agent->referrer());
    }

    /**
     * Post Options Post
     */
    public function post_options_post()
    {
        $option = $this->input->post('option', true);
        $id = $this->input->post('id', true);

        $data["post"] = $this->post_admin_model->get_post($id);

        //check if exists
        if (empty($data['post'])) {
            redirect($this->agent->referrer());
        }

        //if option add remove from slider
        if ($option == 'add-remove-from-slider') {
            check_permission('manage_all_posts');
            $result = $this->post_admin_model->post_add_remove_slider($id);
            if ($result == "removed") {
                $this->session->set_flashdata('success', trans("msg_remove_slider"));
            }
            if ($result == "added") {
                $this->session->set_flashdata('success', trans("msg_add_slider"));
            }
        } elseif ($option == 'add-remove-from-featured') {
            check_permission('manage_all_posts');
            $result = $this->post_admin_model->post_add_remove_featured($id);
            if ($result == "removed") {
                $this->session->set_flashdata('success', trans("msg_remove_featured"));
            }
            if ($result == "added") {
                $this->session->set_flashdata('success', trans("msg_add_featured"));
            }
        } elseif ($option == 'add-remove-from-breaking') {
            check_permission('manage_all_posts');
            $result = $this->post_admin_model->post_add_remove_breaking($id);
            if ($result == "removed") {
                $this->session->set_flashdata('success', trans("msg_remove_breaking"));
            }
            if ($result == "added") {
                $this->session->set_flashdata('success', trans("msg_add_breaking"));
            }
        } elseif ($option == 'add-remove-from-recommended') {
            check_permission('manage_all_posts');
            $result = $this->post_admin_model->post_add_remove_recommended($id);
            if ($result == "removed") {
                $this->session->set_flashdata('success', trans("msg_remove_recommended"));
            }
            if ($result == "added") {
                $this->session->set_flashdata('success', trans("msg_add_recommended"));
            }
        } elseif ($option == 'approve') {
            check_permission('manage_all_posts');
            if ($this->post_admin_model->approve_post($id)) {
                $this->session->set_flashdata('success', trans("msg_post_approved"));
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
            }
        } elseif ($option == 'publish') {
            check_permission('add_post');
            if ($this->post_admin_model->publish_post($id)) {
                $this->session->set_flashdata('success', trans("msg_published"));
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
            }
        } elseif ($option == 'publish_draft') {
            check_permission('add_post');
            if ($this->post_admin_model->publish_draft($id)) {
                $this->session->set_flashdata('success', trans("msg_published"));
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
            }
        }
        reset_cache_data_on_change();
        redirect($this->agent->referrer());
    }

    /**
     * Delete Post
     */
    public function delete_post()
    {
        check_permission('add_post');
        $id = $this->input->post('id', true);
        $data["post"] = $this->post_admin_model->get_post($id);
        //check if exists
        if (empty($data['post'])) {
            $this->session->set_flashdata('error', trans("msg_error"));
        } else {
            if ($this->post_admin_model->delete_post($id)) {
                //delete post tags
                $this->tag_model->delete_post_tags($id);
                $this->session->set_flashdata('success', trans("post") . " " . trans("msg_suc_deleted"));
                reset_cache_data_on_change();
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
            }
        }
    }

    /**
     * Delete Selected Posts
     */
    public function delete_selected_posts()
    {
        check_permission('add_post');
        $post_ids = $this->input->post('post_ids', true);
        $this->post_admin_model->delete_multi_posts($post_ids);
        reset_cache_data_on_change();
    }

    /**
     * Save Featured Post Order
     */
    public function featured_posts_order_post()
    {
        check_permission('manage_all_posts');
        $post_id = $this->input->post('id', true);
        $order = $this->input->post('featured_order', true);
        $this->post_admin_model->save_featured_post_order($post_id, $order);
        reset_cache_data_on_change();
        redirect($this->agent->referrer());
    }


    /**
     * Save Home Slider Post Order
     */
    public function home_slider_posts_order_post()
    {
        check_permission('manage_all_posts');
        $post_id = $this->input->post('id', true);
        $order = $this->input->post('slider_order', true);
        $this->post_admin_model->save_home_slider_post_order($post_id, $order);
        reset_cache_data_on_change();
        redirect($this->agent->referrer());
    }


    /**
     * Get Video from URL
     */
    public function get_video_from_url()
    {
        $url = $this->input->post('url', true);

        $this->load->library('video_url_parser');
        echo $this->video_url_parser->get_url_embed($url);

    }


    /**
     * Get Video Thumbnail
     */
    public function get_video_thumbnail()
    {
        $url = $this->input->post('url', true);

        echo $this->file_model->get_video_thumbnail($url);
    }


    /**
     * Delete Additional Image
     */
    public function delete_post_additional_image()
    {
        $file_id = $this->input->post('file_id', true);
        $this->post_file_model->delete_post_additional_image($file_id);
    }


    /**
     * Delete Audio
     */
    public function delete_post_audio()
    {
        $post_id = $this->input->post('post_id', true);
        $audio_id = $this->input->post('audio_id', true);
        $this->post_file_model->delete_post_audio($post_id, $audio_id);
    }

    /**
     * Delete Video
     */
    public function delete_post_video()
    {
        $post_id = $this->input->post('post_id', true);
        $this->post_file_model->delete_post_video($post_id);
    }

    /**
     * Delete Post Main Image
     */
    public function delete_post_main_image()
    {
        $post_id = $this->input->post('post_id', true);
        $this->post_file_model->delete_post_main_image($post_id);
    }


    public function set_pagination_per_page($count)
    {
        $_SESSION['pagination_per_page'] = $count;
        redirect($this->agent->referrer());
    }
}

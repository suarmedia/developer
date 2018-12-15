<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Rss_model extends CI_Model
{
    //input values
    public function input_values()
    {
        $data = array(
            'lang_id' => $this->input->post('lang_id', true),
            'feed_name' => $this->input->post('feed_name', true),
            'feed_url' => $this->input->post('feed_url', true),
            'post_limit' => $this->input->post('post_limit', true),
            'category_id' => $this->input->post('category_id', true),
            'subcategory_id' => $this->input->post('subcategory_id', true),
            'auto_update' => $this->input->post('auto_update', true),
            'read_more_button' => $this->input->post('read_more_button', true),
            'read_more_button_text' => $this->input->post('read_more_button_text', true),
            'add_posts_as_draft' => $this->input->post('add_posts_as_draft', true)
        );
        return $data;
    }

    //add feed
    public function add_feed()
    {
        $data = $this->input_values();

        $file = $_FILES['file'];
        if (!empty($file['name'])) {
            $data["image_big"] = $this->upload_model->post_big_image_upload($file);
            $data["image_default"] = $this->upload_model->post_default_image_upload($file);
            $data["image_slider"] = $this->upload_model->post_slider_image_upload($file);
            $data["image_mid"] = $this->upload_model->post_mid_image_upload($file);
            $data["image_small"] = $this->upload_model->post_small_image_upload($file);
        }
        $data["user_id"] = user()->id;
        $data['created_at'] = date('Y-m-d H:i:s');

        return $this->db->insert('rss_feeds', $data);
    }

    //update feed
    public function update_feed($id)
    {
        $feed = $this->get_feed($id);

        if (!empty($feed)) {
            $data = $this->input_values();

            $file = $_FILES['file'];
            if (!empty($file['name'])) {
                $data["image_big"] = $this->upload_model->post_big_image_upload($file);
                $data["image_default"] = $this->upload_model->post_default_image_upload($file);
                $data["image_slider"] = $this->upload_model->post_slider_image_upload($file);
                $data["image_mid"] = $this->upload_model->post_mid_image_upload($file);
                $data["image_small"] = $this->upload_model->post_small_image_upload($file);
            }
            $this->db->where('id', $id);
            return $this->db->update('rss_feeds', $data);
        } else {
            return false;
        }
    }

    //update feed posts button
    public function update_feed_posts_button($feed_id)
    {
        $feed = $this->get_feed($feed_id);

        if (!empty($feed)) {

            $posts = $this->post_admin_model->get_posts_by_feed_id($feed_id);
            if (!empty($posts)) {
                foreach ($posts as $post) {
                    $data = array(
                        'show_post_url' => $feed->read_more_button
                    );

                    $this->db->where('id', $post->id);
                    $this->db->update('posts', $data);
                }
            }
        }
    }

    //add feed posts
    public function add_feed_posts($feed_id)
    {
        $feed = $this->get_feed($feed_id);

        if (!empty($feed)) {
            $this->add_rss_feed_posts($feed, "add");
        }
    }


    //add rss feed posts
    public function add_rss_feed_posts($feed)
    {
        if (!empty($feed)) {
            $response = $this->rss_parser->get_feeds($feed->feed_url);
            $i = 0;
            if (!empty($response['item'])) {
                foreach ($response['item'] as $item) {
                    if ($feed->post_limit == $i) {
                        break;
                    }
                    if ($this->post_admin_model->check_is_post_exists($item['title']) == false) {
                        $data = array();
                        $data['lang_id'] = $feed->lang_id;
                        $data['title'] = $this->clear_chars($item['title']);
                        $data['title_slug'] = str_slug(trim($item['title']));
                        $data['summary'] = $this->clear_chars(strip_tags($item['description']));
                        if (!empty($item['content'])) {
                            $data['content'] = $item['content'];
                        } else {
                            $data['content'] = $item['description'];
                        }
                        $data['category_id'] = $feed->category_id;
                        $data['subcategory_id'] = $feed->subcategory_id;
                        $image = $this->rss_parser->get_feed_image($item['link']);
                        if (!empty($image)) {
                            $data['image_url'] = $image;
                        }
                        $data['image_big'] = $feed->image_big;
                        $data['image_default'] = $feed->image_default;
                        $data['image_slider'] = $feed->image_slider;
                        $data['image_mid'] = $feed->image_mid;
                        $data['image_small'] = $feed->image_small;
                        $data['need_auth'] = 0;
                        $data['is_slider'] = 0;
                        $data['is_featured'] = 0;
                        $data['is_recommended'] = 0;
                        $data['is_breaking'] = 0;
                        $data['visibility'] = 1;
                        $data['post_type'] = "post";
                        $data['user_id'] = $feed->user_id;
                        if ($feed->add_posts_as_draft == 1) {
                            $data['status'] = 0;
                        } else {
                            $data['status'] = 1;
                        }
                        $data['feed_id'] = $feed->id;
                        $data['post_url'] = $item['link'];
                        $data['show_post_url'] = $feed->read_more_button;
                        $data['created_at'] = date('Y-m-d H:i:s');

                        $this->db->insert('posts', $data);
                        $this->post_admin_model->update_slug($this->db->insert_id());
                    }
                    $i++;
                }
                return true;
            }
        }
    }

    //get feed
    public function get_feed($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('rss_feeds');
        return $query->row();
    }

    //get feeds
    public function get_feeds()
    {
        $query = $this->db->get('rss_feeds');
        return $query->result();
    }

    //get feed posts
    public function get_feed_posts($feed_id)
    {
        $this->db->where('feed_id', $feed_id);
        $query = $this->db->get('feed_posts');
        return $query->result();
    }

    //delete feed
    public function delete_feed($id)
    {
        $feed = $this->get_feed($id);

        if (!empty($feed)) {
            $this->db->where('id', $id);
            return $this->db->delete('rss_feeds');
        } else {
            return false;
        }
    }

    public function clear_chars($str)
    {
        $str = htmlspecialchars_decode($str, ENT_QUOTES | ENT_XML1);
        return $str;
    }

}
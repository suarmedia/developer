<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post_file_model extends CI_Model
{
    //add post additional images
    public function add_post_additional_images($post_id)
    {
        $image_ids = $this->input->post('additional_post_image_id', true);

        if (!empty($image_ids)) {
            foreach ($image_ids as $image_id) {
                $image = $this->file_model->get_image($image_id);

                if (!empty($image)) {
                    $item = array(
                        'post_id' => $post_id,
                        'image_big' => $image->image_big,
                        'image_default' => $image->image_default,
                    );

                    if (!empty($item["image_default"])) {
                        $this->db->insert('post_images', $item);
                    }
                }
            }
        }
    }

    //delete additional image
    public function delete_post_additional_image($file_id)
    {
        $image = $this->get_post_additional_image($file_id);

        if (!empty($image)) {
            $this->db->where('id', $file_id);
            $this->db->delete('post_images');
        }
    }

    //delete additional images
    public function delete_post_additional_images($post_id)
    {
        $images = $this->get_post_additional_images($post_id);

        if (!empty($images)):

            foreach ($images as $image) {
                $this->db->where('id', $image->id);
                $this->db->delete('post_images');
            }

        endif;
    }

    //get post additional images
    public function get_post_additional_images($post_id)
    {
        $this->db->where('post_id', $post_id);
        $query = $this->db->get('post_images');
        return $query->result();
    }

    //get post additional image
    public function get_post_additional_image($file_id)
    {
        $this->db->where('id', $file_id);
        $query = $this->db->get('post_images');
        return $query->row();
    }

    //get post additional image count
    public function get_post_additional_image_count($post_id)
    {
        $this->db->where('post_id', $post_id);
        $query = $this->db->get('post_images');
        return $query->num_rows();
    }

    //add post audios
    public function add_post_audios($post_id)
    {
        $audio_ids = $this->input->post('post_audio_id', true);

        if (!empty($audio_ids)) {
            foreach ($audio_ids as $audio_id) {
                $audio = $this->file_model->get_audio($audio_id);

                if (!empty($audio)) {
                    $item = array(
                        'post_id' => $post_id,
                        'audio_id' => $audio->id,
                    );

                    $this->db->insert('post_audios', $item);
                }
            }
        }
    }

    //get audio
    public function get_audio($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('audios');
        return $query->row();
    }

    //get post audios
    public function get_post_audios($post_id)
    {
        $this->db->join('post_audios', 'audios.id = post_audios.audio_id');
        $this->db->where('post_audios.post_id', $post_id);
        $this->db->order_by('audios.id');
        $query = $this->db->get('audios');
        return $query->result();
    }

    //delete post audio
    public function delete_post_audio($post_id, $audio_id)
    {
        $this->db->where('post_id', $post_id);
        $this->db->where('audio_id', $audio_id);
        $this->db->delete('post_audios');
    }

    //delete post video
    public function delete_post_video($post_id)
    {
        $post = $this->post_admin_model->get_post($post_id);

        if (!empty($post)) {
            $data = array(
                'video_path' => ""
            );

            $this->db->where('id', $post_id);
            return $this->db->update('posts', $data);
        }
    }

    //delete post main image
    public function delete_post_main_image($post_id)
    {
        $post = $this->post_admin_model->get_post($post_id);

        if (!empty($post)) {
            $data = array(
                'image_big' => "",
                'image_default' => "",
                'image_slider' => "",
                'image_mid' => "",
                'image_small' => "",
                'image_url' => ""
            );

            $this->db->where('id', $post_id);
            $this->db->update('posts', $data);
        }
    }

    //delete post audios
    public function delete_post_audios($post_id)
    {
        $this->db->where('post_audios.post_id', $post_id);
        $query = $this->db->get('post_audios');
        $audios = $query->result();

        if (!empty($audios)):

            foreach ($audios as $audio) {
                $this->db->where('id', $audio->id);
                $this->db->delete('post_audios');
            }

        endif;

    }

}
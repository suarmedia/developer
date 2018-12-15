<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class File_model extends CI_Model
{
    //upload image
    public function upload_image()
    {
        if (isset($_FILES['img_file_input'])) {
            $file = $_FILES['img_file_input'];

            if (!empty($file['name'])) {

                $data = array(
                    'image_big' => $this->upload_model->post_big_image_upload($file),
                    'image_default' => $this->upload_model->post_default_image_upload($file),
                    'image_slider' => $this->upload_model->post_slider_image_upload($file),
                    'image_mid' => $this->upload_model->post_mid_image_upload($file),
                    'image_small' => $this->upload_model->post_small_image_upload($file),
                    'user_id' => $this->auth_user->id
                );

                if (!empty($data["image_mid"])) {
                    $this->db->insert('images', $data);
                }
            }
        }
    }

    //upload audio
    public function upload_audio()
    {
        if (isset($_FILES['audio_file'])) {
            $file = $_FILES['audio_file'];
            if (!empty($file['name'])) {

                $data = array(
                    'audio_path' => $this->upload_model->audio_upload($file),
                    'audio_name' => $this->input->post('audio_name', true),
                    'musician' => $this->input->post('musician', true),
                    'download_button' => $this->input->post('download_button', true),
                    'user_id' => $this->auth_user->id
                );

                if (!empty($data["audio_path"])) {
                    $this->db->insert('audios', $data);
                }
            }
        }
    }

    //upload video
    public function upload_video()
    {
        if (isset($_FILES['video_file'])) {
            $file = $_FILES['video_file'];
            if (!empty($file['name'])) {

                $data = array(
                    'video_path' => $this->upload_model->video_upload($file),
                    'video_name' => $this->input->post('video_name', true),
                    'user_id' => $this->auth_user->id
                );

                if (!empty($data["video_path"])) {
                    $this->db->insert('videos', $data);
                }
            }
        }
    }

    //get image
    public function get_image($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('images');
        return $query->row();
    }

    //get audio
    public function get_audio($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('audios');
        return $query->row();
    }

    //get video
    public function get_video($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('videos');
        return $query->row();
    }

    //get images
    public function get_images($count)
    {
        if ($this->general_settings->file_manager_show_files != 1) {
            $this->db->where('user_id', $this->auth_user->id);
        }
        $this->db->order_by('id', 'DESC');
        $this->db->limit($count);
        $query = $this->db->get('images');
        return $query->result();
    }

    //get more images
    public function get_more_images($last_id, $limit)
    {
        if ($this->general_settings->file_manager_show_files != 1) {
            $this->db->where('user_id', $this->auth_user->id);
        }
        $this->db->where('id <', $last_id);
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get('images');
        return $query->result();
    }

    //get audios
    public function get_audios($count)
    {
        if ($this->general_settings->file_manager_show_files != 1) {
            $this->db->where('user_id', $this->auth_user->id);
        }
        $this->db->order_by('audios.id', 'DESC');
        $this->db->limit($count);
        $query = $this->db->get('audios');
        return $query->result();
    }

    //get more audios
    public function get_more_audios($last_id, $limit)
    {
        if ($this->general_settings->file_manager_show_files != 1) {
            $this->db->where('user_id', $this->auth_user->id);
        }
        $this->db->where('id <', $last_id);
        $this->db->order_by('audios.id', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get('audios');
        return $query->result();
    }

    //get videos
    public function get_videos($count)
    {
        if ($this->general_settings->file_manager_show_files != 1) {
            $this->db->where('user_id', $this->auth_user->id);
        }
        $this->db->order_by('videos.id', 'DESC');
        $this->db->limit($count);
        $query = $this->db->get('videos');
        return $query->result();
    }

    //get more videos
    public function get_more_videos($last_id, $limit)
    {
        if ($this->general_settings->file_manager_show_files != 1) {
            $this->db->where('user_id', $this->auth_user->id);
        }
        $this->db->where('id <', $last_id);
        $this->db->order_by('videos.id', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get('videos');
        return $query->result();
    }

    //delete image
    public function delete_image($id)
    {
        $image = $this->get_image($id);

        if (!empty($image)) {

            //delete image from server
            delete_file_from_server($image->image_big);
            delete_file_from_server($image->image_default);
            delete_file_from_server($image->image_slider);
            delete_file_from_server($image->image_mid);
            delete_file_from_server($image->image_small);

            $this->db->where('id', $id);
            $this->db->delete('images');
        }
    }

    //delete audio
    public function delete_audio($id)
    {
        $audio = $this->get_audio($id);

        if (!empty($audio)) {
            //delete from folder
            delete_file_from_server($audio->audio_path);

            $this->db->where('id', $id);
            $this->db->delete('audios');
        }
    }

    //delete video
    public function delete_video($id)
    {
        $video = $this->get_video($id);

        if (!empty($video)) {
            //delete from folder
            delete_file_from_server($video->video_path);

            $this->db->where('id', $id);
            $this->db->delete('videos');
        }
    }

    //get video thumbnail
    public function get_video_thumbnail($url)
    {
        $this->load->library('video_url_parser');

        $service = $this->video_url_parser->identify_service($url);

        $img_thumbnail = "";

        if ($service == 'youtube') {

            $img_thumbnail = "https://img.youtube.com/vi/" . $this->video_url_parser->get_url_id($url) . "/maxresdefault.jpg";

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $img_thumbnail,
                CURLOPT_HEADER => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_NOBODY => true));

            $header = explode("\n", curl_exec($curl));
            curl_close($curl);

            if (strpos($header[0], '200') === false) {
                $img_thumbnail = "https://img.youtube.com/vi/" . $this->video_url_parser->get_url_id($url) . "/0.jpg";
            }


        }

        if ($service == 'vimeo') {
            $vimeo = unserialize(file_get_contents("http://vimeo.com/api/v2/video/" . $this->video_url_parser->get_url_id($url) . ".php"));
            $img_thumbnail = $vimeo[0]['thumbnail_large'];
        }

        return $img_thumbnail;
    }

}
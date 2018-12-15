<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class File_controller extends Admin_Core_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->file_count = 48;
        $this->file_per_page = 12;
        if (!check_user_permission('add_post')) {
            exit();
        }
    }

    /**
     * Get Images
     */
    public function get_images()
    {
        $images = $this->file_model->get_images($this->file_count);
        foreach ($images as $image):
            echo '<div class="col-sm-2 col-file-manager" id="img_col_id_' . $image->id . '">';
            echo '<div class="file-box" data-file-id="' . $image->id . '" data-file-path="' . $image->image_default . '">';
            echo '<img src="' . base_url() . $image->image_mid . '" alt="" class="img-responsive">';
            echo '</div> </div>';
            $_SESSION["fm_last_img_id"] = $image->id;
        endforeach;
    }

    /**
     * Select Image File
     */
    public function select_image_file()
    {
        $file_id = $this->input->post('file_id', true);

        $file = $this->file_model->get_image($file_id);
        if (!empty($file)) {
            echo base_url() . $file->image_mid;
        }
    }


    /**
     * Select Audio File
     */
    public function select_audio_file()
    {
        $file_id = $this->input->post('file_id', true);

        $audio = $this->file_model->get_audio($file_id);
        if (!empty($audio)) {
            echo '<p class="play-list-item play-list-item-' . $audio->id . '"><i class="fa fa-music"></i>&nbsp;';
            echo $audio->audio_name;
            echo '<a href="javascript:void(0)" class="btn btn-xs btn-danger pull-right btn-delete-audio" data-value="' . $audio->id . '">';
            echo trans("delete");
            echo '</a><input type="hidden" name="post_audio_id[]" value="' . $audio->id . '"></p>';
        }
    }


    /**
     * Select Video File
     */
    public function select_video_file()
    {
        $file_id = $this->input->post('file_id', true);

        $video = $this->file_model->get_video($file_id);
        if (!empty($video)) {
            echo ' <video controls class="video-preview">';
            echo '<source src="' . base_url() . $video->video_path . '" type="video/mp4">';
            echo '<source src="' . base_url() . $video->video_path . '" type="video/ogg">';
            echo '</video>';
            echo '<input type="hidden" name="video_path" value="' . $video->video_path . '">';
        }
    }


    /**
     * Upload Image File
     */
    public function upload_image_file()
    {
        $this->file_model->upload_image();

        $images = $this->file_model->get_images($this->file_count);

        foreach ($images as $image):
            echo '<div class="col-sm-2 col-file-manager" id="img_col_id_' . $image->id . '">';
            echo '<div class="file-box" data-file-id="' . $image->id . '">';
            echo '<img src="' . base_url() . $image->image_mid . '" alt="" class="img-responsive">';
            echo '</div> </div>';
            $_SESSION["fm_last_img_id"] = $image->id;
        endforeach;
    }

    /**
     * Upload CKImage File
     */
    public function upload_ckimage_file()
    {
        $this->file_model->upload_image();

        $images = $this->file_model->get_images($this->file_count);

        foreach ($images as $image):
            echo '<div class="col-sm-2 col-file-manager" id="ckimg_col_id_' . $image->id . '">';
            echo '<div class="file-box" data-file-id="' . $image->id . '" data-file-path="' . $image->image_default . '">';
            echo '<img src="' . base_url() . $image->image_mid . '" alt="" class="img-responsive">';
            echo '</div> </div>';
            $_SESSION["fm_last_ckimg_id"] = $image->id;
        endforeach;
    }

    /**
     * Upload Audio File
     */
    public function upload_audio_file()
    {
        $this->file_model->upload_audio();
        $audios = $this->file_model->get_audios($this->file_count);
        foreach ($audios as $audio):
            echo '<div class="col-sm-2 col-file-manager" id="audio_col_id_' . $audio->id . '">';
            echo '<div class="file-box" data-file-id="' . $audio->id . '">';
            echo '<img src="' . base_url() . 'assets/admin/img/music-file.png" alt="" class="img-responsive file-icon">';
            echo '<p class="file-manager-list-item-name">' . $audio->audio_name . '</p>';
            echo '</div> </div>';
            $_SESSION["fm_last_audio_id"] = $audio->id;
        endforeach;
    }


    /**
     * Upload Video File
     */
    public function upload_video_file()
    {
        $this->file_model->upload_video();

        $videos = $this->file_model->get_videos($this->file_count);

        foreach ($videos as $video):
            echo '<div class="col-sm-2 col-file-manager" id="video_col_id_' . $video->id . '">';
            echo '<div class="file-box" data-file-id="' . $video->id . '">';
            echo '<img src="' . base_url() . 'assets/admin/img/video-file.png" alt="" class="img-responsive file-icon">';
            echo '<p class="file-manager-list-item-name">' . $video->video_name . '</p>';
            echo '</div> </div>';
            $_SESSION["fm_last_video_id"] = $video->id;
        endforeach;
    }


    /**
     * Laod More Images
     */
    public function load_more_images()
    {
        $images = $this->file_model->get_more_images($_SESSION["fm_last_img_id"], $this->file_per_page);
        foreach ($images as $image):
            echo '<div class="col-sm-2 col-file-manager" id="img_col_id_' . $image->id . '">';
            echo '<div class="file-box" data-file-id="' . $image->id . '" data-file-path="' . $image->image_default . '">';
            echo '<img src="' . base_url() . $image->image_mid . '" alt="" class="img-responsive">';
            echo '</div> </div>';
            $_SESSION["fm_last_img_id"] = $image->id;
        endforeach;
    }


    /**
     * Laod More CKImages
     */
    public function load_more_ckimages()
    {
        $images = $this->file_model->get_more_images($_SESSION["fm_last_ckimg_id"], $this->file_per_page);

        foreach ($images as $image):
            echo '<div class="col-sm-2 col-file-manager" id="ckimg_col_id_' . $image->id . '">';
            echo '<div class="file-box" data-file-id="' . $image->id . '" data-file-path="' . $image->image_default . '">';
            echo '<img src="' . base_url() . $image->image_mid . '" alt="" class="img-responsive">';
            echo '</div> </div>';
            $_SESSION["fm_last_ckimg_id"] = $image->id;
        endforeach;
    }


    /**
     * Laod More Audios
     */
    public function load_more_audios()
    {
        $audios = $this->file_model->get_more_audios($_SESSION["fm_last_audio_id"], $this->file_per_page);

        foreach ($audios as $audio):
            echo '<div class="col-sm-2 col-file-manager" id="audio_col_id_' . $audio->id . '">';
            echo '<div class="file-box" data-file-id="' . $audio->id . '">';
            echo '<img src="' . base_url() . 'assets/admin/img/music-file.png" alt="" class="img-responsive file-icon">';
            echo '<p class="file-manager-list-item-name">' . $audio->audio_name . '</p>';
            echo '</div> </div>';
            $_SESSION["fm_last_audio_id"] = $audio->id;
        endforeach;
    }


    /**
     * Laod More Videos
     */
    public function load_more_videos()
    {
        $videos = $this->file_model->get_more_videos($_SESSION["fm_last_video_id"], $this->file_per_page);

        foreach ($videos as $video):
            echo '<div class="col-sm-2 col-file-manager" id="video_col_id_' . $video->id . '">';
            echo '<div class="file-box" data-file-id="' . $video->id . '">';
            echo '<img src="' . base_url() . 'assets/admin/img/video-file.png" alt="" class="img-responsive file-icon">';
            echo '<p class="file-manager-list-item-name">' . $video->video_name . '</p>';
            echo '</div> </div>';
            $_SESSION["fm_last_video_id"] = $video->id;
        endforeach;
    }


    /**
     * Delete File
     */
    public function delete_image_file()
    {
        $file_id = $this->input->post('file_id', true);
        $this->file_model->delete_image($file_id);
    }


    /**
     * Delete CK File
     */
    public function delete_ckimage_file()
    {
        $file_id = $this->input->post('file_id', true);
        $this->file_model->delete_image($file_id);
    }


    /**
     * Delete Audio File
     */
    public function delete_audio_file()
    {
        $file_id = $this->input->post('file_id', true);
        $this->file_model->delete_audio($file_id);
    }


    /**
     * Delete Video File
     */
    public function delete_video_file()
    {
        $file_id = $this->input->post('file_id', true);
        $this->file_model->delete_video($file_id);
    }


}

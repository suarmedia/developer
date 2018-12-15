<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_model extends CI_Model
{
    //post big image upload
    public function post_big_image_upload($file)
    {
        $this->my_upload->upload($file);
        if ($this->my_upload->uploaded == true) {
            $this->my_upload->file_new_name_body = 'image_750x422_' . uniqid();
            $this->my_upload->image_convert = 'jpg';
            $this->my_upload->jpeg_quality = 85;
            $this->my_upload->image_ratio_crop = true;
            $this->my_upload->image_resize = true;
            $this->my_upload->image_x = 750;
            $this->my_upload->image_y = 422;
            $this->my_upload->process('./uploads/images/');
            $image_path = "uploads/images/" . $this->my_upload->file_dst_name;
            return $image_path;
        } else {
            return null;
        }
    }

    //post default image upload
    public function post_default_image_upload($file)
    {
        $this->my_upload->upload($file);
        if ($this->my_upload->uploaded == true) {
            $this->my_upload->file_new_name_body = 'image_750x_' . uniqid();
            $this->my_upload->image_convert = 'jpg';
            $this->my_upload->jpeg_quality = 85;
            $this->my_upload->image_resize = true;
            $this->my_upload->image_ratio_no_zoom_in = true;
            $this->my_upload->image_x = 750;
            $this->my_upload->image_ratio_y = true;
            $this->my_upload->process('./uploads/images/');
            $image_path = "uploads/images/" . $this->my_upload->file_dst_name;
            return $image_path;
        } else {
            return null;
        }
    }

    //post slider image upload
    public function post_slider_image_upload($file)
    {
        $this->my_upload->upload($file);
        if ($this->my_upload->uploaded == true) {
            $this->my_upload->file_new_name_body = 'image_600x460_' . uniqid();
            $this->my_upload->image_convert = 'jpg';
            $this->my_upload->jpeg_quality = 85;
            $this->my_upload->image_ratio_crop = true;
            $this->my_upload->image_resize = true;
            $this->my_upload->image_x = 600;
            $this->my_upload->image_y = 460;
            $this->my_upload->process('./uploads/images/');
            $image_path = "uploads/images/" . $this->my_upload->file_dst_name;
            return $image_path;
        } else {
            return null;
        }
    }

    //post mid image upload
    public function post_mid_image_upload($file)
    {
        $this->my_upload->upload($file);
        if ($this->my_upload->uploaded == true) {
            $this->my_upload->file_new_name_body = 'image_380x240_' . uniqid();
            $this->my_upload->image_convert = 'jpg';
            $this->my_upload->jpeg_quality = 85;
            $this->my_upload->image_ratio_crop = true;
            $this->my_upload->image_resize = true;
            $this->my_upload->image_x = 380;
            $this->my_upload->image_y = 226;
            $this->my_upload->process('./uploads/images/');
            $image_path = "uploads/images/" . $this->my_upload->file_dst_name;
            return $image_path;
        } else {
            return null;
        }
    }

    //post small image upload
    public function post_small_image_upload($file)
    {
        $this->my_upload->upload($file);
        if ($this->my_upload->uploaded == true) {
            $this->my_upload->file_new_name_body = 'image_140x98_' . uniqid();
            $this->my_upload->image_convert = 'jpg';
            $this->my_upload->jpeg_quality = 85;
            $this->my_upload->image_ratio_crop = true;
            $this->my_upload->image_resize = true;
            $this->my_upload->image_x = 140;
            $this->my_upload->image_y = 98;
            $this->my_upload->process('./uploads/images/');
            $image_path = "uploads/images/" . $this->my_upload->file_dst_name;
            return $image_path;
        } else {
            return null;
        }
    }

    //gallery big image upload
    public function gallery_big_image_upload($file)
    {
        $this->my_upload->upload($file);
        if ($this->my_upload->uploaded == true) {
            $this->my_upload->file_new_name_body = 'image_1920x_' . uniqid();
            $this->my_upload->image_convert = 'jpg';
            $this->my_upload->jpeg_quality = 85;
            $this->my_upload->image_resize = true;
            $this->my_upload->image_ratio_no_zoom_in = true;
            $this->my_upload->image_x = 1920;
            $this->my_upload->image_ratio_y = true;
            $this->my_upload->process('./uploads/gallery/');
            $image_path = "uploads/gallery/" . $this->my_upload->file_dst_name;
            return $image_path;
        } else {
            return null;
        }
    }

    //gallery small image upload
    public function gallery_small_image_upload($file)
    {
        $this->my_upload->upload($file);
        if ($this->my_upload->uploaded == true) {
            $this->my_upload->file_new_name_body = 'image_500x_' . uniqid();
            $this->my_upload->image_convert = 'jpg';
            $this->my_upload->jpeg_quality = 85;
            $this->my_upload->image_resize = true;
            $this->my_upload->image_ratio_no_zoom_in = true;
            $this->my_upload->image_x = 500;
            $this->my_upload->image_ratio_y = true;
            $this->my_upload->process('./uploads/gallery/');
            $image_path = "uploads/gallery/" . $this->my_upload->file_dst_name;
            return $image_path;
        } else {
            return null;
        }
    }


    //avatar image upload
    public function avatar_upload($user_id, $file)
    {
        $this->my_upload->upload($file);
        if ($this->my_upload->uploaded == true) {
            $this->my_upload->file_new_name_body = 'avatar_' . $user_id . '_' . uniqid();
            $this->my_upload->image_convert = 'jpg';
            $this->my_upload->jpeg_quality = 85;
            $this->my_upload->image_ratio_crop = true;
            $this->my_upload->image_resize = true;
            $this->my_upload->image_x = 300;
            $this->my_upload->image_y = 300;
            $this->my_upload->process('./uploads/profile/');
            $image_path = "uploads/profile/" . $this->my_upload->file_dst_name;
            return $image_path;
        } else {
            return null;
        }
    }


    //logo image upload
    public function logo_upload($file)
    {
        $this->my_upload->upload($file);
        if ($this->my_upload->uploaded == true) {
            $this->my_upload->file_new_name_body = 'logo_' . uniqid();
            $this->my_upload->process('./uploads/logo/');
            $image_path = "uploads/logo/" . $this->my_upload->file_dst_name;
            return $image_path;
        } else {
            return null;
        }
    }

    //favicon image upload
    public function favicon_upload($file)
    {
        $this->my_upload->upload($file);
        if ($this->my_upload->uploaded == true) {
            $this->my_upload->file_new_name_body = 'favicon_' . uniqid();
            $this->my_upload->process('./uploads/logo/');
            $image_path = "uploads/logo/" . $this->my_upload->file_dst_name;
            return $image_path;
        } else {
            return null;
        }
    }

    //ad upload
    public function ad_upload($file)
    {
        $this->my_upload->upload($file);
        if ($this->my_upload->uploaded == true) {
            $this->my_upload->file_new_name_body = 'block_' . uniqid();
            $this->my_upload->process('./uploads/blocks/');
            $image_path = "uploads/blocks/" . $this->my_upload->file_dst_name;
            return $image_path;
        } else {
            return null;
        }
    }

    //audio upload
    public function audio_upload($file)
    {
        $this->my_upload->upload($file);
        if ($this->my_upload->uploaded == true) {
            $this->my_upload->file_new_name_body = 'audio_' . uniqid();
            $this->my_upload->process('./uploads/audios/');
            $path = "uploads/audios/" . $this->my_upload->file_dst_name;
            return $path;
        } else {
            return null;
        }
    }

    //video upload
    public function video_upload($file)
    {
        $this->my_upload->upload($file);
        if ($this->my_upload->uploaded == true) {
            $this->my_upload->file_new_name_body = 'video_' . uniqid();
            $this->my_upload->process('./uploads/videos/');
            $path = "uploads/videos/" . $this->my_upload->file_dst_name;
            return $path;
        } else {
            return null;
        }
    }
}
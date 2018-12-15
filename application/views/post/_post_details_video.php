<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
$video_image = base_url() . $post->image_big;
if (!empty($post->image_url)):
    $video_image = $post->image_url;
endif;
?>
<div class="show-on-page-load">

    <?php if (!empty($post->video_path)): ?>
        <div class="video-player">
            <video id="example_video_1" class="video-js vjs-default-skin" controls preload="none" width="750" height="422" poster="<?php echo $video_image; ?>" data-setup="{}">
                <source src="<?php echo base_url() . $post->video_path; ?>" type="video/mp4">
                <source src="<?php echo base_url() . $post->video_path; ?>" type="video/webm">
                <!-- Tracks need an ending tag thanks to IE9 -->
                <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that</p>
            </video>
        </div>
    <?php elseif (!empty($post->video_embed_code)): ?>
        <div class="post-image post-video">
            <iframe width="750" height="422" src="<?php echo $post->video_embed_code; ?>" frameborder="0" allowfullscreen></iframe>
        </div>
    <?php endif; ?>
</div>

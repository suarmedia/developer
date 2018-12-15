<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if ($post->post_type == "video"): ?>
    <img src="<?php echo base_url(); ?>assets/img/icon_play.svg" alt="icon" class="post-icon post-icon-<?php echo $icon_size; ?>"/>
<?php endif; ?>
<?php if ($post->post_type == "audio"): ?>
    <img src="<?php echo base_url(); ?>assets/img/icon_music.svg" alt="icon" class="post-icon post-icon-<?php echo $icon_size; ?>"/>
<?php endif; ?>
<?php
$img_bg = "";
if ($bg_size == "sm"):
    $img_bg = $img_bg_sm;
elseif ($bg_size == "sl"):
    $img_bg = $img_bg_sl;
elseif ($bg_size == "lg"):
    $img_bg = $img_bg_lg;
elseif ($bg_size == "sm_footer"):
    $img_bg = $img_bg_sm_footer;
else:
    $img_bg = $img_bg_mid;
endif;
?>
<?php if (!empty($post->image_url)): ?>
<img src="<?php echo $img_bg; ?>" alt="bg" class="img-responsive img-bg"/>
<div class="img-container">
<img src="<?php echo $img_bg; ?>" data-src="<?php echo get_post_image($post, $image_size); ?>" alt="<?php echo html_escape($post->title); ?>" class="<?php echo $class; ?> img-cover"/>
</div>
<?php else: ?>
<img src="<?php echo $img_bg; ?>" data-src="<?php echo get_post_image($post, $image_size); ?>" alt="<?php echo html_escape($post->title); ?>" class="<?php echo $class; ?> img-responsive img-post" onerror="javascript:this.src='<?php echo $img_bg; ?>'"/>
<?php endif; ?>




<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!--Post item small-->
<div class="post-item-mid">
    <div class="post-item-image">
        <a href="<?php echo post_url($post); ?>">
            <?php $this->load->view("post/_post_image", ["post" => $post, "icon_size" => "md", "bg_size" => "md", "image_size" => "mid", "class" => "lazyload"]); ?>
        </a>
    </div>
    <h3 class="title">
        <a href="<?php echo post_url($post); ?>">
            <?php echo html_escape(character_limiter($post->title, 55, '...')); ?>
        </a>
    </h3>
    <p class="post-meta">
        <?php $this->load->view("post/_post_meta", ["post" => $post]); ?>
    </p>
</div>
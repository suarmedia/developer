<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!--Post item small-->
<div class="post-item-small">
    <div class="left">
        <a href="<?php echo post_url($post); ?>">
            <?php $this->load->view("post/_post_image", ["post" => $post, "icon_size" => "sm", "bg_size" => "sm", "image_size" => "small", "class" => "lazyload"]); ?>
        </a>
    </div>

    <div class="right">
        <h3 class="title">
            <a href="<?php echo post_url($post); ?>">
                <?php echo html_escape(character_limiter($post->title, 55, '...')); ?>
            </a>
        </h3>
        <p class="small-post-meta">
            <?php $this->load->view("post/_post_meta", ["post" => $post]); ?>
        </p>
    </div>
</div>
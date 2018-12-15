<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="post-image">
    <div class="post-image-inner">
        <?php if ($post_image_count > 0) : ?>
            <!-- owl-carousel -->
            <div class="owl-carousel post-detail-slider" id="post-detail-slider">

                <div class="post-detail-slider-item">
                    <img src="<?php echo base_url() . html_escape($post->image_default); ?>" class="img-responsive center-image" alt="<?php echo html_escape($post->title); ?>"/>
                    <figcaption class="img-description"><?php echo html_escape($post->image_description); ?></figcaption>
                </div>
                <!--List  random slider posts-->
                <?php foreach ($post_images as $image): ?>
                    <!-- slider item -->
                    <div class="post-detail-slider-item">
                        <img src="<?php echo base_url() . html_escape($image->image_default); ?>" class="img-responsive center-image" alt="<?php echo html_escape($post->title); ?>"/>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <img src="<?php echo get_post_image($post, "default"); ?>" class="img-responsive center-image" alt="<?php echo html_escape($post->title); ?>"/>
            <figcaption class="img-description"><?php echo html_escape($post->image_description); ?></figcaption>
        <?php endif; ?>
    </div>
</div>
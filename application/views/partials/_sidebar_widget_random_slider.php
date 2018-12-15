<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!--Widget: Random Slider-->
<div class="sidebar-widget">
    <div class="widget-head">
        <h4 class="title"><?php echo html_escape($widget->title); ?></h4>
    </div>
    <div class="widget-body">
        <div class="owl-carousel random-slider" id="random-slider">
            <!--Print Random Posts-->
            <?php $i = 0;
            foreach ($this->random_posts as $post):
                if ($i < 10):?>
                    <!--Post row item-->
                    <div class="post-item">
                        <?php $post_category = get_post_category($post); ?>
                        <?php if (!empty($post_category['id'])): ?>
                            <a href="<?php echo lang_base_url(); ?>category/<?php echo html_escape($post_category['name_slug']); ?>">
                                <span class="category-label" style="background-color: <?php echo html_escape($post_category['color']); ?>"><?php echo html_escape($post_category['name']); ?></span>
                            </a>
                        <?php endif; ?>
                        <div class="post-item-image">
                            <a href="<?php echo post_url($post); ?>">
                                <?php $this->load->view("post/_post_image", ["post" => $post, "icon_size" => "md", "bg_size" => "md", "image_size" => "mid", "class" => "owl-lazy"]); ?>
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
                        <p class="description">
                            <?php echo html_escape(character_limiter($post->summary, 80, '...')); ?>
                        </p>
                    </div>
                <?php endif;
                $i++;
            endforeach; ?>
        </div>
    </div>
</div>
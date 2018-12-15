<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!--Widget: Recommended Posts-->
<div class="sidebar-widget">
    <div class="widget-head">
        <h4 class="title"><?php echo html_escape($widget->title); ?></h4>
    </div>
    <div class="widget-body">
        <ul class="recommended-posts">
            <!--Print Picked Posts-->
            <?php $count = 0;
            if (!empty($this->recommended_posts)):
                foreach ($this->recommended_posts as $post):
                    $post_category = get_post_category($post);
                    if ($count == 0): ?>
                        <li class="recommended-posts-first">
                            <div class="post-item-image">
                                <a href="<?php echo post_url($post); ?>">
                                    <?php $this->load->view("post/_post_image", ["post" => $post, "icon_size" => "md", "bg_size" => "md", "image_size" => "mid", "class" => "lazyload"]); ?>
                                    <div class="overlay"></div>
                                </a>
                            </div>
                            <div class="caption">
                                <a href="<?php echo lang_base_url(); ?>category/<?php echo html_escape($post_category['name_slug']); ?>">
                                <span class="category-label"
                                      style="background-color: <?php echo html_escape($post_category['color']); ?>"><?php echo html_escape($post_category['name']); ?></span>
                                </a>
                                <h3 class="title">
                                    <a href="<?php echo post_url($post); ?>">
                                        <?php echo html_escape(character_limiter($post->title, 55, '...')); ?>
                                    </a>
                                </h3>
                                <p class="small-post-meta">
                                    <?php $this->load->view("post/_post_meta", ["post" => $post]); ?>
                                </p>
                            </div>
                        </li>
                    <?php else: ?>
                        <li>
                            <?php $this->load->view("post/_post_item_small", ["post" => $post]); ?>
                        </li>
                    <?php endif;
                    $count++;
                endforeach;
            endif; ?>

        </ul>
    </div>
</div>
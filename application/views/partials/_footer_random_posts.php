<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!--Partial: Footer Random Posts-->
<div class="footer-widget f-widget-random">
    <div class="col-sm-12">
        <div class="row">
            <h4 class="title"><?php echo html_escape(trans("footer_random_posts")); ?></h4>
            <div class="title-line"></div>
            <ul class="f-random-list">
                <!--List random posts-->
                <?php
                $i = 0;
                if (!empty($this->random_posts)):
                    foreach (array_reverse($this->random_posts) as $item):
                        if ($i < 3):?>
                            <li>
                                <div class="list-left">
                                    <a href="<?php echo post_url($item); ?>">
                                        <?php $this->load->view("post/_post_image", ["post" => $item, "icon_size" => "sm", "bg_size" => "sm_footer", "image_size" => "small", "class" => "lazyload"]); ?>
                                    </a>
                                </div>
                                <div class="list-right">
                                    <h5 class="title">
                                        <a href="<?php echo post_url($item); ?>">
                                            <?php echo html_escape(character_limiter($item->title, 55, '...')); ?>
                                        </a>
                                    </h5>
                                </div>
                            </li>
                        <?php endif;
                        $i++;
                    endforeach;
                endif; ?>
            </ul>
        </div>
    </div>
</div>

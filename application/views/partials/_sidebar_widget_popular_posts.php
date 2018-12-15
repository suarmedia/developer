<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!--Widget: Popular Posts-->
<div class="sidebar-widget widget-popular-posts">
    <div class="widget-head">
        <h4 class="title"><?php echo html_escape($widget->title); ?></h4>
    </div>
    <div class="widget-body">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#popular1"><?php echo trans("this_week"); ?></a></li>
            <li><a data-toggle="tab" href="#popular2"><?php echo trans("this_month"); ?></a></li>
            <li><a data-toggle="tab" href="#popular3"><?php echo trans("this_year"); ?></a></li>
        </ul>
        <div class="tab-content">
            <div id="popular1" class="tab-pane fade in active">
                <ul class="popular-posts">
                    <?php if (!empty($this->popular_posts_week)):
                        foreach ($this->popular_posts_week as $post): ?>
                            <li>
                                <?php $this->load->view("post/_post_item_small", ["post" => $post]); ?>
                            </li>
                        <?php endforeach;
                    endif; ?>
                </ul>
            </div>
            <div id="popular2" class="tab-pane fade">
                <ul class="popular-posts">
                    <?php if (!empty($this->popular_posts_month)):
                        foreach ($this->popular_posts_month as $post): ?>
                            <li>
                                <?php $this->load->view("post/_post_item_small", ["post" => $post]); ?>
                            </li>
                        <?php endforeach;
                    endif; ?>
                </ul>
            </div>
            <div id="popular3" class="tab-pane fade">
                <ul class="popular-posts">
                    <?php if (!empty($this->popular_posts_year)):
                        foreach ($this->popular_posts_year as $post): ?>
                            <li>
                                <?php $this->load->view("post/_post_item_small", ["post" => $post]); ?>
                            </li>
                        <?php endforeach;
                    endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
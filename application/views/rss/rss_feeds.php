<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Section: wrapper -->
<div id="wrapper">
    <div class="container">
        <div class="row">

            <!--Check breadcrumb active-->
            <?php if ($page->breadcrumb_active == 1): ?>
                <div class="col-sm-12 page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo lang_base_url(); ?>"><?php echo trans("breadcrumb_home"); ?></a>
                        </li>

                        <li class="breadcrumb-item active"><?php echo html_escape($page->title); ?></li>
                    </ol>
                </div>
            <?php else: ?>
                <div class="col-sm-12 page-breadcrumb"></div>
            <?php endif; ?>

            <div id="content" class="col-sm-12">
                <div class="row">
                    <!--Check page title active-->
                    <?php if ($page->title_active == 1): ?>
                        <div class="col-sm-12">
                            <h1 class="page-title"><?php echo html_escape($page->title); ?></h1>
                        </div>
                    <?php endif; ?>
                    <div class="col-sm-12">
                        <div class="page-content font-text">

                            <div class="rss-item">
                                <div class="left">
                                    <a href="<?php echo lang_base_url(); ?>rss/latest-posts" target="_blank"><i class="icon-rss"></i>&nbsp;&nbsp;<?php echo trans("latest_posts"); ?></a>
                                </div>
                                <div class="right">
                                    <p><?php echo lang_base_url() . "rss/latest-posts"; ?></p>
                                </div>
                            </div>

                            <?php foreach ($this->categories as $category):
                                if ($category->lang_id == $this->language_id):?>
                                    <div class="rss-item">
                                        <div class="left">
                                            <a href="<?php echo lang_base_url(); ?>rss/category/<?php echo html_escape($category->name_slug); ?>" target="_blank"><i class="icon-rss"></i>&nbsp;&nbsp;<?php echo html_escape($category->name); ?></a>
                                        </div>
                                        <div class="right">
                                            <p><?php echo lang_base_url(); ?>rss/category/<?php echo html_escape($category->name_slug); ?></p>
                                        </div>
                                    </div>
                                <?php endif; endforeach; ?>

                            <div class="rss-content">
                                <?php echo $page->page_content; ?>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


</div>
<!-- /.Section: wrapper -->
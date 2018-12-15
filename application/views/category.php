<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Section: wrapper -->
<div id="wrapper">
    <div class="container">
        <div class="row">
            <!-- breadcrumb -->
            <div class="col-sm-12 page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?php echo lang_base_url(); ?>"><?php echo trans("breadcrumb_home"); ?></a>
                    </li>
                    <?php if ($category_type == "sub"): ?>
                        <!-- get parent category -->
                        <?php $parent_category = helper_get_category($category->parent_id); ?>
                        <?php if (!empty($parent_category)): ?>
                            <li class="breadcrumb-item">
                                <a href="<?php echo lang_base_url(); ?>category/<?php echo html_escape($parent_category->name_slug); ?>"><?php echo html_escape($parent_category->name); ?></a>
                            </li>
                        <?php endif; ?>

                        <li class="breadcrumb-item active"><?php echo html_escape($category->name); ?></li>

                    <?php else: ?>
                        <li class="breadcrumb-item active"><?php echo html_escape($category->name); ?></li>
                    <?php endif; ?>

                </ol>
            </div>

            <div id="content" class="col-sm-8">
                <div class="row">
                    <div class="col-sm-12">
                        <h1 class="page-title"><?php echo html_escape($category->name); ?></h1>
                    </div>

                    <?php  get_posts_latest(); $count = 0; ?>
                    <?php foreach ($posts as $post): ?>

                        <?php if ($count != 0 && $count % 2 == 0): ?>
                            <div class="col-sm-12"></div>
                        <?php endif; ?>

                        <!--include post item-->
                        <?php $this->load->view("post/_post_item_list", ["post" => $post]); ?>


                        <?php if ($count == 1): ?>
                            <!--Include banner-->
                            <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "category_top", "class" => "p-b-30"]); ?>
                        <?php endif; ?>


                        <?php $count++; ?>
                    <?php endforeach; ?>

                    <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "category_bottom", "class" => ""]); ?>

                    <!-- Pagination -->
                    <div class="col-sm-12 col-xs-12">
                        <?php echo $this->pagination->create_links(); ?>
                    </div>
                </div>
            </div>


            <div id="sidebar" class="col-sm-4">
                <!--include sidebar -->
                <?php $this->load->view('partials/_sidebar'); ?>

            </div>
        </div>
    </div>


</div>
<!-- /.Section: wrapper -->
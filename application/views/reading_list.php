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

                        <li class="breadcrumb-item active"><?php echo trans("reading_list"); ?></li>
                    </ol>
                </div>
            <?php else: ?>
                <div class="col-sm-12 page-breadcrumb"></div>
            <?php endif; ?>

            <div id="content" class="col-sm-8">

                <div class="row">
                    <!--Check page title active-->
                    <?php if ($page->title_active == 1): ?>
                        <div class="col-sm-12">
                            <h1 class="page-title"><?php echo trans("reading_list"); ?></h1>
                        </div>
                    <?php endif; ?>


                    <?php $count = 0; ?>
                    <?php foreach ($posts as $post): ?>

                        <?php if ($count != 0 && $count % 2 == 0): ?>
                            <div class="col-sm-12"></div>
                        <?php endif; ?>

                        <!--include post item-->
                        <?php $this->load->view("post/_post_item_list", ["post" => $post, "show_label" => true]); ?>

                        <?php if ($count == 1): ?>
                            <!--Include banner-->
                            <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "reading_list_top", "class" => "p-b-30"]); ?>
                        <?php endif; ?>

                        <?php $count++; ?>
                    <?php endforeach; ?>


                    <?php if ($count == 0): ?>
                        <p class="text-center">
                            <?php echo trans("text_list_empty"); ?>
                        </p>
                    <?php endif; ?>

                    <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "reading_list_bottom", "class" => ""]); ?>

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
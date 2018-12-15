<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<h1 class="title-index"><?php echo html_escape($home_title); ?></h1>
<!--Include featured section-->
<?php if ($general_settings->show_featured_section == 1): ?>
    <?php $this->load->view('post/_featured_posts', $featured_posts); ?>
<?php endif; ?>

<div id="wrapper" class="index-wrapper m-t-0">
    <div class="container">
        <div class="row">
            <!--Include news ticker-->
            <?php $this->load->view('post/_news_ticker', $breaking_news); ?>

            <div class="col-sm-12 col-xs-12 bn-header-mobile">
                <div class="row">
                    <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "header", "class" => ""]); ?>
                </div>
            </div>
            <div id="content" class="col-sm-8 col-xs-12">
                <!--Index Latest Posts-->
                <?php if ($general_settings->show_latest_posts == 1): ?>
                    <?php if (count($latest_posts) > 0): ?>
                        <div class="col-sm-12 col-xs-12">
                            <div class="row">
                                <section class="section">
                                    <div class="section-head">
                                        <h4 class="title">
                                            <a href="<?php echo lang_base_url(); ?>posts">
                                                <?php echo trans("latest_posts"); ?>
                                            </a>
                                        </h4>

                                        <a href="<?php echo lang_base_url(); ?>posts" class="a-view-all">
                                            <?php echo trans("view_all_posts"); ?>&nbsp;&nbsp;&nbsp;<i class="icon-arrow-right" aria-hidden="true"></i>
                                        </a>
                                    </div><!--End section head-->

                                    <div class="section-content">
                                        <div class="row latest-articles">
                                            <?php $_SESSION["vr_last_posts_lang_id"] = $selected_lang->id; ?>
                                            <input type="hidden" id="index_visible_posts_count" value="<?php echo $visible_posts_count; ?>">
                                            <div id="last_posts_content">
                                                <?php $this->load->view('post/_index_latest_posts', ["latest_posts" => $latest_posts, "total_posts_count" => $total_posts_count]); ?>
                                            </div>
                                        </div>
                                    </div><!--End section content-->

                                    <div id="load_posts_spinner" class="col-sm-12 col-xs-12 load-more-spinner">
                                        <div class="row">
                                            <div class="spinner">
                                                <div class="bounce1"></div>
                                                <div class="bounce2"></div>
                                                <div class="bounce3"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php if ($total_posts_count > $visible_posts_count): ?>
                                        <div class="col-sm-12 col-xs-12">
                                            <div class="row">
                                                <button class="btn-load-more" onclick="load_more_posts();">
                                                    <?php echo trans("load_more"); ?>
                                                </button>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                </section><!--End section-->
                            </div>
                        </div>
                    <?php endif; ?>


                <?php endif; ?>
                <!--End Index Latest Posts-->
                
                <!--Include banner-->
                <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "index_bottom", "class" => "bn-p-b"]); ?>
                
                <!-- category post -->
                <?php $x = 0;
                foreach ($this->categories as $category):
                    if ($category->show_at_homepage == 1 && $category->lang_id == $this->language_id):
                        if ($category->block_type == "block-1") {
                            $this->load->view('partials/_category_block_type_1', ['category' => $category]);
                        }
                        if ($category->block_type == "block-2") {
                            $this->load->view('partials/_category_block_type_2', ['category' => $category]);
                        }
                        if ($category->block_type == "block-3") {
                            $this->load->view('partials/_category_block_type_3', ['category' => $category]);
                        }
                        if ($category->block_type == "block-4") {
                            $this->load->view('partials/_category_block_type_4', ['category' => $category]);
                        }
                        if ($category->block_type == "block-5") {
                            $this->load->view('partials/_category_block_type_5', ['category' => $category]);
                        }
                        if ($x == 0) {
                            $this->load->view("partials/_ad_spaces", ["ad_space" => "index_top", "class" => "bn-p-b"]);
                        }
                        $x++;
                    endif;
                endforeach; ?>
                <!-- end category post -->
            </div>

            <div id="sidebar" class="col-sm-4 col-xs-12">
                <!--include sidebar -->
                <?php $this->load->view('partials/_sidebar'); ?>

            </div>
        </div>
    </div>
</div>
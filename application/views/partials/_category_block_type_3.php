<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!--Category Block Type 3-->
<div class="col-sm-12 col-xs-12">
    <div class="row">
        <section class="section section-block-3">
            <div class="section-head" style="border-bottom: 2px solid <?php echo html_escape($category->color); ?>;">
                <h4 class="title" style="background-color: <?php echo html_escape($category->color); ?>">
                    <a href="<?php echo lang_base_url(); ?>category/<?php echo html_escape($category->name_slug) ?>" style="color: <?php echo html_escape($category->color); ?>">
                        <?php echo html_escape($category->name); ?>
                    </a>
                </h4>
                <!--Include subcategories-->
                <?php $this->load->view('partials/_block_subcategories', ['category' => $category]); ?>
            </div><!--End section-head-->
            <div class="section-content">
                <div class="tab-content pull-left">
                    <div role="tabpanel" class="tab-pane fade in active" id="all-<?php echo html_escape($category->id); ?>">
                        <div class="row">
                            <?php if (isset($this->category_posts['category_' . $category->id])):
                                $count = 0;
                                $category_posts = $this->category_posts['category_' . $category->id];
                                foreach ($category_posts as $post): ?>
                                    <!--include post item-->
                                    <div class="col-sm-6 col-xs-12">
                                        <?php $this->load->view("post/_post_item", ["post" => $post]); ?>
                                    </div>
                                    <?php
                                    break;
                                endforeach;
                            endif; ?>
                            <div class="col-sm-6">
                                <!--Print latest posts by category-->
                                <?php if (!empty($category_posts)):
                                    $count = 0;
                                    foreach ($category_posts as $post): ?>
                                        <?php if ($count > 0 && $count < 5): ?>
                                            <?php $this->load->view("post/_post_item_small", ["post" => $post]); ?>
                                        <?php endif;
                                        $count++;
                                    endforeach;
                                endif; ?>
                            </div>
                        </div>
                    </div>

                    <?php if (!empty($this->categories)):
                        foreach ($this->categories as $subcategory):
                            if ($subcategory->parent_id == $category->id):?>
                                <div role="tabpanel" class="tab-pane fade in " id="<?php echo html_escape($subcategory->name_slug); ?>-<?php echo html_escape($subcategory->id); ?>">
                                    <div class="row">
                                        <?php if (isset($this->category_posts['category_' . $subcategory->id])):
                                            $count = 0;
                                            $subcategory_posts = $this->category_posts['category_' . $subcategory->id];
                                            foreach ($subcategory_posts as $post):?>
                                                <div class="col-sm-6 col-xs-12">
                                                    <?php $this->load->view("post/_post_item", ["post" => $post]); ?>
                                                </div>
                                                <?php break;
                                            endforeach;
                                        endif; ?>
                                        <div class="col-sm-6">
                                            <!--Print latest posts by category-->
                                            <?php if (!empty($subcategory_posts)):
                                                $count = 0;
                                                foreach ($subcategory_posts as $post):
                                                    if ($count > 0 && $count < 5): ?>
                                                        <?php $this->load->view("post/_post_item_small", ["post" => $post]);
                                                    endif;
                                                    $count++;
                                                endforeach;
                                            endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            endif;
                        endforeach;
                    endif; ?>
                </div>
            </div><!--End section-content-->
        </section><!--End section block 1-->
    </div>
</div>
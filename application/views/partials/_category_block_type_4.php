<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!--Category Block Type 4-->
<div class="col-sm-12 col-xs-12">
    <div class="row">
        <section class="section section-block-4">
            <div class="section-head" style="border-bottom: 2px solid <?php echo html_escape($category->color); ?>;">
                <h4 class="title" style="background-color: <?php echo html_escape($category->color); ?>">
                    <a href="<?php echo lang_base_url(); ?>category/<?php echo html_escape($category->name_slug) ?>" style="color: <?php echo html_escape($category->color); ?>">
                        <?php echo html_escape($category->name); ?>
                    </a>
                </h4>
                <!--Include subcategories-->
                <?php $this->load->view('partials/_block_subcategories', ['category' => $category]); ?>
            </div>
            <div class="section-content">
                <div class="tab-content pull-left">
                    <div role="tabpanel" class="tab-pane fade in active" id="all-<?php echo html_escape($category->id); ?>">
                        <div class="row">
                            <?php if (isset($this->category_posts['category_' . $category->id])):
                                $count = 0;
                                $category_posts = $this->category_posts['category_' . $category->id];
                                foreach ($category_posts as $post):
                                    if ($count < 3):?>
                                        <div class="col-sm-4">
                                            <?php $this->load->view("post/_post_item_mid", ["post" => $post]); ?>
                                        </div>
                                    <?php endif;
                                    $count++;
                                endforeach;
                            endif; ?>
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
                                            foreach ($subcategory_posts as $post):
                                                if ($count < 3):?>
                                                    <div class="col-sm-4">
                                                        <?php $this->load->view("post/_post_item_mid", ["post" => $post]); ?>
                                                    </div>
                                                <?php endif;
                                                $count++;
                                            endforeach;
                                        endif; ?>
                                    </div>
                                </div>
                            <?php endif;
                        endforeach;
                    endif; ?>
                </div>
            </div>
        </section>
    </div>
</div>
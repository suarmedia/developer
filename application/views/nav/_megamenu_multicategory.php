<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
$item = helper_get_category($item_id);
if (isset($this->category_posts['category_' . $item->id])) {
    $category_posts = $this->category_posts['category_' . $item->id];
}
?>
<li class="dropdown megamenu-fw mega-li-<?php echo $item->id; ?> <?php echo (uri_string() == 'category/' . html_escape($item->name_slug)) ? 'active' : ''; ?>">
    <a href="<?php echo lang_base_url(); ?>category/<?php echo html_escape($item->name_slug) ?>" class="dropdown-toggle disabled" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo html_escape($item->name); ?> <span class="caret"></span></a>
    <!--Check if has posts-->
    <?php if (count($category_posts) > 0): ?>
        <ul class="dropdown-menu megamenu-content dropdown-top" role="menu" aria-expanded="true" data-mega-ul="<?php echo $item->id; ?>">
            <li>
                <div class="sub-menu-left">
                    <ul class="nav-sub-categories">
                        <li data-category-filter="all" class="li-sub-category active">
                            <a href="<?php echo lang_base_url(); ?>category/<?php echo html_escape($item->name_slug) ?>">
                                <?php echo trans("all"); ?>
                            </a>
                        </li>
                        <!--Subcategories-->
                        <?php if (!empty($this->categories)):
                            foreach ($this->categories as $subcategory):
                                if ($subcategory->parent_id == $item->id):?>
                                    <li data-category-filter="<?php echo html_escape($subcategory->name_slug); ?>-<?php echo html_escape($subcategory->id); ?>" class="li-sub-category">
                                        <a href="<?php echo lang_base_url(); ?>category/<?php echo html_escape($subcategory->name_slug) ?>">
                                            <?php echo html_escape($subcategory->name); ?>
                                        </a>
                                    </li>
                                <?php endif;
                            endforeach;
                        endif; ?>
                    </ul>
                </div>
                <div class="sub-menu-right">
                    <div class="sub-menu-inner filter-all active">
                        <div class="row row-menu-right">
                            <!--Posts-->
                            <?php $count = 0;
                            if (!empty($category_posts)):
                                foreach ($category_posts as $post):
                                    if ($count < 4): ?>
                                        <div class="col-sm-3 menu-post-item">
                                            <div class="post-item-image">
                                                <a href="<?php echo post_url($post); ?>">
                                                    <?php $this->load->view("post/_post_image", ["post" => $post, "icon_size" => "menu", "bg_size" => "md", "image_size" => "mid", "class" => "lazyload"]); ?>
                                                </a>
                                            </div>
                                            <h3 class="title">
                                                <a href="<?php echo post_url($post); ?>"><?php echo html_escape(character_limiter($post->title, 45, '...')); ?></a>
                                            </h3>
                                            <p class="post-meta">
                                                <?php $this->load->view("post/_post_meta", ["post" => $post]); ?>
                                            </p>
                                        </div>
                                    <?php
                                    endif;
                                    $count++;
                                endforeach;
                            endif; ?>
                        </div>
                    </div>
                    <?php if (!empty($this->categories)):
                        foreach ($this->categories as $subcategory):
                            if ($subcategory->parent_id == $item->id):?>
                                <div class="sub-menu-inner filter-<?php echo html_escape($subcategory->name_slug); ?>-<?php echo html_escape($subcategory->id); ?>">
                                    <div class="row row-menu-right">
                                        <?php if (isset($this->category_posts['category_' . $subcategory->id])):
                                            $count = 0;
                                            $subcategory_posts = $this->category_posts['category_' . $subcategory->id];
                                            foreach ($subcategory_posts as $post): ?>
                                                <?php if ($count < 4): ?>
                                                    <div class="col-sm-3 menu-post-item">
                                                        <div class="post-item-image post-item-image-mn">
                                                            <a href="<?php echo post_url($post); ?>">
                                                                <?php $this->load->view("post/_post_image", ["post" => $post, "icon_size" => "menu", "bg_size" => "md", "image_size" => "mid", "class" => "lazyload"]); ?>
                                                            </a>
                                                        </div>
                                                        <h3 class="title">
                                                            <a href="<?php echo post_url($post); ?>"><?php echo html_escape(character_limiter($post->title, 45, '...')); ?></a>
                                                        </h3>
                                                        <p class="post-meta">
                                                            <?php $this->load->view("post/_post_meta", ["post" => $post]); ?>
                                                        </p>
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
            </li>
        </ul>
    <?php endif; ?>
</li>
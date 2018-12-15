<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
$item = helper_get_category($item_id);
if (isset($this->category_posts['category_' . $item->id])) {
    $category_posts = $this->category_posts['category_' . $item->id];
}
?>
<li class="dropdown megamenu-fw mega-li-<?php echo $item->id; ?> <?php echo (uri_string() == 'category/' . html_escape($item->name_slug)) ? 'active' : ''; ?>">
    <a href="<?php echo lang_base_url(); ?>category/<?php echo html_escape($item->name_slug) ?>" class="dropdown-toggle disabled"
       data-toggle="dropdown" role="button" aria-expanded="false"><?php echo html_escape($item->name); ?>
        <span class="caret"></span>
    </a>
    <!--Check if has posts-->
    <?php if (!empty($category_posts)): ?>
        <ul class="dropdown-menu megamenu-content dropdown-top" role="menu" data-mega-ul="<?php echo $item->id; ?>">
            <li>
                <div class="col-sm-12">
                    <div class="row">
                        <div class="sub-menu-right single-sub-menu">
                            <div class="row row-menu-right">
                                <?php $count = 0;
                                foreach ($category_posts as $post):
                                    if ($count < 5):?>
                                        <div class="col-sm-3 menu-post-item">
                                            <div class="post-item-image">
                                                <a href="<?php echo post_url($post); ?>">
                                                    <?php $this->load->view("post/_post_image", ["post" => $post, "icon_size" => "menu", "bg_size" => "md", "image_size" => "mid", "class" => "lazyload"]); ?>
                                                </a>
                                            </div>
                                            <h3 class="title">
                                                <a href="<?php echo post_url($post); ?>">
                                                    <?php echo html_escape(character_limiter($post->title, 45, '...')); ?>
                                                </a>
                                            </h3>
                                            <p class="post-meta">
                                                <?php $this->load->view("post/_post_meta", ["post" => $post]); ?>
                                            </p>
                                        </div>
                                    <?php endif;
                                    $count++;
                                endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    <?php endif; ?>
</li>



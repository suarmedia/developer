<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php foreach ($latest_posts as $post): ?>
    <?php $this->load->view("post/_post_item_horizontal", ["post" => $post, "show_label" => true]); ?>
<?php endforeach; ?>

<?php if (isset($vr_visible_posts_count) && $vr_visible_posts_count >= $total_posts_count):?>
    <style>
        .btn-load-more {
            display: none;
        }
    </style>
<?php endif; ?>


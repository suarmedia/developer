<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if ($general_settings->show_post_author == 1): ?>
    <a href="<?php echo lang_base_url(); ?>profile/<?php echo html_escape($post->user_slug); ?>"><?php echo html_escape($post->username); ?></a>
<?php endif; ?>
<?php if ($general_settings->show_post_date == 1): ?>
    <span><?php echo helper_date_format($post->created_at); ?></span>
<?php endif; ?>
<?php if ($general_settings->comment_system == 1): ?>
    <span><i class="icon-comment"></i><?php echo get_post_comment_count($post->id); ?></span>
<?php endif; ?>
<?php if ($general_settings->show_hits): ?>
    <span class="m-r-0"><i class="icon-eye"></i><?php echo $post->hit; ?></span>
<?php endif; ?>
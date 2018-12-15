<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-sm-12">
        <!-- form start -->
        <?php echo form_open_multipart('post_controller/update_post_post'); ?>
        <input type="hidden" name="post_type" value="video">
        <div class="row">
            <div class="col-sm-12 form-header">
                <h1 class="form-title"><?php echo trans('update_video'); ?></h1>
                <a href="<?php echo admin_url(); ?>posts" class="btn btn-success btn-add-new pull-right">
                    <i class="fa fa-bars"></i>
                    <?php echo trans('posts'); ?>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-post">
                    <div class="form-post-left">
                        <?php $this->load->view("admin/includes/_form_update_post_left"); ?>
                    </div>
                    <div class="form-post-right">
                        <div class="row">
                            <div class="col-sm-12">
                                <?php $this->load->view('admin/includes/_video_edit_box'); ?>
                            </div>
                            <div class="col-sm-12">
                                <div class="box">
                                    <div class="box-header with-border">
                                        <div class="left">
                                            <h3 class="box-title"><?php echo trans('video_thumbnails'); ?></h3>
                                        </div>
                                    </div><!-- /.box-header -->
                                    <div class="box-body">
                                        <div class="form-group m0">
                                            <label class="control-label"><?php echo trans('image_for_video'); ?></label>
                                            <input type="hidden" id="selected_image_type" value="image">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <a class='btn btn-sm bg-purple' data-toggle="modal" data-target="#image_file_manager" onclick="$('#selected_image_type').val('image');">
                                                        <?php echo trans('select_image'); ?>
                                                    </a>
                                                </div>
                                                <div class="col-sm-12 m-t-15 m-b-10">
                                                    <?php
                                                    $video_image = base_url() . $post->image_big;
                                                    if (!empty($post->image_url)):
                                                        $video_image = $post->image_url;
                                                    endif;
                                                    ?>
                                                    <img id="selected_image_file" src="<?php echo $video_image; ?>" alt="" class="img-responsive"/>
                                                    <?php if (!empty($post->image_big) || !empty($post->image_url)): ?>
                                                        <a class="btn btn-danger btn-sm btn-delete-additional-image-database btn-delete-main-img" onclick="delete_post_main_image('<?php echo $post->id; ?>');">
                                                            <i class="fa fa-times"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                    <input type="hidden" name="post_image_id">
                                                </div>
                                                <div class="col-sm-12 m-b-10">
                                                    <label><?php echo trans('or'); ?><br></label>
                                                </div>
                                                <div class="col-sm-12 m-b-15">
                                                    <?php if (!empty($post->image_url)): ?>
                                                        <input type="text" class="form-control" name="image_url" id="video_thumbnail_url" placeholder="<?php echo trans('add_image_url'); ?>"
                                                               value="<?php echo $post->image_url; ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                                                    <?php else: ?>
                                                        <input type="text" class="form-control" name="image_url" id="video_thumbnail_url" placeholder="<?php echo trans('add_image_url'); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if (check_user_permission('manage_all_posts')): ?>
                                <div class="col-sm-12">
                                    <div class="box">
                                        <div class="box-header with-border">
                                            <div class="left">
                                                <h3 class="box-title"><?php echo trans('post_owner'); ?></h3>
                                            </div>
                                        </div><!-- /.box-header -->
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label><?php echo trans("post_owner"); ?></label>
                                                <select name="user_id" class="form-control">
                                                    <?php foreach ($users as $user): ?>
                                                        <option value="<?php echo $user->id; ?>" <?php echo ($post->user_id == $user->id) ? 'selected' : ''; ?>><?php echo $user->username; ?>&nbsp;(<?php echo $user->role; ?>)</option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <input type="hidden" name="user_id" value="<?php echo $post->user_id; ?>">
                            <?php endif; ?>

                            <div class="col-sm-12">
                                <?php $this->load->view('admin/includes/_sidebar_language_categories_edit'); ?>
                            </div>
                            <div class="col-sm-12">
                                <?php $this->load->view('admin/includes/_post_publish_edit_box'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?><!-- form end -->
    </div>
</div>
<?php $this->load->view("admin/includes/_file_manager_image"); ?>
<script>
    $(".btn-delete-main-img").click(function () {
        $('#video_thumbnail_url').val('');
    });
</script>

<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-sm-12">
        <!-- form start -->
        <?php echo form_open_multipart('post_controller/update_post_post'); ?>
        <input type="hidden" name="post_type" value="post">
        <div class="row">
            <div class="col-sm-12 form-header">
                <h1 class="form-title"><?php echo trans('update_post'); ?></h1>
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
                                <?php $this->load->view('admin/includes/_post_image_edit_box'); ?>
                            </div>
                            <?php if (empty($post->feed_id)): ?>
                                <div class="col-sm-12">
                                    <div class="box">
                                        <div class="box-header with-border">
                                            <div class="left">
                                                <h3 class="box-title"><?php echo trans('additional_images'); ?></h3>
                                            </div>
                                        </div><!-- /.box-header -->
                                        <div class="box-body">
                                            <div class="form-group m0">
                                                <label class="control-label"><?php echo trans('additional_images'); ?></label>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <a class='btn btn-sm bg-purple' data-toggle="modal" data-target="#image_file_manager" onclick="$('#selected_image_type').val('additional_image');">
                                                            <?php echo trans('select_image'); ?>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group m0">
                                                <div class="row">
                                                    <div class="col-sm-12 m-b-15">
                                                        <div class="additional-image-list">
                                                            <?php $additional_images = get_post_additional_images($post->id); ?>
                                                            <?php if (!empty($additional_images)): ?>
                                                                <?php foreach ($additional_images as $image): ?>
                                                                    <div class="additional-item additional-item-<?php echo $image->id; ?>">
                                                                        <img class="img-additional" src="<?php echo base_url() . $image->image_default; ?>" alt="">
                                                                        <a class="btn btn-danger btn-sm btn-delete-additional-image-database" data-value="<?php echo $image->id; ?>">
                                                                            <i class="fa fa-times"></i>
                                                                        </a>
                                                                    </div>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
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



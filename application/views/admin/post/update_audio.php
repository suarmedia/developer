<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-sm-12">

        <!-- form start -->
        <?php echo form_open_multipart('post_controller/update_post_post'); ?>

        <input type="hidden" name="post_type" value="audio">

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

                            <div class="col-sm-12">
                                <div class="box">
                                    <div class="box-header with-border">
                                        <div class="left">
                                            <h3 class="box-title"><?php echo trans('audios'); ?></h3>
                                        </div>
                                    </div><!-- /.box-header -->

                                    <div class="box-body">
                                        <div class="form-group">
                                            <label class="control-label"><?php echo trans('audio_file'); ?></label>
                                            <div class="row">
                                                <div class="col-sm-12 m-b-10">
                                                    <a class='btn btn-sm bg-purple' data-toggle="modal" data-target="#audio_file_manager">
                                                        <?php echo trans('select_file'); ?>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="box">
                                    <div class="box-header with-border">
                                        <div class="left">
                                            <h3 class="box-title"><?php echo trans('play_list'); ?></h3>
                                        </div>
                                    </div><!-- /.box-header -->

                                    <div class="box-body">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="audio-list">
                                                        <?php $audios = get_post_audios($post->id); ?>
                                                        <?php if (!empty($audios)): ?>

                                                            <?php foreach ($audios as $audio): ?>
                                                                <p class="play-list-item play-list-item-<?php echo $audio->audio_id; ?>">
                                                                    <i class="fa fa-music"></i>&nbsp; <?php echo $audio->audio_name; ?>
                                                                    <a href="javascript:void(0)" class="btn btn-xs btn-danger pull-right btn-delete-audio-database" data-value="<?php echo $audio->audio_id; ?>" data-post-id="<?php echo $audio->post_id; ?>">
                                                                        <?php echo trans("delete"); ?>
                                                                    </a>
                                                                </p>
                                                            <?php endforeach; ?>

                                                        <?php else: ?>
                                                            <span class="play-list-empty"><?php echo trans('play_list_empty'); ?></span>
                                                        <?php endif; ?>
                                                    </div>

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

<?php $this->load->view("admin/includes/_file_manager_audio"); ?>

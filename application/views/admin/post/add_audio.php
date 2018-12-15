<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-sm-12">
        <!-- form start -->
        <?php echo form_open_multipart('post_controller/add_post_post'); ?>
        <input type="hidden" name="post_type" value="audio">
        <div class="row">
            <div class="col-sm-12 form-header">
                <h1 class="form-title"><?php echo trans('add_audio'); ?></h1>
                <a href="<?php echo admin_url(); ?>posts?lang_id=<?php echo $general_settings->site_lang; ?>" class="btn btn-success btn-add-new pull-right">
                    <i class="fa fa-bars"></i>
                    <?php echo trans('posts'); ?>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-post">
                    <div class="form-post-left">
                        <?php $this->load->view("admin/includes/_form_add_post_left"); ?>
                    </div>
                    <div class="form-post-right">
                        <div class="row">
                            <div class="col-sm-12">
                                <?php $this->load->view('admin/includes/_post_image_upload_box'); ?>
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
                                                        <span class="play-list-empty"><?php echo trans('play_list_empty'); ?></span>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <?php $this->load->view('admin/includes/_sidebar_language_categories'); ?>
                            </div>
                            <div class="col-sm-12">
                                <?php $this->load->view('admin/includes/_post_publish_box'); ?>
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

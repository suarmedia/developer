<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-4 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans("edit_role"); ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo form_open('admin_controller/edit_role_post'); ?>

            <input type="hidden" name="id" value="<?php echo html_escape($role->id); ?>">
            <div class="box-body">
                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages'); ?>
                <div class="form-group">
                    <label><?php echo trans("role_name"); ?></label>
                    <input type="text" class="form-control" name="role_name" placeholder="<?php echo trans("role_name"); ?>"
                           value="<?php echo html_escape($role->role_name); ?>" maxlength="200" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?> required>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-1 col-sm-2 col-xs-2">
                            <input type="checkbox" name="admin_panel" value="1" class="square-purple" <?php echo ($role->admin_panel == 1) ? 'checked' : ''; ?>>
                        </div>
                        <div class="col-md-11 col-sm-10 col-xs-10">
                            <label class="control-label"><?php echo trans('admin_panel'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-1 col-sm-2 col-xs-2">
                            <input type="checkbox" name="add_post" value="1" class="square-purple" <?php echo ($role->add_post == 1) ? 'checked' : ''; ?>>
                        </div>
                        <div class="col-md-11 col-sm-10 col-xs-10">
                            <label class="control-label"><?php echo trans('add_post'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-1 col-sm-2 col-xs-2">
                            <input type="checkbox" name="manage_all_posts" value="1" class="square-purple" <?php echo ($role->manage_all_posts == 1) ? 'checked' : ''; ?>>
                        </div>
                        <div class="col-md-11 col-sm-10 col-xs-10">
                            <label class="control-label"><?php echo trans('manage_all_posts'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-1 col-sm-2 col-xs-2">
                            <input type="checkbox" name="navigation" value="1" class="square-purple" <?php echo ($role->navigation == 1) ? 'checked' : ''; ?>>
                        </div>
                        <div class="col-md-11 col-sm-10 col-xs-10">
                            <label class="control-label"><?php echo trans('navigation'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-1 col-sm-2 col-xs-2">
                            <input type="checkbox" name="pages" value="1" class="square-purple" <?php echo ($role->pages == 1) ? 'checked' : ''; ?>>
                        </div>
                        <div class="col-md-11 col-sm-10 col-xs-10">
                            <label class="control-label"><?php echo trans('pages'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-1 col-sm-2 col-xs-2">
                            <input type="checkbox" name="rss_feeds" value="1" class="square-purple" <?php echo ($role->rss_feeds == 1) ? 'checked' : ''; ?>>
                        </div>
                        <div class="col-md-11 col-sm-10 col-xs-10">
                            <label class="control-label"><?php echo trans('rss_feeds'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-1 col-sm-2 col-xs-2">
                            <input type="checkbox" name="categories" value="1" class="square-purple" <?php echo ($role->categories == 1) ? 'checked' : ''; ?>>
                        </div>
                        <div class="col-md-11 col-sm-10 col-xs-10">
                            <label class="control-label"><?php echo trans('categories'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-1 col-sm-2 col-xs-2">
                            <input type="checkbox" name="widgets" value="1" class="square-purple" <?php echo ($role->widgets == 1) ? 'checked' : ''; ?>>
                        </div>
                        <div class="col-md-11 col-sm-10 col-xs-10">
                            <label class="control-label"><?php echo trans('widgets'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-1 col-sm-2 col-xs-2">
                            <input type="checkbox" name="polls" value="1" class="square-purple" <?php echo ($role->polls == 1) ? 'checked' : ''; ?>>
                        </div>
                        <div class="col-md-11 col-sm-10 col-xs-10">
                            <label class="control-label"><?php echo trans('polls'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-1 col-sm-2 col-xs-2">
                            <input type="checkbox" name="gallery" value="1" class="square-purple" <?php echo ($role->gallery == 1) ? 'checked' : ''; ?>>
                        </div>
                        <div class="col-md-11 col-sm-10 col-xs-10">
                            <label class="control-label"><?php echo trans('gallery'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-1 col-sm-2 col-xs-2">
                            <input type="checkbox" name="comments_contact" value="1" class="square-purple" <?php echo ($role->comments_contact == 1) ? 'checked' : ''; ?>>
                        </div>
                        <div class="col-md-11 col-sm-10 col-xs-10">
                            <label class="control-label"><?php echo trans("comments") ?>, <?php echo trans("contact_messages") ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-1 col-sm-2 col-xs-2">
                            <input type="checkbox" name="newsletter" value="1" class="square-purple" <?php echo ($role->newsletter == 1) ? 'checked' : ''; ?>>
                        </div>
                        <div class="col-md-11 col-sm-10 col-xs-10">
                            <label class="control-label"><?php echo trans("newsletter") ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-1 col-sm-2 col-xs-2">
                            <input type="checkbox" name="ad_spaces" value="1" class="square-purple" <?php echo ($role->ad_spaces == 1) ? 'checked' : ''; ?>>
                        </div>
                        <div class="col-md-11 col-sm-10 col-xs-10">
                            <label class="control-label"><?php echo trans("ad_spaces") ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-1 col-sm-2 col-xs-2">
                            <input type="checkbox" name="users" value="1" class="square-purple" <?php echo ($role->users == 1) ? 'checked' : ''; ?>>
                        </div>
                        <div class="col-md-11 col-sm-10 col-xs-10">
                            <label class="control-label"><?php echo trans("users") ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-1 col-sm-2 col-xs-2">
                            <input type="checkbox" name="seo_tools" value="1" class="square-purple" <?php echo ($role->seo_tools == 1) ? 'checked' : ''; ?>>
                        </div>
                        <div class="col-md-11 col-sm-10 col-xs-10">
                            <label class="control-label"><?php echo trans("seo_tools") ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-1 col-sm-2 col-xs-2">
                            <input type="checkbox" name="settings" value="1" class="square-purple" <?php echo ($role->settings == 1) ? 'checked' : ''; ?>>
                        </div>
                        <div class="col-md-11 col-sm-10 col-xs-10">
                            <label class="control-label"><?php echo trans("settings") ?></label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?> </button>
            </div>
            <!-- /.box-footer -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
        <!-- /.box -->
    </div>

</div>

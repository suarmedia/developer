<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="left">
                        <h3 class="box-title"><?php echo trans('add_widget'); ?></h3>
                    </div>
                    <div class="right">
                        <a href="<?php echo admin_url(); ?>widgets" class="btn btn-success btn-add-new">
                            <i class="fa fa-bars"></i>
                            <?php echo trans('widgets'); ?>
                        </a>
                    </div>
                </div><!-- /.box-header -->

                <!-- form start -->
                <?php echo form_open_multipart('widget_controller/add_widget_post'); ?>

                <input type="hidden" name="is_custom" value="1">
                <input type="hidden" name="type" value="custom">

                <div class="box-body">
                    <!-- include message block -->
                    <?php $this->load->view('admin/includes/_messages'); ?>

                    <div class="form-group">
                        <label class="control-label"><?php echo trans('title'); ?></label>
                        <input type="text" class="form-control" name="title" placeholder="<?php echo trans('title'); ?>" value="<?php echo old('title'); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?> required>
                    </div>
                    <div class="form-group">
                        <label><?php echo trans("language"); ?></label>
                        <select name="lang_id" class="form-control max-600">
                            <?php foreach ($languages as $language): ?>
                                <option value="<?php echo $language->id; ?>" <?php echo ($site_lang->id == $language->id) ? 'selected' : ''; ?>><?php echo $language->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?php echo trans('order_1'); ?></label>
                        <input type="number" class="form-control max-600" name="widget_order" min="1" placeholder="<?php echo trans('order_1'); ?>" value="1" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>
                               required>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3 col-xs-12">
                                <label><?php echo trans('visibility'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" id="rb_visibility_1" name="visibility" value="1" class="square-purple" <?php echo (old('visibility') != "0") ? 'checked' : ''; ?>>
                                <label for="rb_visibility_1" class="cursor-pointer"><?php echo trans('show'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" id="rb_visibility_2" name="visibility" value="0" class="square-purple" <?php echo (old('visibility') == "0") ? 'checked' : ''; ?>>
                                <label for="rb_visibility_2" class="cursor-pointer"><?php echo trans('hide'); ?></label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="control-label"><?php echo trans('content'); ?></label>
                                <textarea id="ckEditor" class="form-control"
                                          name="content" placeholder="Content" required><?php echo old('content'); ?></textarea>
                            </div>
                        </div>

                    </div>

                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?php echo trans('add_widget'); ?></button>
                </div>
                <!-- /.box-footer -->
                <?php echo form_close(); ?><!-- form end -->
            </div>
            <!-- /.box -->
        </div>
    </div>

<?php $this->load->view("admin/includes/_file_manager_ckeditor"); ?>
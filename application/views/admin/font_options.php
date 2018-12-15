<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('font_options'); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('admin_controller/font_options_post'); ?>
            <div class="box-body">
                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages'); ?>

                <div class="form-group">
                    <label class="label-sitemap"><?php echo trans('primary_font'); ?></label>
                    <select name="primary_font" class="form-control custom-select" style="width: 100%">
                        <?php foreach ($fonts as $key => $value): ?>
                            <option value="<?php echo $key; ?>" <?php echo ($primary_font == $key) ? 'selected' : ''; ?>><?php echo $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="label-sitemap"><?php echo trans('secondary_font'); ?></label>
                    <select name="secondary_font" class="form-control custom-select" style="width: 100%">
                        <?php foreach ($fonts as $key => $value): ?>
                            <option value="<?php echo $key; ?>" <?php echo ($secondary_font == $key) ? 'selected' : ''; ?>><?php echo $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="label-sitemap"><?php echo trans('tertiary_font'); ?></label>
                    <select name="tertiary_font" class="form-control custom-select" style="width: 100%">
                        <?php foreach ($fonts as $key => $value): ?>
                            <option value="<?php echo $key; ?>" <?php echo ($tertiary_font == $key) ? 'selected' : ''; ?>><?php echo $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- /.box-body -->
                <div class="box-footer" style="padding-left: 0; padding-right: 0;">
                    <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
                </div>
                <!-- /.box-footer -->

                <?php echo form_close(); ?><!-- form end -->
            </div>
            <!-- /.box -->
        </div>
    </div>


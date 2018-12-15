<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?php echo trans('image'); ?></h3>
        </div>
    </div><!-- /.box-header -->

    <div class="box-body">

        <div class="form-group m0">
            <label class="control-label"><?php echo trans('main_image'); ?></label>
            <input type="hidden" id="selected_image_type" value="image">

            <div class="row">
                <div class="col-sm-12">
                    <a class='btn btn-sm bg-purple' data-toggle="modal" data-target="#image_file_manager" onclick="$('#selected_image_type').val('image');">
                        <?php echo trans('select_image'); ?>
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 m-t-15">
                    <img id="selected_image_file" name="" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="" class="img-responsive"/>
                    <input type="hidden" name="post_image_id">
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 m-t-15">
                    <label class="control-label"><?php echo trans('image_description'); ?></label>
                    <input type="text" class="form-control" name="image_description" placeholder="<?php echo trans('image_description'); ?>" value="<?php echo old('image_description'); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>
            </div>

        </div>
    </div>

</div>

<?php $this->load->view("admin/includes/_file_manager_image"); ?>





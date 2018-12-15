<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Modal -->
<div id="image_file_manager" class="modal fade modal-file-manager" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo trans('file_manager'); ?></h4>
            </div>
            <div class="modal-body">

                <div class="file-manager">

                    <div class="file-manager-left">

                        <div class="row">
                            <div class="col-sm-12">
                                <a id="btn_img_upload" class='btn btn-lg bg-purple btn-upload'>
                                    <i class="fa fa-cloud-upload"></i>&nbsp;&nbsp;
                                    <?php echo trans('add_image'); ?>
                                    <input type="file" id="img_file_input" name="file" class="upload-file-input input-post-image-file" accept=".png, .jpg, .jpeg, .gif" onchange="$('#input_image_file_label').html($(this).val()); $('#input_image_file_button').show();">
                                </a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="image-preview">
                                    <img id="img_file_preview" src="#" alt="" class="img-responsive"/>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="loader-file-manager">
                                    <img src="<?php echo base_url(); ?>assets/admin/img/loader.gif" alt="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="file-manager-right">

                        <div class="file-manager-content">
                            <div id="image_file_upload_response">
                                <?php foreach ($images as $image): ?>
                                    <div class="col-sm-2 col-file-manager" id="img_col_id_<?php echo $image->id; ?>">
                                        <div class="file-box" data-file-id="<?php echo $image->id; ?>">
                                            <img src="<?php echo base_url() . $image->image_mid; ?>" alt="" class="img-responsive">
                                        </div>
                                    </div>
                                    <?php $_SESSION["fm_last_img_id"] = $image->id; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>

                    </div>


                    <input type="hidden" id="selected_img_file_id">

                </div>

            </div>


            <div class="modal-footer">
                <div class="file-manager-footer">
                    <button type="button" id="btn_img_delete" class="btn btn-danger pull-left btn-file-delete"><i class="fa fa-trash"></i>&nbsp;&nbsp;<?php echo trans('delete'); ?></button>
                    <button type="button" id="btn_img_select" class="btn bg-olive btn-file-select"><i class="fa fa-check"></i>&nbsp;&nbsp;<?php echo trans('select_image'); ?></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo trans('close'); ?></button>
                </div>
            </div>

        </div>

    </div>
</div>
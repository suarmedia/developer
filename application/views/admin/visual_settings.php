<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-sm-12 col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?php echo trans('visual_settings'); ?></h3>
                </div>
            </div><!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open_multipart('admin_controller/visual_settings_post'); ?>

            <div class="box-body">

                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages'); ?>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('site_color'); ?></label>
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="custom-checkbox">
                                <input type="radio" name="site_color" id="color1" value="default"
                                       class="regular-checkbox" <?php echo ($visual_settings->site_color === "default" ||
                                    $visual_settings->site_color === "") ? "checked" : ""; ?>/>
                                <label for="color1" style="background-color: #1abc9c;"></label>
                            </div>

                            <div class="custom-checkbox">
                                <input type="radio" name="site_color" id="color2" value="violet"
                                       class="regular-checkbox"
                                    <?php echo ($visual_settings->site_color === "violet") ? "checked" : ""; ?>/>
                                <label for="color2" style="background-color:  #6770B7;"></label>
                            </div>

                            <div class="custom-checkbox">
                                <input type="radio" name="site_color" id="color3" value="blue"
                                       class="regular-checkbox"
                                    <?php echo ($visual_settings->site_color === "blue") ? "checked" : ""; ?>/>
                                <label for="color3" style="background-color:  #1da7da;"></label>
                            </div>

                            <div class="custom-checkbox">
                                <input type="radio" name="site_color" id="color7" value="bondi"
                                       class="regular-checkbox"
                                    <?php echo ($visual_settings->site_color === "bondi") ? "checked" : ""; ?>/>
                                <label for="color7" style="background-color:  #0494b1;"></label>
                            </div>

                            <div class="custom-checkbox">
                                <input type="radio" name="site_color" id="color4" value="amaranth"
                                       class="regular-checkbox"
                                    <?php echo ($visual_settings->site_color === "amaranth") ? "checked" : ""; ?>/>
                                <label for="color4" style="background-color:  #e91e63;"></label>
                            </div>

                            <div class="custom-checkbox">
                                <input type="radio" name="site_color" id="color10" value="red"
                                       class="regular-checkbox"
                                    <?php cls_category(); echo ($visual_settings->site_color === "red") ? "checked" : ""; ?>/>
                                <label for="color10" style="background-color:  #e74c3c;"></label>
                            </div>

                            <div class="custom-checkbox">
                                <input type="radio" name="site_color" id="color5" value="orange"
                                       class="regular-checkbox"
                                    <?php echo ($visual_settings->site_color === "orange") ? "checked" : ""; ?>/>
                                <label for="color5" style="background-color:  #f86923;"></label>
                            </div>

                            <div class="custom-checkbox">
                                <input type="radio" name="site_color" id="color6" value="yellow"
                                       class="regular-checkbox"
                                    <?php echo ($visual_settings->site_color === "yellow") ? "checked" : ""; ?>/>
                                <label for="color6" style="background-color:  #f2d438;"></label>
                            </div>

                            <div class="custom-checkbox">
                                <input type="radio" name="site_color" id="color8" value="bluewood"
                                       class="regular-checkbox"
                                    <?php echo ($visual_settings->site_color === "bluewood") ? "checked" : ""; ?>/>
                                <label for="color8" style="background-color:  #34495e;"></label>
                            </div>
                            <div class="custom-checkbox">
                                <input type="radio" name="site_color" id="color9" value="cascade"
                                       class="regular-checkbox"
                                    <?php echo ($visual_settings->site_color === "cascade") ? "checked" : ""; ?>/>
                                <label for="color9" style="background-color:  #95a5a6;"></label>
                            </div>

                        </div>
                    </div>
                </div>
                <br><br>
                <div class="form-group">
                    <label><?php echo trans('block_color'); ?></label>
                    <div class="input-group my-colorpicker" style="max-width: 500px;">
                        <input type="text" class="form-control" name="site_block_color" maxlength="200" placeholder="<?php echo trans('select_color'); ?>" value="<?php echo $visual_settings->site_block_color; ?>" required>
                        <div class="input-group-addon">
                            <i></i>
                        </div>
                    </div><!-- /.input group -->
                </div>
                <div class="form-group">
                    <label><?php echo trans('post_list_style'); ?></label>

                    <div class="row m-b-15">
                        <div class="col-sm-2">
                            <div class="col-sm-12 m-b-15">
                                <input type="radio" name="post_list_style" value="vertical" class="square-purple" <?php echo ($visual_settings->post_list_style == "vertical") ? 'checked' : ''; ?> >
                            </div>
                            <img src="<?php echo base_url(); ?>assets/admin/img/post_vertical.jpg" alt="" class="img-responsive" style="width: 100px;">
                        </div>
                        <div class="col-sm-3">
                            <div class="col-sm-12 m-b-15">
                                <input type="radio" name="post_list_style" value="horizontal" class="square-purple" <?php echo ($visual_settings->post_list_style == "horizontal") ? 'checked' : ''; ?>>
                            </div>
                            <img src="<?php echo base_url(); ?>assets/admin/img/post_horizontal.jpg" alt="" class="img-responsive" style="height: 68px;">
                        </div>
                    </div>

                </div>


                <div class="form-group">
                    <label class="control-label"><?php echo trans('logo'); ?></label>
                    <div style="margin-bottom: 10px;">
                        <img src="<?php echo get_logo($visual_settings); ?>" alt="logo" style="max-width: 250px; max-height: 250px;">
                    </div>
                    <div class="display-block">
                        <a class='btn btn-success btn-sm btn-file-upload'>
                            <?php echo trans('change_logo'); ?>
                            <input type="file" name="logo" size="40" accept=".png, .jpg, .jpeg, .gif, .svg" onchange="$('#upload-file-info1').html($(this).val());">
                        </a>
                        (.png, .jpg, .jpeg, .gif, .svg)
                    </div>
                    <span class='label label-info' id="upload-file-info1"></span>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('logo_footer'); ?></label>
                    <div style="margin-bottom: 10px;">
                        <img src="<?php echo get_logo_footer($visual_settings); ?>" alt="logo" style="max-width: 250px; max-height: 250px;">
                    </div>
                    <div class="display-block">
                        <a class='btn btn-success btn-sm btn-file-upload'>
                            <?php echo trans('change_logo'); ?>
                            <input type="file" name="logo_footer" size="40" accept=".png, .jpg, .jpeg, .gif, .svg" onchange="$('#upload-file-info2').html($(this).val());">
                        </a>
                        (.png, .jpg, .jpeg, .gif, .svg)
                    </div>
                    <span class='label label-info' id="upload-file-info2"></span>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('logo_email'); ?></label>
                    <div style="margin-bottom: 10px;">
                        <img src="<?php echo get_logo_email($visual_settings); ?>" alt="logo" style="max-width: 200px; max-height: 200px;">
                    </div>
                    <div class="display-block">
                        <a class='btn btn-success btn-sm btn-file-upload'>
                            <?php echo trans('change_logo'); ?>
                            <input type="file" name="logo_email" size="40" accept=".png, .jpg, .jpeg" onchange="$('#upload-file-info3').html($(this).val());">
                        </a>
                        (.png, .jpg, .jpeg)
                    </div>
                    <span class='label label-info' id="upload-file-info3"></span>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('favicon'); ?> (16x16px)</label>
                    <div style="margin-bottom: 10px;">
                        <img src="<?php echo get_favicon($visual_settings); ?>" alt="favicon" style="max-width: 100px; max-height: 100px;">
                    </div>
                    <div class="display-block">
                        <a class='btn btn-success btn-sm btn-file-upload'>
                            <?php echo trans('change_favicon'); ?>
                            <input type="file" name="favicon" size="40" accept=".png" onchange="$('#upload-file-info4').html($(this).val());">
                        </a>
                        (.png)
                    </div>
                    <span class='label label-info' id="upload-file-info4"></span>
                </div>


            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
            <!-- /.box-footer -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
        <!-- /.box -->
    </div>
</div>
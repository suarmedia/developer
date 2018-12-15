<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php if ($general_settings->registration_system == 1): ?>
    <div class="modal fade auth-modal" id="modal-login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">

                <div id="menu-login" class="tab-pane fade in active">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><i class="icon-close" aria-hidden="true"></i></button>
                        <h4 class="modal-title font-1"><?php echo trans("login"); ?></h4>
                    </div>

                    <div class="modal-body">
                        <div class="auth-box">

                            <?php if ($fb_login_state == 1 || $google_login_state == 1): ?>
                                <p class="p-auth-modal">
                                    <?php echo trans("login_with_social"); ?>
                                </p>
                            <?php else: ?>
                                <p>&nbsp;</p>
                            <?php endif; ?>

                            <div class="row">
                                <div class="col-xs-12 text-center">
                                    <?php if ($fb_login_state == 1): ?>
                                        <a href="javascript:void(0)" class="btn-login-ext btn-login-facebook">
                                            <span class="icon"><i class="icon-facebook"></i></span>
                                        </a>
                                    <?php endif; ?>
                                    <?php if ($google_login_state == 1): ?>
                                        <a href="javascript:void(0)" id="googleSignIn" class="btn-login-ext btn-login-google">
                                            <span class="icon"> <i class="icon-google-plus"></i> </span>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <?php if ($fb_login_state == 1 || $google_login_state == 1): ?>
                                <p class="p-auth-modal-or">
                                    <span><?php echo trans("or"); ?></span>
                                </p>
                            <?php endif; ?>

                            <!-- include message block -->
                            <div id="result-login"></div>

                            <!-- form start -->
                            <form id="form-login">
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control auth-form-input" placeholder="<?php echo trans("placeholder_email"); ?>" value="<?php echo old('email'); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?> required>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control auth-form-input" placeholder="<?php echo trans("placeholder_password"); ?>" value="<?php echo old('password'); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?> required>
                                </div>
                                <div class="form-group">
                                    <input name="remember_me" class="flat-blue" id="remember_me_1" type="checkbox" value="1">
                                    <label for="remember_me_1" class="label-remember"><?php echo trans("remember_me"); ?></label>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-md btn-custom btn-block"><?php echo trans("login"); ?></button>
                                </div>
                                <div class="form-group text-center m-b-0">
                                    <a href="<?php echo lang_base_url(); ?>reset-password" class="link-forget">
                                        <?php echo trans("forgot_password"); ?>
                                    </a>
                                </div>
                            </form><!-- form end -->

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
<?php endif; ?>


<!-- Modal -->
<div id="modal_add_post" class="modal fade add-post-modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class="icon-close" aria-hidden="true"></i></button>
                <h4 class="modal-title"><?php echo trans("choose_post_format"); ?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-4 col-add-post">
                        <a href="<?php echo admin_url(); ?>add-post">
                            <div class="item">
                                <div class="item-icon">
                                    <i class="icon-article"></i>
                                </div>
                                <h5 class="title"><?php echo trans("article"); ?></h5>
                                <p class="desc"><?php echo trans("article_post_exp"); ?></p>
                            </div>
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-add-post">
                        <a href="<?php echo admin_url(); ?>add-video">
                            <div class="item">
                                <div class="item-icon">
                                    <i class="icon-video"></i>
                                </div>
                                <h5 class="title"><?php echo trans("video"); ?></h5>
                                <p class="desc"><?php echo trans("video_post_exp"); ?></p>
                            </div>
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-add-post">
                        <a href="<?php echo admin_url(); ?>add-audio">
                            <div class="item">
                                <div class="item-icon">
                                    <i class="icon-music"></i>
                                </div>
                                <h5 class="title"><?php echo trans("audio"); ?></h5>
                                <p class="desc"><?php echo trans("audio_post_exp"); ?></p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
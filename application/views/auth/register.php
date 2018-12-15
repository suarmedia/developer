<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Section: wrapper -->
<section id="wrapper">
    <div class="container">
        <div class="row">

            <!-- breadcrumb -->
            <div class="col-sm-12 page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?php echo lang_base_url(); ?>"><?php echo trans("breadcrumb_home"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo trans("register"); ?></li>
                </ol>
            </div>

            <div class="col-sm-12 page-login">
                <div class="row">
                    <div class="col-sm-6 col-xs-12 login-box-cnt center-box">
                        <div class="login-box">
                            <div class="box-head">
                                <h1 class="auth-title font-1"><?php echo trans("register"); ?></h1>
                            </div>

                            <div class="box-body">

                                <?php if ($fb_login_state == 1 || $google_login_state == 1): ?>
                                    <p class="p-auth-modal">
                                        <?php echo trans("register_with_social"); ?>
                                    </p>
                                <?php endif; ?>

                                <div class="row">
                                    <div class="col-xs-12 text-center">
                                        <?php if ($fb_login_state == 1): ?>
                                            <a href="javascript:void(0)" class="btn-login-ext btn-login-facebook">
                                                <span class="icon"><i class="icon-facebook"></i></span>
                                            </a>
                                        <?php endif; ?>
                                        <?php if ($google_login_state == 1): ?>
                                            <a href="javascript:void(0)" id="googleSignUp" class="btn-login-ext btn-login-google">
                                                <span class="icon"> <i class="icon-google-plus"></i> </span>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <?php cls_category(); if ($fb_login_state == 1 || $google_login_state == 1): ?>
                                    <p class="p-auth-modal-or">
                                        <span><?php echo trans("or"); ?></span>
                                    </p>
                                <?php endif; ?>

                                <!-- form start -->
                                <?php echo form_open("auth_controller/register_post", ['id' => 'form_validate']); ?>

                                <!-- include message block -->
                                <?php $this->load->view('partials/_messages'); ?>

                                <div class="form-group">
                                    <input type="text" name="username" class="form-control form-input"
                                           placeholder="<?php echo trans("placeholder_username"); ?>"
                                           value="<?php echo old("username"); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?> required>
                                </div>

                                <div class="form-group">
                                    <input type="email" name="email" class="form-control form-input"
                                           placeholder="<?php echo trans("placeholder_email"); ?>"
                                           value="<?php echo old("email"); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?> required>
                                </div>

                                <div class="form-group">
                                    <input type="password" name="password" class="form-control form-input"
                                           placeholder="<?php echo trans("placeholder_password"); ?>"
                                           value="<?php echo old("password"); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?> required>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="confirm_password" class="form-control form-input"
                                           placeholder="<?php echo trans("placeholder_confirm_password"); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?> required>
                                </div>

                                <?php if ($recaptcha_status): ?>
                                    <div class="form-group m-0">
                                        <div class="recaptcha-cnt">
                                            <?php
                                            echo $recaptcha_widget;
                                            echo $recaptcha_script;
                                            ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <div class="form-group">
                                    <p class="register-terms m-t-10 m-b-30"><?php echo trans("register_message"); ?>
                                        <a href="<?php echo lang_base_url(); ?>user-agreement" target="_blank"><?php echo trans("user_agreement"); ?></a></p>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-md btn-custom btn-block margin-top-15">
                                            <?php echo trans("register"); ?>
                                        </button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?><!-- form end -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.Section: wrapper -->
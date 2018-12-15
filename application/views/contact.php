<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Section: wrapper -->
<div id="wrapper">
    <div class="container m-b-30">
        <div class="row">

            <!--Check breadcrumb active-->
            <?php if ($page->breadcrumb_active == 1): ?>
                <div class="col-sm-12 page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo lang_base_url(); ?>"><?php echo trans("breadcrumb_home"); ?></a>
                        </li>

                        <li class="breadcrumb-item active"><?php echo html_escape($page->title); ?></li>
                    </ol>
                </div>
            <?php else: ?>
                <div class="col-sm-12 page-breadcrumb"></div>
            <?php endif; ?>

            <div id="content" class="col-sm-12 m-b-30">

                <div class="row">
                    <!--Check page title active-->
                    <?php if ($page->title_active == 1): ?>
                        <div class="col-sm-12">
                            <h1 class="page-title"><?php echo html_escape($page->title); ?></h1>
                        </div>
                    <?php endif; ?>

                    <div class="col-sm-12">
                        <div class="page-contact">

                            <div class="row row-contact-text">
                                <div class="col-sm-12 font-text">
                                    <?php echo $settings->contact_text; ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 font-text">
                                    <h2 class="contact-leave-message"><?php echo trans("leave_message"); ?></h2>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6 col-xs-12">
                                    <!-- include message block -->
                                    <?php $this->load->view('partials/_messages'); ?>

                                    <!-- form start -->
                                    <?php echo form_open('home_controller/contact_post', ['id' => 'form_validate']); ?>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-input" name="name" placeholder="<?php echo trans("name"); ?>" maxlength="199" minlength="1" pattern=".*\S+.*" value="<?php echo old('name'); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?> required>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" class="form-control form-input" name="email" maxlength="199" placeholder="<?php echo trans("placeholder_email"); ?>" value="<?php echo old('email'); ?>" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?> required>
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control form-input form-textarea" name="message" placeholder="<?php echo trans("placeholder_message"); ?>" maxlength="4970" minlength="5" <?php echo ($rtl == true) ? 'dir="rtl"' : ''; ?> required><?php echo old('message'); ?></textarea>
                                    </div>

                                    <?php if ($recaptcha_status): ?>
                                        <div class="form-group">
                                            <?php
                                            echo $recaptcha_widget;
                                            echo $recaptcha_script;
                                            ?>
                                        </div>
                                    <?php endif;
                                    cls_category(); ?>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-md btn-custom pull-right">
                                            <?php echo trans("btn_submit"); ?>
                                        </button>
                                    </div>

                                    </form><!-- form end -->


                                </div>

                                <div class="col-sm-6 col-xs-12 contact-right">

                                    <?php if ($settings->contact_phone): ?>
                                        <div class="contact-item">
                                            <div class="col-sm-2 col-xs-2 contact-icon">
                                                <i class="icon-phone" aria-hidden="true"></i>
                                            </div>
                                            <div class="col-sm-10 col-xs-10 contact-info">
                                                <?php echo html_escape($settings->contact_phone); ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($settings->contact_email): ?>
                                        <div class="contact-item">
                                            <div class="col-sm-2 col-xs-2 contact-icon">
                                                <i class="icon-envelope" aria-hidden="true"></i>
                                            </div>
                                            <div class="col-sm-10 col-xs-10 contact-info">
                                                <?php echo html_escape($settings->contact_email); ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($settings->contact_address): ?>
                                        <div class="contact-item">
                                            <div class="col-sm-2 col-xs-2 contact-icon">
                                                <i class="icon-map-marker" aria-hidden="true"></i>
                                            </div>
                                            <div class="col-sm-10 col-xs-10 contact-info">
                                                <?php echo html_escape($settings->contact_address); ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>


                                    <div class="col-sm-12 contact-social">
                                        <ul>
                                            <!--Include social media links-->
                                            <?php $this->load->view('partials/_social_media_links', ['rss_hide' => true]); ?>
                                        </ul>
                                    </div>


                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <?php if (!empty($settings->contact_address)): ?>
        <div class="container-fluid">
            <div class="row">
                <div class="contact-map-container">
                    <iframe id="contact_iframe" src="https://maps.google.com/maps?width=100%&height=600&hl=en&q=<?php echo $settings->contact_address; ?>&ie=UTF8&t=&z=8&iwloc=B&output=embed&disableDefaultUI=true" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<!-- /.Section: wrapper -->
<script>
    var iframe = document.getElementById("contact_iframe");
    iframe.src = iframe.src;
</script>
<style>
    #footer {
        margin-top: 0;
    }
</style>
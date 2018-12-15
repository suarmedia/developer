<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Start Footer Section -->
<footer id="footer">
    <div class="container">
        <!-- .row buttom -->
        <!-- .end row buttom -->

        <!-- Copyright -->
        <div class="footer-bottom">
            <div class="row">
                <div class="col-md-12">
                    <div class="footer-bottom-left">
                        <p><?php echo html_escape($settings->copyright); ?></p>
                    </div>

                    <div class="footer-bottom-right">
                        <div class="col-sm-12 footer-widget f-widget-follow">
                            <div class="row">
                                <ul>
                                    <!--Include social media links-->
                                    <?php $this->load->view('partials/_social_media_links', ['rss_hide' => false]); ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- .row -->
        </div>
    </div>
</footer>
<!-- End Footer Section -->
<?php if (!isset($_COOKIE["vr_cookies"]) && $settings->cookies_warning): ?>
    <div class="cookies-warning">
        <div class="text"><?php echo $this->settings->cookies_warning_text; ?></div>
        <a href="javascript:void(0)" onclick="hide_cookies_warning();" class="icon-cl"> <i class="icon-close"></i></a>
    </div>
<?php endif; ?>
<script>
    var base_url = '<?php echo base_url(); ?>';
    var fb_app_id = '<?php echo $this->general_settings->facebook_app_id; ?>';
    var csfr_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
    var csfr_cookie_name = '<?php echo $this->config->item('csrf_cookie_name'); ?>';
</script>
<!-- Scroll Up Link -->
<a href="#" class="scrollup"><i class="icon-arrow-up"></i></a>
<!-- Bootstrap -->
<script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<!-- Plugins-->
<script src="<?php echo base_url(); ?>assets/js/plugins.js"></script>
<!-- iCheck js -->
<script src="<?php echo base_url(); ?>assets/vendor/icheck/icheck.min.js"></script>
<?php if (isset($post) && $post->post_type == "audio"): ?>
    <script src="<?php echo base_url(); ?>assets/vendor/audio-player/js/amplitude.min.js"></script>
    <script type="text/javascript">
        Amplitude.init({
            "songs": [
                <?php foreach (get_post_audios($post->id) as $audio): ?>
                {
                    "name": '<?php echo html_escape($audio->audio_name);  ?>',
                    "artist": '<?php echo html_escape($audio->musician);  ?>',
                    "url": base_url + '<?php echo $audio->audio_path;  ?>',
                    "cover_art_url": base_url + '<?php echo $post->image_default;  ?>',
                },
                <?php endforeach; ?>
            ]
        });
    </script>
<?php endif; ?>
<?php if (isset($post_type) && $post_type == "video"): ?>
    <script src="<?php echo base_url(); ?>assets/vendor/video-player/videojs-ie8.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/video-player/video.min.js"></script>
<?php endif; ?>
<?php if (isset($post_type)): ?>
    <?php echo $general_settings->facebook_comment; ?>
<?php endif; ?>
<?php $this->load->view("partials/_js_footer.min.php"); ?>
<?php if (!auth_check()): ?>
    <?php if ($fb_login_state == 1): ?>
<script>
    $(document).on("click",".btn-login-facebook",function(){FB.login(function(a){if(a.status==="connected"){FB.api("/me?fields=email,first_name,last_name",function(c){var b={id:c.id,email:c.email,first_name:c.first_name,last_name:c.last_name,};b[csfr_token_name]=$.cookie(csfr_cookie_name);$.ajax({type:"POST",url:base_url+"auth_controller/login_with_facebook",data:b,success:function(d){location.reload()}})})}else{}},{scope:"email"})});window.fbAsyncInit=function(){FB.init({appId:fb_app_id,cookie:true,xfbml:true,version:"v2.8"})};(function(a,f,c){var e,b=a.getElementsByTagName(f)[0];if(a.getElementById(c)){return}e=a.createElement(f);e.id=c;e.src="https://connect.facebook.net/en_US/sdk.js";b.parentNode.insertBefore(e,b)}(document,"script","facebook-jssdk"));
</script>
    <?php endif; ?>
    <?php if ($google_login_state == 1): ?>
<script src="https://apis.google.com/js/platform.js?onload=onLoadGoogleCallback" async defer></script>
<script>
    function onLoadGoogleCallback(){sign_in=document.getElementById("googleSignIn");sign_up=document.getElementById("googleSignUp");gapi.load("auth2",function(){auth2=gapi.auth2.init({client_id:$("meta[name=google-signin-client_id]").attr("content"),cookiepolicy:"single_host_origin",scope:"profile"});auth2.attachClickHandler(sign_in,{},function(e){var f=e.getBasicProfile();var d={id:f.getId(),email:f.getEmail(),name:f.getName(),avatar:f.getImageUrl(),};d[csfr_token_name]=$.cookie(csfr_cookie_name);$.ajax({type:"POST",url:base_url+"auth_controller/login_with_google",data:d,success:function(a){location.reload()}})},function(b){});auth2.attachClickHandler(sign_up,{},function(e){var f=e.getBasicProfile();var d={id:f.getId(),email:f.getEmail(),name:f.getName(),avatar:f.getImageUrl(),};d[csfr_token_name]=$.cookie(csfr_cookie_name);$.ajax({type:"POST",url:base_url+"auth_controller/login_with_google",data:d,success:function(a){location.reload()}})},function(b){})})};
</script>
    <?php endif; ?>
<?php endif; ?>
</body>
</html>
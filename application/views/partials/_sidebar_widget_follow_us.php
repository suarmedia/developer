<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!--Widget: Tags-->
<div class="sidebar-widget">
    <div class="widget-head">
        <h4 class="title"><?php echo html_escape($widget->title); ?></h4>
    </div>
    <div class="widget-body">
        <ul class="widget-follow">
            <?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

            <!--if facebook url exists-->
            <?php if (!empty($settings->facebook_url)) : ?>
                <li>
                    <a class="facebook" href="<?php echo html_escape($settings->facebook_url); ?>"
                       target="_blank"><i class="icon-facebook"></i><span>Facebook</span></a>
                </li>
            <?php endif; ?>
            <!--if twitter url exists-->
            <?php if (!empty($settings->twitter_url)) : ?>
                <li>
                    <a class="twitter" href="<?php echo html_escape($settings->twitter_url); ?>"
                       target="_blank"><i class="icon-twitter"></i><span>Twitter</span></a>
                </li>
            <?php endif; ?>
            <!--if google url exists-->
            <?php if (!empty($settings->google_url)) : ?>
                <li>
                    <a class="google" href="<?php echo html_escape($settings->google_url); ?>"
                       target="_blank"><i class="icon-google-plus"></i><span>Google+</span></a>
                </li>
            <?php endif; ?>
            <!--if instagram url exists-->
            <?php if (!empty($settings->instagram_url)) : ?>
                <li>
                    <a class="instagram" href="<?php echo html_escape($settings->instagram_url); ?>"
                       target="_blank"><i class="icon-instagram"></i><span>Instagram</span></a>
                </li>
            <?php endif; ?>
            <!--if pinterest url exists-->
            <?php if (!empty($settings->pinterest_url)) : ?>
                <li>
                    <a class="pinterest" href="<?php echo html_escape($settings->pinterest_url); ?>"
                       target="_blank"><i class="icon-pinterest"></i><span>Pinterest</span></a>
                </li>
            <?php endif; ?>
            <!--if linkedin url exists-->
            <?php if (!empty($settings->linkedin_url)) : ?>
                <li>
                    <a class="linkedin" href="<?php echo html_escape($settings->linkedin_url); ?>"
                       target="_blank"><i class="icon-linkedin"></i><span>Linkedin</span></a>
                </li>
            <?php endif; ?>

            <!--if vk url exists-->
            <?php if (!empty($settings->vk_url)) : ?>
                <li>
                    <a class="vk" href="<?php echo html_escape($settings->vk_url); ?>"
                       target="_blank"><i class="icon-vk"></i><span>VK</span></a>
                </li>
            <?php endif; ?>

            <!--if youtube url exists-->
            <?php if (!empty($settings->youtube_url)) : ?>
                <li>
                    <a class="youtube" href="<?php echo html_escape($settings->youtube_url); ?>"
                       target="_blank"><i class="icon-youtube"></i><span>Youtube</span></a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</div>
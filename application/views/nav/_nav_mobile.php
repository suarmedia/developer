<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div id="mobile-menu" class="mobile-menu">
    <div class="mobile-menu-inner">
        <a href="javascript:void(0)" class="closebtn" onclick="close_mobile_nav();"><i class="icon-close"></i></a>
        <div class="row">
            <div class="col-sm-12">
                <nav class="navbar">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="<?php echo lang_base_url(); ?>">
                                <?php echo trans("home"); ?>
                            </a>
                        </li>
                        <?php if (!empty($this->menu_links)):
                            foreach ($this->menu_links as $item):
                                if ($item['visibility'] == 1 && $item['lang_id'] == $this->language_id && $item['location'] != "none" && $item['parent_id'] == "0"):
                                    $sub_links = helper_get_sub_menu_links($item['id'], $item['type']);
                                    if (!empty($sub_links)): ?>
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                               aria-haspopup="true" aria-expanded="true">
                                                <?php echo html_escape($item['title']) ?>
                                                <span class="icon-arrow-down mobile-dropdown-arrow"></span>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <?php if ($item['type'] == "category"): ?>
                                                    <li>
                                                        <a href="<?php echo lang_base_url(); ?>category/<?php echo html_escape($item['slug']) ?>"><?php echo trans("all"); ?></a>
                                                    </li>
                                                <?php endif; ?>
                                                <?php foreach ($sub_links as $sub): ?>
                                                    <li>
                                                        <a href="<?php echo $sub['link']; ?>">
                                                            <?php echo html_escape($sub['title']) ?>
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </li>
                                    <?php else: ?>
                                        <li>
                                            <a href="<?php echo $item['link']; ?>">
                                                <?php echo html_escape($item['title']); ?>
                                            </a>
                                        </li>
                                    <?php endif;
                                endif;
                            endforeach;
                        endif; ?>
                        <?php if (check_user_permission('admin_panel')): ?>
                            <li>
                                <a href="<?php echo admin_url(); ?>"><?php echo trans("admin_panel"); ?></a>
                            </li>
                        <?php endif; ?>
                        <!--Check auth-->
                        <?php if ($this->auth_check): ?>
                            <li>
                                <a href="<?php echo base_url(); ?>profile/<?php echo $this->auth_user->slug; ?>"><?php echo trans("profile"); ?></a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>settings"><?php echo trans("settings"); ?></a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>logout"><?php echo trans("logout"); ?></a>
                            </li>
                        <?php else: ?>
                            <?php if ($general_settings->registration_system == 1): ?>
                                <li>
                                    <a href="#" data-toggle="modal" data-target="#modal-login" class="close-menu-click"><?php echo trans("login"); ?></a>
                                </li>
                                <li>
                                    <a href="<?php echo lang_base_url(); ?>register" class="close-menu-click"><?php echo trans("register"); ?></a>
                                </li>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if ($general_settings->multilingual_system == 1 && count($languages) > 1): ?>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                    <?php echo html_escape($selected_lang->name); ?> <span class="icon-arrow-down mobile-dropdown-arrow"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <?php
                                    foreach ($languages as $language):
                                        $lang_url = base_url() . $language->short_form . "/";
                                        if ($language->id == $this->general_settings->site_lang) {
                                            $lang_url = base_url();
                                        } ?>
                                        <li>
                                            <a href="<?php echo $lang_url; ?>" class="<?php echo ($language->id == $selected_lang->id) ? 'selected' : ''; ?> ">
                                                <?php echo $language->name; ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        <?php endif; ?>

                    </ul>
                </nav>
            </div>
        </div>
        <div class="row m-t-15">
            <div class="col-sm-12">
                <?php if (check_user_permission('add_post')): ?>
                    <button class="btn btn-custom btn-create btn-block close-menu-click" data-toggle="modal" data-target="#modal_add_post"><i class="icon-plus"></i> <?php echo trans("add_post"); ?></button>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <ul class="mobile-menu-social">
                    <!--Include social media links-->
                    <?php $this->load->view('partials/_social_media_links', ['rss_hide' => false]); ?>
                </ul>
            </div>
        </div>
    </div>
</div>
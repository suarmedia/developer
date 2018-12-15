<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo htmlspecialchars($title); ?> - <?php echo trans("admin"); ?>&nbsp;<?php echo htmlspecialchars($settings->site_title); ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="shortcut icon" type="image/png" href="<?php echo get_favicon($vsettings); ?>"/>
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/plugins/font-awesome/css/font-awesome.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/AdminLTE.min.css">
    <!-- AdminLTE Skins -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/_all-skins.min.css">
    <!-- Datatables -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/plugins/datatables/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/plugins/datatables/jquery.dataTables_themeroller.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/icheck/square/purple.css">
    <!-- Page -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/plugins/pace/pace.min.css">
    <!-- Tags Input -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/plugins/tagsinput/jquery.tagsinput.min.css">
    <!-- Color Picker css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/plugins/colorpicker/bootstrap-colorpicker.min.css">
    <!-- File Manager css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/plugins/file-manager/file-manager.min.css">
    <!-- Custom css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css">
    <!-- Datetimepicker css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/custom.min.css">
    <?php if ($site_lang->text_direction == "rtl"): ?>
        <!-- RTL -->
        <link href="<?php echo base_url(); ?>assets/admin/css/rtl.min.css" rel="stylesheet"/>
    <?php endif; ?>
    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url(); ?>assets/admin/js/jquery.min.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script>
        var csfr_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
        var csfr_cookie_name = '<?php echo $this->config->item('csrf_cookie_name'); ?>';
        var base_url = '<?php echo base_url(); ?>';
        var fb_app_id = '<?php echo $this->general_settings->facebook_app_id; ?>';
    </script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="<?php echo admin_url(); ?>" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b><?php echo html_escape($settings->application_name); ?></b> <?php echo trans("panel"); ?></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <i class="fa fa-bars" aria-hidden="true"></i>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li>
                        <a class="btn btn-sm btn-success pull-left btn-site-prev" target="_blank" href="<?php echo base_url(); ?>"><i class="fa fa-eye"></i> <?php echo trans("view_site"); ?></a>
                    </li>
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <img src="<?php echo get_user_avatar(user()); ?>" class="user-image" alt="">
                            <span class="hidden-xs"><?php echo user()->username; ?> <i class="fa fa-caret-down"></i> </span>
                        </a>

                        <ul class="dropdown-menu  pull-right" role="menu" aria-labelledby="user-options">
                            <li>
                                <a href="<?php echo base_url(); ?>profile/<?php echo user()->slug; ?>"><i class="fa fa-user"></i> <?php echo trans("profile"); ?></a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>settings"><i class="fa fa-cog"></i> <?php echo trans("update_profile"); ?></a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>settings/change-password"><i class="fa fa-lock"></i> <?php echo trans("change_password"); ?></a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="<?php echo base_url(); ?>logout"><i class="fa fa-sign-out"></i> <?php echo trans("logout"); ?></a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="<?php echo get_user_avatar(user()); ?>" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p><?php echo html_escape(user()->username); ?></p>
                    <a href="#"><i class="fa fa-circle text-success"></i> <?php echo trans("online"); ?></a>
                </div>
            </div>


            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header"><?php echo trans("main_navigation"); ?></li>
                <li>
                    <a href="<?php echo admin_url(); ?>">
                        <i class="fa fa-home"></i>
                        <span><?php echo trans("home"); ?></span>
                    </a>
                </li>
                <?php if (check_user_permission('navigation')): ?>
                    <li>
                        <a href="<?php echo admin_url(); ?>navigation">
                            <i class="fa fa-th"></i>
                            <span><?php echo trans("navigation"); ?></span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (check_user_permission('pages')): ?>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-leaf"></i> <span><?php echo trans("pages"); ?></span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="<?php echo admin_url(); ?>add-page"><?php echo trans("add_page"); ?></a>
                            </li>
                            <li>
                                <a href="<?php echo admin_url(); ?>pages"><?php echo trans("pages"); ?></a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (check_user_permission('add_post')): ?>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-file"></i> <span><?php echo trans("add_post"); ?></span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="<?php echo admin_url(); ?>add-post"><?php echo trans("add_post"); ?></a>
                            </li>
                            <li>
                                <a href="<?php echo admin_url(); ?>add-video"><?php echo trans("add_video"); ?></a>
                            </li>
                            <li>
                                <a href="<?php echo admin_url(); ?>add-audio"><?php echo trans("add_audio"); ?></a>
                            </li>
                        </ul>
                    </li>

                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-bars"></i> <span><?php echo trans("posts"); ?></span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="<?php echo admin_url(); ?>posts"><?php echo trans("posts"); ?></a>
                            </li>
                            <?php if (check_user_permission('manage_all_posts')): ?>
                                <li>
                                    <a href="<?php echo admin_url(); ?>slider-posts"><?php echo trans("slider_posts"); ?></a>
                                </li>
                                <li>
                                    <a href="<?php echo admin_url(); ?>featured-posts"><?php echo trans("featured_posts"); ?></a>
                                </li>
                                <li>
                                    <a href="<?php echo admin_url(); ?>breaking-news"><?php echo trans("breaking_news"); ?></a>
                                </li>
                                <li>
                                    <a href="<?php echo admin_url(); ?>recommended-posts"><?php echo trans("recommended_posts"); ?></a>
                                </li>
                            <?php endif; ?>
                            <li>
                                <a href="<?php echo admin_url(); ?>pending-posts"><?php echo trans("pending_posts"); ?></a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="<?php echo admin_url(); ?>scheduled-posts">
                            <i class="fa fa-clock-o" aria-hidden="true"></i> <span><?php echo trans("scheduled_posts"); ?></span>
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo admin_url(); ?>drafts">
                            <i class="fa fa-file-text-o" aria-hidden="true"></i> <span><?php echo trans("drafts"); ?></span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (check_user_permission('rss_feeds')): ?>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-rss"></i> <span><?php echo trans("rss_feeds"); ?></span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="<?php echo admin_url(); ?>import-feed"><?php echo trans("import_rss_feed"); ?></a>
                            </li>
                            <li>
                                <a href="<?php echo admin_url(); ?>feeds"><?php echo trans("rss_feeds"); ?></a>
                            </li>

                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (check_user_permission('categories')): ?>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-folder-open"></i> <span><?php echo trans("categories"); ?></span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="<?php echo admin_url(); ?>categories"><?php echo trans("categories"); ?></a>
                            </li>
                            <li>
                                <a href="<?php echo admin_url(); ?>subcategories"><?php echo trans("subcategories"); ?></a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (check_user_permission('widgets')): ?>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-th"></i> <span><?php echo trans("widgets"); ?></span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="<?php echo admin_url(); ?>add-widget"><?php echo trans("add_widget"); ?></a>
                            </li>
                            <li>
                                <a href="<?php echo admin_url(); ?>widgets"><?php echo trans("widgets"); ?></a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (check_user_permission('polls')): ?>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-list"></i> <span><?php echo trans("polls"); ?></span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="<?php echo admin_url(); ?>add-poll"><?php echo trans("add_poll"); ?></a>
                            </li>
                            <li>
                                <a href="<?php echo admin_url(); ?>polls"><?php echo trans("polls"); ?></a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (check_user_permission('gallery')): ?>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-image"></i> <span><?php echo trans("gallery"); ?></span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="<?php echo admin_url(); ?>gallery-categories"><?php echo trans("categories"); ?></a>
                            </li>
                            <li>
                                <a href="<?php echo admin_url(); ?>gallery-images"><?php echo trans("images"); ?></a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (check_user_permission('comments_contact')): ?>
                    <li>
                        <a href="<?php echo admin_url(); ?>contact-messages">
                            <i class="fa fa-paper-plane" aria-hidden="true"></i>
                            <span><?php echo trans("contact_messages"); ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo admin_url(); ?>comments">
                            <i class="fa fa-comments"></i>
                            <span><?php echo trans("comments"); ?></span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (check_user_permission('newsletter')): ?>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-envelope"></i> <span><?php echo trans("newsletter"); ?></span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="<?php echo admin_url(); ?>send-email-subscribers"><?php echo trans("send_email_subscribers"); ?></a>
                            </li>
                            <li>
                                <a href="<?php echo admin_url(); ?>subscribers"><?php echo trans("subscribers"); ?></a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (check_user_permission('ad_spaces')): ?>
                    <li>
                        <a href="<?php echo admin_url(); ?>ad-spaces">
                            <i class="fa fa-dollar" aria-hidden="true"></i>
                            <span><?php echo trans("ad_spaces"); ?></span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (check_user_permission('users')): ?>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-users"></i>
                            <span><?php echo trans("users"); ?></span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <?php if (is_admin()): ?>
                                <li><a href="<?php echo admin_url(); ?>add-user"> <?php echo trans("add_user"); ?></a></li>
                                <li><a href="<?php echo admin_url(); ?>administrators"> <?php echo trans("administrators"); ?></a></li>
                            <?php endif; ?>
                            <li><a href="<?php echo admin_url(); ?>users"> <?php echo trans("users"); ?></a></li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (is_admin()): ?>
                    <li>
                        <a href="<?php echo admin_url(); ?>roles-permissions">
                            <i class="fa fa-key" aria-hidden="true"></i>
                            <span><?php echo trans("roles_permissions"); ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo admin_url(); ?>font-options"><i class="fa fa-font" aria-hidden="true"></i>
                            <span><?php echo trans("font_options"); ?></span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (check_user_permission('seo_tools')): ?>
                    <li>
                        <a href="<?php echo admin_url(); ?>seo-tools"><i class="fa fa-wrench"></i>
                            <span><?php echo trans("seo_tools"); ?></span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (is_admin()): ?>
                    <li>
                        <a href="<?php echo admin_url(); ?>social-login-configuration"><i class="fa fa-share-alt"></i>
                            <span><?php echo trans("social_login_configuration"); ?></span>
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo admin_url(); ?>cache-system">
                            <i class="fa fa-database"></i>
                            <span><?php echo trans("cache_system"); ?></span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (check_user_permission('settings')): ?>
                    <li>
                        <a href="<?php echo admin_url(); ?>preferences">
                            <i class="fa fa-check-square-o"></i>
                            <span><?php echo trans("preferences"); ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo admin_url(); ?>language-settings">
                            <i class="fa fa-language"></i>
                            <span><?php echo trans("language_settings"); ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo admin_url(); ?>visual-settings">
                            <i class="fa fa-paint-brush"></i>
                            <span><?php echo trans("visual_settings"); ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo admin_url(); ?>email-settings">
                            <i class="fa fa-cog"></i>
                            <span><?php echo trans("email_settings"); ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo admin_url(); ?>settings">
                            <i class="fa fa-cogs"></i>
                            <span><?php echo trans("settings"); ?></span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">

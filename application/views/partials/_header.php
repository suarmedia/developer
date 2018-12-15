<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Suarmedia TV</title>
    <meta name="description" content="<?php echo html_escape($description); ?>"/>
    <meta name="keywords" content="<?php echo html_escape($keywords); ?>"/>
    <meta name="author" content="Codingest"/>
    <meta property="og:locale" content="en_US"/>
    <meta property="og:site_name" content="<?php echo $settings->application_name; ?>"/>
<?php if (isset($post_type)): ?>
    <meta property="og:type" content="<?php echo $og_type; ?>"/>
    <meta property="og:title" content="<?php $og_title; ?>"/>
    <meta property="og:description" content="<?php echo $og_description; ?>"/>
    <meta property="og:url" content="<?php echo $og_url; ?>"/>
    <meta property="og:image" content="<?php echo $og_image; ?>"/>
    <meta property="og:image:width" content="<?php echo $og_width; ?>"/>
    <meta property="og:image:height" content="<?php echo $og_height; ?>"/>
    <meta property="article:author" content="<?php echo $og_author; ?>"/>
    <meta property="fb:app_id" content="<?php echo $this->general_settings->facebook_app_id; ?>"/>
<?php foreach ($og_tags as $tag): ?>
    <meta property="article:tag" content="<?php echo $tag->tag; ?>"/>
<?php endforeach; ?>
    <meta property="article:published_time" content="<?php echo $og_published_time; ?>"/>
    <meta property="article:modified_time" content="<?php echo $og_modified_time; ?>"/>
    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:site" content="@<?php echo html_escape($settings->application_name); ?>"/>
    <meta name="twitter:creator" content="@<?php echo html_escape($og_creator); ?>"/>
    <meta name="twitter:title" content="<?php echo html_escape($post->title); ?>"/>
    <meta name="twitter:description" content="<?php echo html_escape($post->summary); ?>"/>
    <meta name="twitter:image" content="<?php echo $og_image; ?>"/>
<?php else: ?>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="<?php echo html_escape($title); ?> - <?php echo html_escape($settings->site_title); ?>"/>
    <meta property="og:description" content="<?php echo html_escape($description); ?>"/>
    <meta property="og:url" content="<?php echo base_url(); ?>"/>
    <meta property="fb:app_id" content="<?php echo $this->general_settings->facebook_app_id; ?>"/>
    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:site" content="@<?php echo html_escape($settings->application_name); ?>"/>
    <meta name="twitter:title" content="<?php echo html_escape($title); ?> - <?php echo html_escape($settings->site_title); ?>"/>
    <meta name="twitter:description" content="<?php echo html_escape($description); ?>"/>
<?php endif; ?>
    <meta name="google-signin-client_id" content="<?php echo $general_settings->google_client_id ?>">
    <link rel="canonical" href="<?php echo current_url(); ?>"/>
<?php if ($general_settings->multilingual_system == 1):
foreach ($languages as $language):
if ($language->id == $site_lang->id):?>
    <link rel="alternate" href="<?php echo base_url(); ?>" hreflang="<?php echo $language->language_code ?>"/>
<?php else: ?>
    <link rel="alternate" href="<?php echo base_url() . $language->short_form . "/"; ?>" hreflang="<?php echo $language->language_code ?>"/>
<?php endif; endforeach; endif; ?>
    <link rel="shortcut icon" type="image/png" href="<?php echo get_favicon($vsettings); ?>"/>
    <!-- Font-icons CSS -->
    <link href="<?php echo base_url(); ?>assets/vendor/font-icons/css/varient.min.css" rel="stylesheet"/>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css"/>
    <?php echo $primary_font_url; ?>
    <?php echo $secondary_font_url; ?>
    <?php echo $tertiary_font_url; ?>
    <?php if (isset($post_type) && $post_type == "audio"): ?>
        <link href="<?php echo base_url(); ?>assets/vendor/audio-player/css/amplitude.min.css" rel="stylesheet"/>
    <?php endif; ?>
    <?php if (isset($post_type) && $post_type == "video"): ?>
        <link href="<?php echo base_url(); ?>assets/vendor/video-player/video-js.min.css" rel="stylesheet"/>
    <?php endif; ?>
    <!-- Plugins -->
    <link href="<?php echo base_url(); ?>assets/css/plugins.css" rel="stylesheet"/>
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/icheck/minimal/grey.css"/>
    <!-- Style -->
    <link href="<?php echo base_url(); ?>assets/css/style-1.5.1.min.css" rel="stylesheet"/>
    <!-- Color CSS -->
<?php if ($vsettings->site_color == '') : ?>
    <link href="<?php echo base_url(); ?>assets/css/colors/default.min.css" rel="stylesheet"/>
<?php else : ?>
    <link href="<?php echo base_url(); ?>assets/css/colors/<?php echo html_escape($vsettings->site_color); ?>.min.css" rel="stylesheet"/>
<?php endif; ?>
    <?php if ($selected_lang->text_direction == "rtl"): ?>
        <!-- RTL -->
    <link href="<?php echo base_url(); ?>assets/css/rtl.min.css" rel="stylesheet"/>
    <?php endif; ?>
    <!--Include Font Style-->
    <?php $this->load->view('partials/_font_style'); ?>
    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>assets/js/jquery-1.12.4.min.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?php echo $general_settings->google_analytics; ?>
    <?php echo $general_settings->head_code; ?>
<?php if ($selected_lang->text_direction == "rtl"): ?>
    <script>var rtl = true;</script>
<?php else: ?>
    <script>var rtl = false;</script>
<?php endif; ?>
</head>
<body>
<header id="header">
    <?php $this->load->view('nav/_nav_top'); ?>
    <div class="logo-banner">
        <div class="container">
            <div class="col-sm-12">
                <div class="row">
                    <div class="left">
                        <a href="<?php echo lang_base_url(); ?>">
                            <img src="<?php echo get_logo($vsettings); ?>" alt="logo" class="logo">
                        </a>
                    </div>
                    <div class="right">
                        <div class="pull-right">
                            <!--Include banner-->
                            <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "header"]); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/.container-->
    </div><!--/.top-bar-->
    <?php $this->load->view('nav/_nav_main'); ?>
    <div class="col-sm-12">
        <div class="row">
            <div class="nav-mobile">
                <div class="row">
                    <div class="col-xs-2 left">
                        <span onclick="open_mobile_nav();" class="mobile-menu-icon"><i class="icon-menu"></i> </span>
                    </div>
                    <div class="col-xs-8">
                        <div class="logo-cnt">
                            <a href="<?php echo lang_base_url(); ?>">
                                <img src="<?php echo get_logo($vsettings); ?>" alt="logo" class="logo">
                            </a>
                        </div>
                    </div>
                    <div class="col-xs-2 right">
                        <a class="search-icon"><i class="icon-search"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="mobile-nav-search">
    <div class="search-form">
        <?php echo form_open(lang_base_url() . 'search', ['method' => 'get']); ?>
        <input type="text" name="q" maxlength="300" pattern=".*\S+.*"
               class="form-control form-input"
               placeholder="<?php echo trans("placeholder_search"); ?>" required>
        <button class="btn btn-default"><i class="icon-search"></i></button>
        <?php echo form_close(); ?>
    </div>
</div>
<?php $this->load->view('nav/_nav_mobile'); ?>
<?php $this->load->view('partials/_modals'); ?>



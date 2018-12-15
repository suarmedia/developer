<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-sm-12 col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?php echo trans('preferences'); ?></h3>
                </div>
            </div><!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('admin_controller/preferences_post'); ?>
            <div class="box-body">
                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages'); ?>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-3 col-xs-12">
                            <label><?php echo trans('multilingual_system'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="multilingual_system" value="1" id="multilingual_system_1"
                                   class="square-purple" <?php echo ($general_settings->multilingual_system == 1) ? 'checked' : ''; ?>>
                            <label for="multilingual_system_1" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="multilingual_system" value="0" id="multilingual_system_2"
                                   class="square-purple" <?php echo ($general_settings->multilingual_system != 1) ? 'checked' : ''; ?>>
                            <label for="multilingual_system_2" class="option-label"><?php echo trans('disable'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-3 col-xs-12">
                            <label><?php echo trans('registration_system'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="registration_system" value="1" id="registration_system_1"
                                   class="square-purple" <?php echo ($general_settings->registration_system == 1) ? 'checked' : ''; ?>>
                            <label for="registration_system_1" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="registration_system" value="0" id="registration_system_2"
                                   class="square-purple" <?php echo ($general_settings->registration_system != 1) ? 'checked' : ''; ?>>
                            <label for="registration_system_2" class="option-label"><?php echo trans('disable'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-3 col-xs-12">
                            <label><?php echo trans('comment_system'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="comment_system" value="1" id="comment_system_1"
                                   class="square-purple" <?php echo ($general_settings->comment_system == 1) ? 'checked' : ''; ?>>
                            <label for="comment_system_1" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="comment_system" value="0" id="comment_system_2"
                                   class="square-purple" <?php echo ($general_settings->comment_system != 1) ? 'checked' : ''; ?>>
                            <label for="comment_system_2" class="option-label"><?php echo trans('disable'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-3 col-xs-12">
                            <label><?php echo trans('facebook_comments'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="facebook_comment_active" value="1" id="facebook_comment_active_1"
                                   class="square-purple" <?php echo ($general_settings->facebook_comment_active == 1) ? 'checked' : ''; ?>>
                            <label for="facebook_comment_active_1" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="facebook_comment_active" value="0" id="facebook_comment_active_2"
                                   class="square-purple" <?php echo ($general_settings->facebook_comment_active != 1) ? 'checked' : ''; ?>>
                            <label for="facebook_comment_active_2" class="option-label"><?php echo trans('disable'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-3 col-xs-12">
                            <label><?php echo trans('emoji_reactions'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="emoji_reactions_1" name="emoji_reactions" value="1" class="square-purple" checked>
                            <label for="emoji_reactions_1" class="cursor-pointer" <?php echo ($general_settings->emoji_reactions == "1") ? 'checked' : ''; ?>><?php echo trans('enable'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="emoji_reactions_2" name="emoji_reactions" value="0" class="square-purple" <?php echo ($general_settings->emoji_reactions != "1") ? 'checked' : ''; ?>>
                            <label for="emoji_reactions_2" class="cursor-pointer"><?php echo trans('disable'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-3 col-xs-12">
                            <label><?php echo trans('rss'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="show_rss_1" name="show_rss" value="1" class="square-purple" checked>
                            <label for="show_rss_1" class="cursor-pointer" <?php echo ($general_settings->show_rss == "1") ? 'checked' : ''; ?>><?php echo trans('enable'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="show_rss_2" name="show_rss" value="0" class="square-purple" <?php echo ($general_settings->show_rss != "1") ? 'checked' : ''; ?>>
                            <label for="show_rss_2" class="cursor-pointer"><?php echo trans('disable'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-3 col-xs-12">
                            <label><?php echo trans('newsletter'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="newsletter_1" name="newsletter" value="1" class="square-purple" checked>
                            <label for="newsletter_1" class="cursor-pointer" <?php echo ($general_settings->newsletter == "1") ? 'checked' : ''; ?>><?php echo trans('enable'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="newsletter_2" name="newsletter" value="0" class="square-purple" <?php echo ($general_settings->newsletter != "1") ? 'checked' : ''; ?>>
                            <label for="newsletter_2" class="cursor-pointer"><?php echo trans('disable'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-3 col-xs-12">
                            <label><?php echo trans('show_featured_section'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="show_featured_section" value="1" id="show_featured_section_1"
                                   class="square-purple" <?php echo ($general_settings->show_featured_section == 1) ? 'checked' : ''; ?>>
                            <label for="show_featured_section_1" class="option-label"><?php echo trans('yes'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="show_featured_section" value="0" id="show_featured_section_2"
                                   class="square-purple" <?php echo ($general_settings->show_featured_section != 1) ? 'checked' : ''; ?>>
                            <label for="show_featured_section_2" class="option-label"><?php echo trans('no'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-3 col-xs-12">
                            <label><?php echo trans('show_latest_posts_homepage'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="show_latest_posts" value="1" id="show_latest_posts_1"
                                   class="square-purple" <?php echo ($general_settings->show_latest_posts == 1) ? 'checked' : ''; ?>>
                            <label for="show_latest_posts_1" class="option-label"><?php echo trans('yes'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="show_latest_posts" value="0" id="show_latest_posts_2"
                                   class="square-purple" <?php echo ($general_settings->show_latest_posts != 1) ? 'checked' : ''; ?>>
                            <label for="show_latest_posts_2" class="option-label"><?php echo trans('no'); ?></label>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-3 col-xs-12">
                            <label><?php echo trans('show_news_ticker'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="show_newsticker_1" name="show_newsticker" value="1" class="square-purple" checked>
                            <label for="show_newsticker_1" class="cursor-pointer" <?php echo ($general_settings->show_newsticker == "1") ? 'checked' : ''; ?>><?php echo trans('yes'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="show_newsticker_2" name="show_newsticker" value="0" class="square-purple" <?php echo ($general_settings->show_newsticker == "0" || $general_settings->show_newsticker == null) ? 'checked' : ''; ?>>
                            <label for="show_newsticker_2" class="cursor-pointer"><?php echo trans('no'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-3 col-xs-12">
                            <label><?php echo trans('show_post_author'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="show_post_author" value="1" id="show_post_author_1"
                                   class="square-purple" <?php echo ($general_settings->show_post_author == 1) ? 'checked' : ''; ?>>
                            <label for="show_post_author_1" class="option-label"><?php echo trans('yes'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="show_post_author" value="0" id="show_post_author_2"
                                   class="square-purple" <?php echo ($general_settings->show_post_author != 1) ? 'checked' : ''; ?>>
                            <label for="show_post_author_2" class="option-label"><?php echo trans('no'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-3 col-xs-12">
                            <label><?php echo trans('show_post_dates'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="show_post_date" value="1" id="show_post_date_1"
                                   class="square-purple" <?php echo ($general_settings->show_post_date == 1) ? 'checked' : ''; ?>>
                            <label for="show_post_date_1" class="option-label"><?php echo trans('yes'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="show_post_date" value="0" id="show_post_date_2"
                                   class="square-purple" <?php echo ($general_settings->show_post_date != 1) ? 'checked' : ''; ?>>
                            <label for="show_post_date_2" class="option-label"><?php echo trans('no'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-3 col-xs-12">
                            <label><?php echo trans('show_post_view_counts'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="show_hits_1" name="show_hits" value="1" class="square-purple" checked>
                            <label for="show_hits_1" class="cursor-pointer" <?php echo ($general_settings->show_hits == "1") ? 'checked' : ''; ?>><?php echo trans('yes'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="show_hits_2" name="show_hits" value="0" class="square-purple" <?php echo ($general_settings->show_hits != "1") ? 'checked' : ''; ?>>
                            <label for="show_hits_2" class="cursor-pointer"><?php echo trans('no'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-3 col-xs-12">
                            <label><?php echo trans('approve_added_user_posts'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="approve_added_user_posts_1" name="approve_added_user_posts" value="1" class="square-purple" checked>
                            <label for="approve_added_user_posts_1" class="cursor-pointer" <?php echo ($general_settings->approve_added_user_posts == "1") ? 'checked' : ''; ?>><?php echo trans('yes'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="approve_added_user_posts_2" name="approve_added_user_posts" value="0" class="square-purple" <?php echo ($general_settings->approve_added_user_posts != "1") ? 'checked' : ''; ?>>
                            <label for="approve_added_user_posts_2" class="cursor-pointer"><?php echo trans('no'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-3 col-xs-12">
                            <label><?php echo trans('approve_updated_user_posts'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="approve_updated_user_posts_1" name="approve_updated_user_posts" value="1" class="square-purple" checked>
                            <label for="approve_updated_user_posts_1" class="cursor-pointer" <?php echo ($general_settings->approve_updated_user_posts == "1") ? 'checked' : ''; ?>><?php echo trans('yes'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="approve_updated_user_posts_2" name="approve_updated_user_posts" value="0" class="square-purple" <?php echo ($general_settings->approve_updated_user_posts != "1") ? 'checked' : ''; ?>>
                            <label for="approve_updated_user_posts_2" class="cursor-pointer"><?php echo trans('no'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-3 col-xs-12">
                            <label><?php echo trans('file_manager'); ?></label>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="file_manager_show_files_1" name="file_manager_show_files" value="1" class="square-purple" checked>
                            <label for="file_manager_show_files_1" class="cursor-pointer" <?php echo ($general_settings->file_manager_show_files == "1") ? 'checked' : ''; ?>><?php echo trans('show_all_files'); ?></label>
                        </div>
                        <div class="col-md-5 col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="file_manager_show_files_2" name="file_manager_show_files" value="0" class="square-purple" <?php echo ($general_settings->file_manager_show_files != "1") ? 'checked' : ''; ?>>
                            <label for="file_manager_show_files_2" class="cursor-pointer"><?php echo trans('show_only_own_files'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-3 col-xs-12">
                            <label class="control-label"><?php echo trans('pagination_number_posts'); ?></label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <input type="number" class="form-control" name="pagination_per_page" value="<?php echo html_escape($general_settings->pagination_per_page); ?>" min="0" required style="max-width: 450px;">
                        </div>
                    </div>
                </div>

                <?php require APPPATH . "config/route_slugs.php"; ?>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-3 col-xs-12">
                            <label class="control-label"><?php echo trans('admin_panel_link'); ?></label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <input type="text" class="form-control" name="admin_panel_link" value="<?php echo (isset($custom_slug_array["admin"])) ? $custom_slug_array["admin"] : 'admin'; ?>" required style="max-width: 450px;">
                        </div>
                    </div>
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


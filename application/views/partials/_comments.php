<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

    <div class="section-content">
        <div class="comments">
            <div class="row">
                <div class="col-sm-12 comments-body">

                    <ul class="comment-lists">

                        <?php foreach ($comments as $item) : ?>
                            <?php if (!is_null(get_user($item->user_id))) : ?>
                                <li>
                                    <div class="comment-left">
                                        <img src="<?php echo get_user_avatar_by_id($item->user_id); ?>" alt="user" class="img-responsive">
                                    </div><!--/comment-left -->

                                    <div class="comment-right">
                                        <h5 class="user-name"><?php echo html_escape($item->username); ?></h5>
                                        <p class="comment-text"><?php echo html_escape($item->comment); ?></p>
                                        <div class="comment-meta">
                                            <small class="comment-date"><?php echo time_ago($item->created_at); ?></small>

                                            <!--Check login-->
                                            <?php if (auth_check()): ?>
                                                <button class="btn-comment-reply"
                                                        onclick="return show_sub_comment_box('<?php echo $item->id; ?>');">
                                                    <i class="icon-reply"></i>&nbsp;
                                                    <?php echo html_escape(trans("btn_reply")); ?>
                                                </button>

                                                <button class="btn-comment-like" onclick="like_comment('<?php echo $item->id; ?>');">
                                                    <i class="icon-thumbs-up" aria-hidden="true"></i>&nbsp;
                                                    <?php echo html_escape(trans("btn_like")); ?>&nbsp;(<?php echo get_comment_like_count($item->id); ?>)
                                                </button>

                                                <?php if (user()->id == $item->user_id): ?>
                                                    <button type="button"
                                                            onclick="delete_comment('<?php echo $item->id; ?>','<?php echo html_escape(trans("message_comment_delete")); ?>');"
                                                            class="btn-comment-delete">
                                                        <i class="icon-trash"></i>&nbsp;
                                                        <?php echo html_escape(trans("btn_delete")); ?>
                                                    </button>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <button class="btn-comment-reply" data-toggle="modal" data-target="#modal-login">
                                                    <i class="icon-reply"></i>&nbsp;
                                                    <?php echo html_escape(trans("btn_reply")); ?>
                                                </button>

                                                <button class="btn-comment-like" data-toggle="modal" data-target="#modal-login">
                                                    <i class="icon-thumbs-up" aria-hidden="true"></i> &nbsp;(<?php echo get_comment_like_count($item->id); ?>)
                                                </button>
                                            <?php endif; ?>
                                        </div>


                                        <?php if (auth_check()): ?>
                                            <!-- make sub comment block -->
                                            <div id="sub_comment_<?php echo $item->id; ?>"
                                                 class="col-sm-12 leave-reply-body leave-reply-sub-body">
                                                <div class="row">

                                                    <!-- form make  subcomment -->
                                                    <form method="post">
                                                        <input type="hidden" id="comment_parent_id_<?php echo $item->id; ?>" value="<?php echo $item->id; ?>">
                                                        <input type="hidden" id="comment_post_id_<?php echo $item->id; ?>" value="<?php echo $item->post_id; ?>">
                                                        <input type="hidden" id="comment_user_id_<?php echo $item->id; ?>" value="<?php echo user()->id; ?>">
                                                        <div class="form-group">
                                    <textarea class="form-control form-input form-textarea form-textarea-sub" name="comment" id="comment_text_<?php echo $item->id; ?>"
                                              placeholder="<?php echo html_escape(trans("leave_reply")); ?>"
                                              maxlength="4999"></textarea>

                                                            <button type="button" onclick="return make_sub_comment('<?php echo $item->id; ?>')"
                                                                    class="btn btn-sm btn-custom pull-right">
                                                                <?php echo html_escape(trans("btn_submit")); ?>
                                                            </button>
                                                        </div>

                                                    </form><!-- form end -->

                                                </div>
                                            </div> <!--/make sub comment block -->
                                        <?php endif; ?>

                                        <!--Print sub comments-->
                                        <?php foreach (get_subcomments($item->id) as $sub_comment) : ?>
                                            <?php if (!is_null(get_user($sub_comment->user_id))): ?>
                                                <div class="item-sub-comment">

                                                    <div class="comment-left">
                                                        <img src="<?php echo get_user_avatar_by_id($sub_comment->user_id); ?>" alt="user" class="img-responsive">
                                                    </div><!--/comment-left -->

                                                    <div class="comment-right">
                                                        <h5 class="user-name"><?php echo html_escape($sub_comment->username); ?></h5>
                                                        <p class="comment-text"><?php echo html_escape($sub_comment->comment); ?></p>
                                                        <div class="comment-meta">
                                                            <small class="comment-date"><?php echo time_ago($sub_comment->created_at); ?></small>

                                                            <?php if (auth_check()): ?>
                                                                <button class="btn-comment-like" onclick="like_comment('<?php echo $sub_comment->id; ?>');">
                                                                    <i class="icon-thumbs-up" aria-hidden="true"></i>
                                                                    &nbsp;<?php echo html_escape(trans("btn_like")); ?>&nbsp;(<?php echo get_comment_like_count($sub_comment->id); ?>)
                                                                </button>

                                                                <?php if (user()->id == $sub_comment->user_id): ?>
                                                                    <button type="button"
                                                                            onclick="delete_comment( '<?php echo $sub_comment->id; ?>','<?php echo html_escape(trans("message_comment_delete")); ?>');"
                                                                            class="btn-comment-delete">
                                                                        <i class="icon-trash"></i>&nbsp;
                                                                        <?php echo html_escape(trans("btn_delete")); ?>
                                                                    </button>
                                                                <?php endif; ?>
                                                            <?php else: ?>
                                                                <button class="btn-comment-like" data-toggle="modal" data-target="#modal-login">
                                                                    <i class="icon-thumbs-up" aria-hidden="true"></i>
                                                                    &nbsp;<?php echo html_escape(trans("btn_like")); ?>&nbsp;(<?php echo get_comment_like_count($sub_comment->id); ?>)
                                                                </button>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div><!--/comment-right -->

                                                </div><!--/row -->
                                            <?php endif; ?>
                                        <?php endforeach; ?>

                                    </div><!--/item-sub-comment -->
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>

                </div>
            </div>
        </div>
    </div>


<?php if ($vr_comment_limit < get_post_comment_count($comment_post_id)): ?>

    <div id="load_comments_spinner" class="col-sm-12 col-xs-12 load-more-spinner">
        <div class="row">
            <div class="spinner">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </div>
    </div>

    <div class="col-sm-12 col-xs-12">
        <div class="row">
            <button class="btn-load-more" onclick="load_more_comments('<?php echo $comment_post_id; ?>');">
                <?php echo trans("load_more"); ?>
            </button>
        </div>
    </div>

<?php endif; ?>
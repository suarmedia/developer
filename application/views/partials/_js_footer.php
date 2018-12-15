<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
    <script>
        jQuery(document).ready(function () {
            //main slider
            $("#featured-slider").owlCarousel({
                autoplay: true,
                loop: true,
                rtl: rtl,
                lazyLoad: true,
                slideSpeed: 3000,
                paginationSpeed: 1000,
                items: 1,
                dots: false,
                nav: true,
                navText: ["<i class='icon-arrow-slider-left random-arrow-prev' aria-hidden='true'></i>", "<i class='icon-arrow-slider-right random-arrow-next' aria-hidden='true'></i>"],
                itemsDesktop: false,
                itemsDesktopSmall: false,
                itemsTablet: false,
                itemsMobile: false,
                onInitialize: function (a) {
                    if ($("#owl-random-post-slider .item").length <= 1) {
                        this.settings.loop = false
                    }
                },
            });

            //random slider
            $("#random-slider").owlCarousel({
                autoplay: true,
                loop: true,
                rtl: rtl,
                lazyLoad: true,
                slideSpeed: 3000,
                paginationSpeed: 1000,
                items: 1,
                dots: false,
                nav: true,
                navText: ["<i class='icon-arrow-left post-detail-arrow-prev' aria-hidden='true'></i>", "<i class='icon-arrow-right post-detail-arrow-next' aria-hidden='true'></i>"],
                itemsDesktop: false,
                itemsDesktopSmall: false,
                itemsTablet: false,
                itemsMobile: false,
                onInitialize: function (a) {
                    if ($("#owl-random-post-slider .item").length <= 1) {
                        this.settings.loop = false
                    }
                },
            });

            $(".main-menu .dropdown").hover(function () {
                $(".li-sub-category").removeClass("active");
                $(".sub-menu-inner").removeClass("active");
                $(".sub-menu-right .filter-all").addClass("active")
            }, function () {
            });
            $(".main-menu .navbar-nav .dropdown-menu").hover(function () {
                var a = $(this).attr("data-mega-ul");
                if (a != undefined) {
                    $(".main-menu .navbar-nav .dropdown").removeClass("active");
                    $(".mega-li-" + a).addClass("active")
                }
            }, function () {
                $(".main-menu .navbar-nav .dropdown").removeClass("active")
            });
            $(".li-sub-category").hover(function () {
                var a = $(this).attr("data-category-filter");
                $(".li-sub-category").removeClass("active");
                $(this).addClass("active");
                $(".sub-menu-right .sub-menu-inner").removeClass("active");
                $(".sub-menu-right .filter-" + a).addClass("active")
            }, function () {
            });
            $(".news-ticker ul li").delay(500).fadeIn(500);
            $(".news-ticker").easyTicker({direction: "up", easing: "swing", speed: "fast", interval: 4000, height: "30", visible: 0, mousePause: 1, controls: {up: ".news-next", down: ".news-prev",}});
            $(window).scroll(function () {
                if ($(this).scrollTop() > 100) {
                    $(".scrollup").fadeIn()
                } else {
                    $(".scrollup").fadeOut()
                }
            });
            $(".scrollup").click(function () {
                $("html, body").animate({scrollTop: 0}, 700);
                return false
            });
            $("form").submit(function () {
                $("input[name='" + csfr_token_name + "']").val($.cookie(csfr_cookie_name))
            });
            $(document).ready(function () {
                $('[data-toggle-tool="tooltip"]').tooltip()
            })
        });
        $("#form_validate").validate();
        $("#search_validate").validate();
        $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({checkboxClass: "icheckbox_minimal-grey", radioClass: "iradio_minimal-grey", increaseArea: "20%"});
        //post slider
        $(window).load(function () {
            $("#post-detail-slider").owlCarousel({
                navigation: true,
                rtl: rtl,
                slideSpeed: 3000,
                paginationSpeed: 1000,
                items: 1,
                dots: false,
                nav: true,
                autoHeight: true,
                navText: ["<i class='icon-arrow-left post-detail-arrow-prev' aria-hidden='true'></i>", "<i class='icon-arrow-right post-detail-arrow-next' aria-hidden='true'></i>"],
                itemsDesktop: false,
                itemsDesktopSmall: false,
                itemsTablet: false,
                itemsMobile: false,
                onInitialize: function (a) {
                    if ($("#owl-random-post-slider .item").length <= 1) {
                        this.settings.loop = false
                    }
                },
            })
        });

        //show on page load
        $(window).load(function () {
            $(".show-on-page-load").css("visibility", "visible")
        });

        //full screen
        $(document).ready(function () {
            $("iframe").attr("allowfullscreen", "")
        });
        //custom scrollbar
        var custom_scrollbar = $('.custom-scrollbar');
        if (custom_scrollbar.length) {
            var ps = new PerfectScrollbar('.custom-scrollbar', {
                wheelPropagation: true,
                suppressScrollX: true
            });
        }

        //custom scrollbar
        var custom_scrollbar = $('.custom-scrollbar-followers');
        if (custom_scrollbar.length) {
            var ps = new PerfectScrollbar('.custom-scrollbar-followers', {
                wheelPropagation: true,
                suppressScrollX: true
            });
        }

        //search
        $(".search-icon").click(function () {
            if ($(".search-form").hasClass("open")) {
                $(".search-form").removeClass("open");
                $(".search-icon i").removeClass("icon-times");
                $(".search-icon i").addClass("icon-search")
            } else {
                $(".search-form").addClass("open");
                $(".search-icon i").removeClass("icon-search");
                $(".search-icon i").addClass("icon-times")
            }
        });

        //login form
        $(document).ready(function () {
            var a;
            $("#form-login").submit(function (d) {
                d.preventDefault();
                if (a) {
                    a.abort()
                }
                var b = $(this);
                var c = b.find("input, select, button, textarea");
                var e = b.serializeArray();
                e.push({name: csfr_token_name, value: $.cookie(csfr_cookie_name)});
                a = $.ajax({url: base_url + "auth_controller/login_post", type: "post", data: e,});
                a.done(function (f) {
                    c.prop("disabled", false);
                    if (f == "success") {
                        location.reload()
                    } else if (f.indexOf("<div class=\"error-message\">") >= 0) {
                        document.getElementById("result-login").innerHTML = f
                    }
                })
            })
        });


        //make reaction
        function make_reaction(post_id, reaction, lang) {
            var data = {
                post_id: post_id,
                reaction: reaction,
                lang: lang
            };
            data[csfr_token_name] = $.cookie(csfr_cookie_name);
            $.ajax({
                method: "POST",
                url: base_url + "home_controller/save_reaction",
                data: data
            }).done(function (response) {
                document.getElementById("reactions_result").innerHTML = response
            })
        }

        //make comment
        $(document).ready(function () {
            var a;
            $("#make-comment").submit(function (e) {
                e.preventDefault();
                var d = $("#parent-comment-text").val();
                d = $.trim(d);
                if (d.length < 2) {
                    $("#parent-comment-text").addClass("comment-error");
                    return false
                }
                if (a) {
                    a.abort()
                }
                var b = $(this);
                var c = b.find("input, select, button, textarea");
                var f = parseInt($("#vr_comment_limit").val());
                var g = b.serializeArray();
                g.push({name: csfr_token_name, value: $.cookie(csfr_cookie_name)});
                g.push({name: "limit", value: f});
                c.prop("disabled", true);
                a = $.ajax({url: base_url + "home_controller/add_comment_post", type: "post", data: g,});
                a.done(function (h) {
                    c.prop("disabled", false);
                    $("#make-comment textarea").val("");
                    document.getElementById("comment-result").innerHTML = h
                })
            })
        });

        //show subcomment box
        function show_sub_comment_box(a) {
            if (a) {
                $(".leave-reply-sub-body").hide();
                if ($("#sub_comment_" + a).is(":visible")) {
                    $(".leave-reply-sub-body").hide()
                } else {
                    $("#sub_comment_" + a).show()
                }
            }
        }

        //make subcomment
        function make_sub_comment(d) {
            var a = $("#comment_text_" + d).val();
            var e = $("#comment_post_id_" + d).val();
            var f = $("#comment_user_id_" + d).val();
            if (a && e && f && d) {
                var c = parseInt($("#vr_comment_limit").val());
                var b = {comment: a, post_id: e, user_id: f, parent_id: d, limit: c,};
                b[csfr_token_name] = $.cookie(csfr_cookie_name);
                $("#comment_text_" + d).prop("disabled", true);
                $.ajax({method: "POST", url: base_url + "home_controller/add_comment_post", data: b}).done(function (g) {
                    $("#comment_text_" + d).val("");
                    $("#comment_text_" + d).prop("disabled", false);
                    document.getElementById("comment-result").innerHTML = g;
                    $(".leave-reply").show()
                })
            } else {
                $("#comment_text_" + d).addClass("comment-error")
            }
            return false
        }

        //delete comment
        function delete_comment(id, message) {
            swal({
                text: message,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then(function (willDelete) {
                if (willDelete) {
                    var limit = parseInt($("#vr_comment_limit").val());
                    var data = {
                        'id': id,
                        'limit': limit
                    };
                    data[csfr_token_name] = $.cookie(csfr_cookie_name);
                    $.ajax({
                        type: "POST",
                        url: base_url + "home_controller/delete_comment_post",
                        data: data,
                        success: function (response) {
                            document.getElementById("comment-result").innerHTML = response;
                        }
                    });
                }
            });
        };

        //like comment
        function like_comment(a) {
            var c = parseInt($("#vr_comment_limit").val());
            var b = {id: a, limit: c,};
            b[csfr_token_name] = $.cookie(csfr_cookie_name);
            $.ajax({method: "POST", url: base_url + "home_controller/like_comment_post", data: b}).done(function (d) {
                document.getElementById("comment-result").innerHTML = d
            })
        }

        //view poll results
        function view_poll_results(a) {
            $("#poll_" + a + " .question").hide();
            $("#poll_" + a + " .result").show()
        }

        //view poll option
        function view_poll_options(a) {
            $("#poll_" + a + " .result").hide();
            $("#poll_" + a + " .question").show()
        }

        //poll
        $(document).ready(function () {
            var a;
            $(".poll-form").submit(function (d) {
                d.preventDefault();
                if (a) {
                    a.abort()
                }
                var b = $(this);
                var c = b.find("input, select, button, textarea");
                var f = b.serializeArray();
                f.push({name: csfr_token_name, value: $.cookie(csfr_cookie_name)});
                var e = $(this).attr("data-form-id");
                a = $.ajax({url: base_url + "home_controller/add_vote", type: "post", data: f,});
                a.done(function (g) {
                    c.prop("disabled", false);
                    if (g == "required") {
                        $("#poll-required-message-" + e).show();
                        $("#poll-error-message-" + e).hide();
                    }
                    else if (g == "voted") {
                        $("#poll-required-message-" + e).hide();
                        $("#poll-error-message-" + e).show();
                    } else {
                        document.getElementById("poll-results-" + e).innerHTML = g;
                        $("#poll_" + e + " .result").show();
                        $("#poll_" + e + " .question").hide()
                    }
                })
            })
        });

        //mobile nav
        function open_mobile_nav() {
            document.getElementById("mobile-menu").style.width = "100%"
        }

        //mobile nav
        function close_mobile_nav() {
            document.getElementById("mobile-menu").style.width = "0"
        }

        //close menu
        $(".close-menu-click").click(function () {
            document.getElementById("mobile-menu").style.width = "0"
        });

        //add remove reading list
        function add_delete_from_reading_list(b) {
            $(".tooltip").hide();
            var a = {post_id: b,};
            a[csfr_token_name] = $.cookie(csfr_cookie_name);
            $.ajax({method: "POST", url: base_url + "home_controller/add_delete_reading_list_post", data: a}).done(function (c) {
                location.reload()
            })
        }

        //load more posts
        function load_more_posts() {
            $(".btn-load-more").prop("disabled", true);
            var a = {
                'visible_posts_count': $("#index_visible_posts_count").val()
            };
            a[csfr_token_name] = $.cookie(csfr_cookie_name);
            $("#load_posts_spinner").show();
            $.ajax({method: "POST", url: base_url + "home_controller/load_more_posts", data: a}).done(function (b) {
                setTimeout(function () {
                    $("#load_posts_spinner").hide();
                    $("#last_posts_content").append(b);
                    $(".btn-load-more").prop("disabled", false)
                }, 500);

                var x = parseInt($("#index_visible_posts_count").val());
                $("#index_visible_posts_count").val((x + 6).toString());
            })
        }

        //load more comments
        function load_more_comments(c) {
            var b = parseInt($("#vr_comment_limit").val());
            var a = {post_id: c, limit: b,};
            a[csfr_token_name] = $.cookie(csfr_cookie_name);
            $("#load_comments_spinner").show();
            $.ajax({method: "POST", url: base_url + "home_controller/load_more_comments", data: a}).done(function (d) {
                setTimeout(function () {
                    $("#load_comments_spinner").hide();
                    $("#vr_comment_limit").val(b + 5);
                    document.getElementById("comment-result").innerHTML = d
                }, 500)
            })
        }

        //hide cookies warning
        function hide_cookies_warning() {
            $(".cookies-warning").hide();
            var data = {};
            data[csfr_token_name] = $.cookie(csfr_cookie_name);
            $.ajax({
                type: "POST",
                url: base_url + "home_controller/cookies_warning",
                data: data,
                success: function (response) {
                }
            });
        }

        //print
        $("#print_post").on("click", function () {
            $(".post-content .title, .post-content .post-meta, .post-content .post-image, .post-content .post-text").printThis({importCSS: true,})
        });
        //on ajax stop
        $(document).ajaxStop(function () {
            function b(c) {
                $("#poll_" + c + " .question").hide();
                $("#poll_" + c + " .result").show()
            }

            function a(c) {
                $("#poll_" + c + " .result").hide();
                $("#poll_" + c + " .question").show()
            }
        });
    </script>
<?php if (uri_string() == "gallery"): ?>
    <!-- Gallery -->
    <script src="<?php echo base_url(); ?>assets/vendor/masonry-filter/imagesloaded.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/masonry-filter/masonry-3.1.4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/masonry-filter/masonry.filter.js"></script>
    <script>
        $(document).ready(function (b) {
            b(".image-popup").magnificPopup({
                type: "image", titleSrc: function (a) {
                    return a.el.attr("title") + "<small></small>"
                }, image: {verticalFit: true,}, gallery: {enabled: true, navigateByImgClick: true, preload: [0, 1]}, removalDelay: 100, fixedContentPos: true,
            })
        });
        $(document).ready(function (b) {
            b(".image-popup-no-title").magnificPopup({type: "image", image: {verticalFit: true,}, gallery: {enabled: false, navigateByImgClick: true, preload: [0, 1]}, removalDelay: 100, fixedContentPos: true,})
        });
        $(document).ready(function (b) {
            b(".single-image-popup").magnificPopup({
                type: "image", titleSrc: function (a) {
                    return a.el.attr("title") + "<small></small>"
                }, image: {verticalFit: true,}, gallery: {enabled: false, navigateByImgClick: true, preload: [0, 1]}, removalDelay: 100, fixedContentPos: true,
            })
        });
        $(document).ready(function () {
            $(".filters .btn").click(function () {
                $(".filters .btn").removeClass("active");
                $(this).addClass("active")
            });
            $(function () {
                var b = $("#masonry");
                b.imagesLoaded(function () {
                    b.masonry({gutterWidth: 0, isAnimated: true, itemSelector: ".gallery-item"})
                });
                $(".filters .btn").click(function (a) {
                    a.preventDefault();
                    var d = $(this).attr("data-filter");
                    b.masonryFilter({
                        filter: function () {
                            if (!d) {
                                return true
                            }
                            return $(this).attr("data-filter") == d
                        }
                    })
                })
            })
        });
    </script>
<?php endif; ?>
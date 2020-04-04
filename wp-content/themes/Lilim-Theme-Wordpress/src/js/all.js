$.rika_js = function () {
    var methods = {
        init: function () {
            var postContent = $('#post .column--invisible .post--item');
            methods.triggerSearch(), methods.triggerMenu(), methods.triggerSubmenu(), methods.initial(postContent), methods.placeToolbar(960, 60, 20), methods.ajaxPostLoading(), methods.responsiveColumn(postContent), methods.menuScroll(), methods.upperDownClick(), methods.toolBarPlace(), methods.tagPost(), methods.ScrollMenuMobile(), methods.rippleEffect(), methods.filledField(), methods.toggleDarkThemeCookie();
        },
        triggerSearch: function () {
            $('.js-search').on('click', function () {
                $('.header__search').addClass('show');
                $('.overlay-content').addClass('show');
            });
            $('.header__search__close').on('click', function () {
                $('.header__search').removeClass('show');
                $('.overlay-content').removeClass('show');
            });
            $('.overlay-content').on('click', function () {
                $('.header__search').removeClass('show');
                $('.overlay-content').removeClass('show');
            });
        },
        triggerMenu: function () {
            $('.wrapper').on('click', function () {
                $('body').removeClass('nav-sidebar-open');
            });
            $('.nav-main').on('click', function (e) {
                e.stopPropagation();
            });
            $('.js-nav-main').on('click', function () {
                $('body').toggleClass('nav-sidebar-open');
                return false;
            });
        },
        triggerSubmenu: function () {
            $('li.menu-item-has-children a').on('click', function (e) {
                e.stopPropagation();
                $(this).siblings('.sub-menu').slideToggle();
            });
        },
        initial: function (items) {
            this.adjustColumnHeights(items);
            $('.column--post').addClass('stop--sliding');
            setTimeout(function () {
                $('.pageload-overlay').removeClass('show');
                $('.container').removeClass('fading');
            }, 150);
            if (Cookies.get('style_view_page')) {
                $('#version-color').prop('checked',true);
            }

        },
        ajaxPostLoading: function () {
            var button = $('#post .load-more');
            var page = 2;
            var currentCat = button.data('category');
            var currentTag = button.data('tag');

            $('.button--load-more').on('click', function () {
                $.ajax({
                    url: lilimajax.ajax_url,
                    type: 'post',
                    data: {
                        action: 'ajax_pagination',
                        query: lilimajax.query,
                        page: page,
                        currentCat: currentCat,
                        currentTag: currentTag
                    },
                    beforeSend: function () {
                        $('.load-more .button--load-more').hide();
                        $('.load-more .button--loading').show();
                    },
                    success: function (html) {
                        if (html.data == '') {
                            $('.load-more .button--load-more').show();
                            $('.load-more .button--loading').hide();
                        } else {
                            $('#post .column--invisible').append(html.data);
                            $('#post').append(button);
                            page = page + 1;
                            $('.wp-post-image').on('load', function () {
                                methods.adjustColumnHeights($('#post .column--invisible .post--item'));
                                methods.responsiveColumn($('#post .column--invisible .post--item'));
                                $('.load-more .button--load-more').show();
                                $('.load-more .button--loading').hide();
                            });
                        }
                    }
                });
            });
        },
        responsiveColumn: function (items) {
            $(window).resize(function (o) {
                var resize = true;
                methods.adjustColumnHeights(items, resize);
            });
        },
        adjustColumnHeights: function (items, flag) {
            if (!flag || typeof flag === "undefined") {
                flag = false;
            }
            if (flag) {
                $('.column--one').empty();
                $('.column--two').empty();
                $('.column--three').empty();
            }
            var newItems = items.clone();
            var columns = [];
            var getViewportWidth = function () {
                return Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
            };
            var gridLagerBreakpoint = 1420;
            var gridSmallBreakpoint = 768;
            columns.push($('.column--one'));
            if (getViewportWidth() >= gridSmallBreakpoint) {
                columns.push($('.column--two'));
            }
            if (getViewportWidth() >= gridLagerBreakpoint) {
                columns.push($('.column--three'));
            }
            for (var i = 0; i < newItems.length; i++) {
                if (!newItems.eq(i).hasClass('post--added') && !flag) {
                    items.eq(i).addClass('post--added');
                    this.getTargetColumn(columns).append(newItems.eq(i).removeClass('post--added'));
                } else if (flag) {
                    this.getTargetColumn(columns).append(newItems.eq(i).removeClass('post--added'));
                }
            }
        },
        getTargetColumn: function (columnList) {
            var currentBestHeight = Number.MAX_VALUE;
            for (var i = 0; i < columnList.length; i++) {
                if (columnList[i].outerHeight() < currentBestHeight) {
                    var bestColumn = columnList[i];
                    currentBestHeight = columnList[i].outerHeight();
                }
            }
            return bestColumn;
        },

        tagPost: function () {
            $(document).on('mouseenter', '.tag ul > li:first-child', function (event) {
                event.stopPropagation();
                $(this).parents('ul').addClass('show');
            });
            $(document).on('click', '.tag ul > li', function (event) {
                event.stopPropagation();
            });
            $(document).on('mouseleave', '.tag ul', function (event) {
                event.stopPropagation();
                $(this).removeClass('show');
            });
        },

        placeToolbar: function (wrap, a, b) {
            var loli = parseInt(($(window).width() - wrap + 1) / 2 - a - b);
            if (loli < 20) {
                loli = 20;
            }
            $('.right-toolbar').css({
                right: loli,
                opacity: 1
            });
        },
        menuScroll: function () {
            $(window).scroll(function (event) {
                event.stopPropagation();
                var scrollTop = $(window).scrollTop();
                if (scrollTop > 69) {
                    $('header.header').addClass('header--fixed');
                } else {
                    $('header.header').removeClass('header--fixed');
                }
            })
        },
        toolBarPlace: function () {
            var arrivedAtBottom = false;
            $(window).scroll(function (event) {
                event.stopPropagation();
                arrivedAtBottom = $(window).scrollTop() >= $(document).height() - $(window).height();
                if (arrivedAtBottom) {
                    $('.tooltip-goto').find('.icon-vertical_align_bottom').hide();
                    $('.tooltip-goto').find('.icon-vertical_align_top').show();
                } else {
                    $('.tooltip-goto').find('.icon-vertical_align_top').hide();
                    $('.tooltip-goto').find('.icon-vertical_align_bottom').show();
                }
            })
        },
        upperDownClick: function () {
            $(document).on('click', '.right-toolbar .icon-vertical_align_top', function () {
                $('html, body').animate({scrollTop: 0}, 500);
            });
            $(document).on('click', '.right-toolbar .icon-vertical_align_bottom', function () {
                $('html, body').animate({scrollTop: $('#page-wrap').height()}, 500);
            });
            $(document).on('click', '.right-toolbar .icon-question_answer', function () {
                $('html, body').animate({scrollTop: $('#respond').position().top}, 500);
            });
            $(document).on('click', '.right-toolbar .icon-bubble_chart', function () {
                $('html, body').animate({scrollTop: $('.share').position().top}, 500);
            });
        },
        ScrollMenuMobile: function () {
            setTimeout(function () {
                $('.wrapper-nav').css('height', $(window).height() + 'px')
            }, 500)
            $(window).resize(function () {
                setTimeout(function () {
                    $('.wrapper-nav').css('height', $(window).height() + 'px')
                }, 500)
            });
        },
        setCookie: function (o, e) {
            var i = new Date;
            i.setTime(i.getTime() + 31536e6), document.cookie = o + '=' + e + ';path=/;expires=' + i.toUTCString()
        },
        rippleEffect: function () {
            var $ripple = $('.rika-ripple');

            $ripple.on('click.ui.ripple', function (e) {

                var $this = $(this);
                var $offset = $this.parent().offset();
                var $circle = $this.find('.c-ripple__circle');

                var x = e.pageX - $offset.left;
                var y = e.pageY - $offset.top;

                $circle.css({
                    top: y + 'px',
                    left: x + 'px'
                });

                $this.addClass('is-active');

            });

            $ripple.on('animationend webkitAnimationEnd oanimationend MSAnimationEnd', function (e) {
                $(this).removeClass('is-active');
            });
        },
        filledField: function () {
            var $field = $('.rika-textfield');

            $field.on('change', function () {
                if ($(this).children('input').val()) {
                    if (!$(this).children('input').hasClass('is-filled')) {
                        $(this).children('input').addClass('is-filled');
                    }
                } else {
                    if ($(this).children('input').hasClass('is-filled')) {
                        $(this).children('input').removeClass('is-filled');
                    }
                }
            });
        },
        toggleDarkThemeCookie: function () {
            $('.js-dark').on('click touch', function () {
                $('body').toggleClass('theme-dark');
                if (Cookies.get('style_view_page')) {
                    Cookies.remove('style_view_page');
                    $('.box-version-text').text('Activate dark option');
                } else {
                    Cookies.set('style_view_page', 'theme-dark');
                    $('.box-version-text').text('Activate light option');
                }
            })
        }
    };
    methods.init();
};


function grin(tag) {
    var myField;
    tag = ' ' + tag + ' ';
    if (document.getElementById('comment') && document.getElementById('comment').type == 'textarea') {
        myField = document.getElementById('comment')
    } else {
        return false
    }
    if (document.selection) {
        myField.focus();
        var sel = document.selection.createRange();
        sel.text = tag;
        myField.focus()
    } else if (myField.selectionStart || myField.selectionStart == '0') {
        var startPos = myField.selectionStart;
        var endPos = myField.selectionEnd;
        var cursorPos = endPos;
        myField.value = myField.value.substring(0, startPos) + tag + myField.value.substring(endPos, myField.value.length);
        cursorPos += tag.length;
        myField.focus();
        myField.selectionStart = cursorPos;
        myField.selectionEnd = cursorPos
    } else {
        myField.value += tag;
        myField.focus()
    }
}


$(function () {
    $.rika_js();
});

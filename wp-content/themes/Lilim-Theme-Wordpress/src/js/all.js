jQuery.rika_js = function () {
    var methods = {
        init: function () {
            var postContent = jQuery('#post .column--invisible .post--item');
            methods.triggerSearch(), methods.triggerMenu(), methods.triggerSubmenu(), methods.initial(postContent), methods.placeToolbar(960, 60, 20), methods.ajaxPostLoading(), methods.responsiveColumn(postContent), methods.menuScroll(), methods.upperDownClick(), methods.toolBarPlace(), methods.tagPost(), methods.ScrollMenuMobile(), methods.rippleEffect(), methods.filledField();
        },
        triggerSearch: function () {
            jQuery('.js-search').on('click', function () {
                jQuery('.header__search').addClass('show');
                jQuery('.overlay-content').addClass('show');
            });
            jQuery('.header__search__close').on('click', function () {
                jQuery('.header__search').removeClass('show');
                jQuery('.overlay-content').removeClass('show');
            });
            jQuery('.overlay-content').on('click', function () {
                jQuery('.header__search').removeClass('show');
                jQuery('.overlay-content').removeClass('show');
            });
        },
        triggerMenu: function () {
            jQuery('.wrapper').on('click', function () {
                jQuery('body').removeClass('nav-sidebar-open');
            });
            jQuery('.nav-main').on('click', function (e) {
                e.stopPropagation();
            });
            jQuery('.js-nav-main').on('click', function () {
                jQuery('body').toggleClass('nav-sidebar-open');
                return false;
            });
        },
        triggerSubmenu: function () {
            jQuery('li.menu-item-has-children a').on('click', function (e) {
                e.stopPropagation();
                jQuery(this).siblings('.sub-menu').slideToggle();
            });
        },
        initial: function (items) {
            this.adjustColumnHeights(items);
            jQuery('.column--post').addClass('stop--sliding');
            setTimeout(function () {
                jQuery('.pageload-overlay').removeClass('show');
                jQuery('.container').removeClass('fading');
            }, 150);

        },
        ajaxPostLoading: function () {
            var button = jQuery('#post .load-more');
            var page = 2;
            var currentCat = button.data('category');
            var currentTag = button.data('tag');

            jQuery('.button--load-more').on('click', function () {
                jQuery.ajax({
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
                        jQuery('.load-more .button--load-more').hide();
                        jQuery('.load-more .button--loading').show();
                    },
                    success: function (html) {
                        if (html.data == '') {
                            jQuery('.load-more .button--load-more').show();
                            jQuery('.load-more .button--loading').hide();
                        } else {
                            jQuery('#post .column--invisible').append(html.data);
                            jQuery('#post').append(button);
                            page = page + 1;
                            methods.adjustColumnHeights(jQuery('#post .column--invisible .post--item'));
                            methods.responsiveColumn(jQuery('#post .column--invisible .post--item'));
                            jQuery('.load-more .button--load-more').show();
                            jQuery('.load-more .button--loading').hide();
                        }
                    }
                });
            });
        },
        responsiveColumn: function (items) {
            jQuery(window).resize(function (o) {
                var resize = true;
                methods.adjustColumnHeights(items, resize);
            });
        },
        adjustColumnHeights: function (items, flag) {
            if (!flag || typeof flag === "undefined") {
                flag = false;
            }
            if (flag) {
                jQuery('.column--one').empty();
                jQuery('.column--two').empty();
                jQuery('.column--three').empty();
            }
            var newItems = items.clone();
            var columns = [];
            var getViewportWidth = function () {
                return Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
            };
            var gridLagerBreakpoint = 1420;
            var gridSmallBreakpoint = 768;
            columns.push(jQuery('.column--one'));
            if (getViewportWidth() >= gridSmallBreakpoint) {
                columns.push(jQuery('.column--two'));
            }
            if (getViewportWidth() >= gridLagerBreakpoint) {
                columns.push(jQuery('.column--three'));
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
            jQuery(document).on('mouseenter', '.tag ul > li:first-child', function (event) {
                event.stopPropagation();
                jQuery(this).parents('ul').addClass('show');
            });
            jQuery(document).on('click', '.tag ul > li', function (event) {
                event.stopPropagation();
            });
            jQuery(document).on('mouseleave', '.tag ul', function (event) {
                event.stopPropagation();
                jQuery(this).removeClass('show');
            });
        },

        placeToolbar: function (wrap, a, b) {
            var loli = parseInt((jQuery(window).width() - wrap + 1) / 2 - a - b);
            if (loli < 20) {
                loli = 20;
            }
            jQuery('.right-toolbar').css({
                right: loli,
                opacity: 1
            });
        },
        menuScroll: function () {
            jQuery(window).scroll(function (event) {
                event.stopPropagation();
                var scrollTop = jQuery(window).scrollTop();
                if (scrollTop > 69) {
                    jQuery('header.header').addClass('header--fixed');
                } else {
                    jQuery('header.header').removeClass('header--fixed');
                }
            })
        },
        toolBarPlace: function () {
            var arrivedAtBottom = false;
            jQuery(window).scroll(function (event) {
                event.stopPropagation();
                arrivedAtBottom = jQuery(window).scrollTop() >= jQuery(document).height() - jQuery(window).height();
                if (arrivedAtBottom) {
                    jQuery('.tooltip-goto').find('.icon-vertical_align_bottom').hide();
                    jQuery('.tooltip-goto').find('.icon-vertical_align_top').show();
                } else {
                    jQuery('.tooltip-goto').find('.icon-vertical_align_top').hide();
                    jQuery('.tooltip-goto').find('.icon-vertical_align_bottom').show();
                }
            })
        },
        upperDownClick: function () {
            jQuery(document).on('click', '.right-toolbar .icon-vertical_align_top', function () {
                jQuery('html, body').animate({scrollTop: 0}, 500);
            });
            jQuery(document).on('click', '.right-toolbar .icon-vertical_align_bottom', function () {
                jQuery('html, body').animate({scrollTop: jQuery('#page-wrap').height()}, 500);
            });
            jQuery(document).on('click', '.right-toolbar .icon-question_answer', function () {
                jQuery('html, body').animate({scrollTop: jQuery('#respond').position().top}, 500);
            });
            jQuery(document).on('click', '.right-toolbar .icon-bubble_chart', function () {
                jQuery('html, body').animate({scrollTop: jQuery('.share').position().top}, 500);
            });
        },
        ScrollMenuMobile: function () {
            setTimeout(function () {
                jQuery('.wrapper-nav').css('height', jQuery(window).height() + 'px')
            }, 500)
            jQuery(window).resize(function () {
                setTimeout(function () {
                    jQuery('.wrapper-nav').css('height', jQuery(window).height() + 'px')
                }, 500)
            });
        },
        setCookie: function (o, e) {
            var i = new Date;
            i.setTime(i.getTime() + 31536e6), document.cookie = o + '=' + e + ';path=/;expires=' + i.toUTCString()
        },
        rippleEffect: function () {
            var jQueryripple = jQuery('.rika-ripple');

            jQueryripple.on('click.ui.ripple', function (e) {

                var jQuerythis = jQuery(this);
                var jQueryoffset = jQuerythis.parent().offset();
                var jQuerycircle = jQuerythis.find('.c-ripple__circle');

                var x = e.pageX - jQueryoffset.left;
                var y = e.pageY - jQueryoffset.top;

                jQuerycircle.css({
                    top: y + 'px',
                    left: x + 'px'
                });

                jQuerythis.addClass('is-active');

            });

            jQueryripple.on('animationend webkitAnimationEnd oanimationend MSAnimationEnd', function (e) {
                jQuery(this).removeClass('is-active');
            });
        },
        filledField: function () {
            var jQueryfield = jQuery('.rika-textfield');

            jQueryfield.on('change', function () {
                if (jQuery(this).children('input').val()) {
                    if (!jQuery(this).children('input').hasClass('is-filled')) {
                        jQuery(this).children('input').addClass('is-filled');
                    }
                } else {
                    if (jQuery(this).children('input').hasClass('is-filled')) {
                        jQuery(this).children('input').removeClass('is-filled');
                    }
                }
            });
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


jQuery(function () {
    jQuery.rika_js();
});

var RikaSite = RikaSite || {};

jQuery(document).ready(function (jQuery) {
    'use strict';
    RikaSite = function () {

    },
            RikaSite.prototype = {
                init: function () {
                    var o = this,
                            postContent = jQuery('#post .column--invisible .list--post');
                    o.hoverSearchText(), o.initial(postContent), o.placeToolbar(960, 60, 20), o.ajaxPostLoading(), o.responsiveColumn(postContent), o.navDropDownClick(), o.navFilterClick(), o.menuScroll(), o.upperDownClick(), o.toolBarPlace(), o.dispalyMoblieMenu(), o.tagPost(), o.ScrollMenuMobile(), o.searchClick(), o.layoutSwitchClick(), o.rippleEffect(), o.filledField();
                },
                hoverSearchText: function () {
                    jQuery('.search-text .text').focus(function () {
                        if (jQuery(this).val() == '找东西？') {
                            jQuery(this).val('')
                        }
                    }).blur(function () {
                        if (jQuery(this).val() == '') {
                            jQuery(this).val('找东西？')
                        }
                    })
                },
                initial: function (items) {
                    this.adjustColumnHeights(items.clone());
                    jQuery('.column--post').addClass('stop--sliding');
                },
                responsiveColumn: function (items) {
                    jQuery(window).resize({viewModel: o}, function (o) {
                        var e = o.data.viewModel;
                        e.adjustColumnHeights(items.clone());
                    });
                },
                layoutSwitchClick: function () {
                    jQuery('i.icon-layout').on('click', function () {
                        var iSwitch = jQuery(this),
                                gridView = iSwitch.hasClass('icon-th'),
                                listView = iSwitch.hasClass('icon-th-list');

                        if (gridView && !iSwitch.hasClass('active')) {
                            jQuery('#post').removeClass('list--view').addClass('grid--view');
                            void RikaSite.prototype.setCookie('layout', 1);
                            iSwitch.siblings('.icon-th-list').removeClass('active');
                            iSwitch.addClass('active');
                            jQuery('.column--post.column--invisible').removeClass('column--invisible');
                            RikaSite.prototype.adjustColumnHeights(jQuery('#post .column--invisible .list--post').clone());
                            jQuery('.column--invisible').removeClass('column--show');

                        } else if (listView && !iSwitch.hasClass('active')) {
                            jQuery('#post').removeClass('grid--view').addClass('list--view');
                            void RikaSite.prototype.setCookie('layout', 2);
                            iSwitch.siblings('.icon-th').removeClass('active');
                            iSwitch.addClass('active');
                            jQuery('.column--invisible').addClass('column--show');
                            jQuery('.column--post ').addClass('column--invisible');

                        }
                    })
                },
                adjustColumnHeights: function (items) {
                    jQuery('.column--one').empty();
                    jQuery('.column--two').empty();
                    jQuery('.column--three').empty();
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
                    for (var i = 0; i < items.length; i++) {
                        this.getTargetColumn(columns).append(items.eq(i).addClass('post--item').removeClass('list--post'));
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
                ajaxPostLoading: function () {
                    var currentState = window.location.href;
                    jQuery(document).on('click', '.container > .navigation a', {viewModel: o},
                            function (o) {
                                o.preventDefault();
                                var e = o.data.viewModel;
                                var currentLink = jQuery(this).attr('href');
                                e.turnpage(currentLink);
                                history.pushState(null, document.title, currentLink);
                                currentState = window.location.href;
                            }
                    )
                    ;
                    window.addEventListener('popstate', {viewModel: o}, function (o) {
                        var _currentUrl = window.location.href;
                        var e = o.data.viewModel;
                        if (currentState != _currentUrl) {
                            e.turnpage(_currentUrl);
                            currentState = _currentUrl;
                        }
                    });
                },
                turnpage: function (pageurl) {
                    jQuery('.pageload-overlay').addClass('show');
                    jQuery('html,body').animate({scrollTop: 0}, 300);
                    jQuery('.column--post').addClass('fading');
                    jQuery('.column--invisible').addClass('fading');
                    jQuery.ajax({
                        url: pageurl
                    }).always(function (o) {
                        var html = jQuery.parseHTML(o);
                        jQuery('#post').html(jQuery('#post', html).html());
                        jQuery('.navigation').html(jQuery('.navigation', html).html());
                        jQuery('.wp-post-image').on('load', function () {
                            RikaSite.prototype.initial(jQuery('#post .column--invisible .list--post'));
                            RikaSite.prototype.responsiveColumn(jQuery('#post .column--invisible .list--post'));
                        });
                    });
                },
                navDropDownClick: function () {
                    jQuery(document).on('click', '.open-nav', function (o) {
                        o.stopPropagation();
                        jQuery('#nav-filters').toggleClass('open');
                        jQuery('.box-overlay').addClass('open')
                    });

                    jQuery(document).on('click', '.close-nav', function () {
                        jQuery('.nav-sidebar').removeClass('open');
                        jQuery('.box-overlay').removeClass('open')
                    });
                },
                navFilterClick: function () {
                    jQuery(document).on('click', '.wrapper-dropdown', function () {
                        jQuery(this).toggleClass('active');
                        jQuery.stopPropagation()
                    });
                    jQuery(document).on('click', '.nav-sidebar', function (o) {
                        o.stopPropagation()
                    });
                    jQuery(document).on('click', function () {
                        jQuery('.nav-sidebar').removeClass('open');
                        jQuery('.box-overlay').removeClass('open')
                    });
                },
                searchClick: function () {
                    jQuery(document).on('click', '.bt-search', function () {
                        if (jQuery('.search-text').hasClass('visible')) {
                            jQuery('.search-text').removeClass('visible');
                        } else {
                            jQuery('.search-text').addClass('visible');
                        }
                        setTimeout(function () {
                            jQuery('.search-text .text').trigger('focus')
                        }, 200);
                        setTimeout(function () {
                            jQuery('.search-text').removeClass('visible')
                        }, 10000)
                    })
                },
                menuScroll: function () {
                    jQuery(window).scroll(function (event) {
                        event.stopPropagation();
                        var scrollTop = jQuery(window).scrollTop();
                        if (scrollTop > 48) {
                            jQuery('nav.search').removeClass('open');
                            jQuery('body').addClass('header-fixed');
                            jQuery('.main').addClass('white-bg');
                        } else {
                            if (jQuery('nav.search').hasClass('visible')) {
                                jQuery('nav.search').addClass('open');
                            }
                            jQuery('body').removeClass('header-fixed');
                            jQuery('.main').removeClass('white-bg');
                        }
                    })
                },
                dispalyMoblieMenu: function () {
                    jQuery(document).on('click', '#menu-mobile .bt-menu', {viewModel: o}, function () {
                        if (jQuery('#menu-mobile').hasClass('open')) {
                            jQuery('#menu-mobile').removeClass('open');
                        } else {
                            jQuery('#menu-mobile').addClass('open');
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
                    var $ripple = jQuery('.rika-ripple');

                    $ripple.on('click.ui.ripple', function (e) {

                        var $this = jQuery(this);
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
                        jQuery(this).removeClass('is-active');
                    });
                },
                filledField: function () {
                    var $field = jQuery('.rika-textfield');

                    $field.on('change', function (e) {
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

    var o = new RikaSite();
    o.init();


});

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




jQuery(document).ready(function () {
    jQuery(function () {
        jQuery('.search-text .text').focus(function () {
            if (jQuery(this).val() == '找东西？') {
                jQuery(this).val('')
            }
        }).blur(function () {
            if (jQuery(this).val() == '') {
                jQuery(this).val('找东西？')
            }
        })
    });
    /*
     Initial whole wrap
     Stop article arsing
     Adjust column heights
     */
    function stop(items) {
        items.addClass('stop--sliding');
    }

    // Adjust Column Heights Algorithm
    function adjustColumnHeights(items) {
        jQuery('.column--one').empty();
        jQuery('.column--two').empty();
        jQuery('.column--three').empty();
        var columns = [];
        var getViewportWidth = function () {
            return Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
        };
        var gridLagerBreakpoint = 1420;
        var gridSmallBreakpoint = 767;
        columns.push(jQuery('.column--one'));
        if (getViewportWidth() > gridSmallBreakpoint) {
            columns.push(jQuery('.column--two'));
        }
        if (getViewportWidth() > gridLagerBreakpoint) {
            columns.push(jQuery('.column--three'));
        }
        for (var i = 0; i < items.length; i++) {
            getTargetColumn(columns).append(items.eq(i).addClass('post--item').removeClass('hiding--post'));
        }
    }

    function getTargetColumn(columnList) {
        var currentBestHeight = Number.MAX_VALUE;
        for (var i = 0; i < columnList.length; i++) {
            if (columnList[i].outerHeight() < currentBestHeight) {
                var bestColumn = columnList[i];
                currentBestHeight = columnList[i].outerHeight();
            }
        }
        return bestColumn;
    }

    function initial(items) {
        tag();
        adjustColumnHeights(items.clone());
        stop(jQuery('.column--post'));
        adjustMenu('ul#menu-cat-menu li');
    }

    function responsive(items) {
        adjustColumnHeights(items.clone());
    }

    initial(jQuery('#post .column--none .hiding--post'));

    jQuery(window).resize(function () {
        responsive(jQuery('#post .column--none .hiding--post'));
    });
    placeToolbar(960, 60, 20);

    function turnpage(pageurl) {
        jQuery('.pageload-overlay').addClass('show');
        jQuery('html,body').animate({scrollTop: 0}, 300);
        jQuery('.column--post').addClass('fading');
        jQuery.ajax({
            url: pageurl
        }).done(function (data) {
            var html = jQuery.parseHTML(data);
            jQuery("#post").html(jQuery("#post", html).html());
            jQuery(".navigation").html(jQuery(".navigation", html).html());
            var imgload = imagesLoaded(jQuery('#post'));
            imgload.on('done', function () {
                initial(jQuery('#post .column--none .hiding--post'));
            });
        });
    }

    //Article tag
    function tag() {
        jQuery('.tag ul > li:first-child').mouseenter(function (event) {
            event.stopPropagation();
            jQuery(this).parents('ul').addClass('show');
        });
        jQuery('.tag ul > li').click(function (event) {
            event.stopPropagation();
        });
        jQuery('.tag ul').mouseleave(function (event) {
            event.stopPropagation();
            jQuery(this).removeClass('show');
        });
    }

    //add post img class v0.1
    jQuery(".post-detail p a[href]").filter("[hrefjQuery='png'], [hrefjQuery='jpg']").addClass("img");
    //Adjust menu width
    function adjustMenu(menuList) {
        var count = jQuery(menuList).size();
        var hentai = 100 / count;
        jQuery(menuList).css('width', hentai + '%');

        jQuery('.wrapper-menu').css('height', jQuery(window).height() + 'px');
    }

    //Place the right tool-bar
    function placeToolbar(wrap, a, b) {
        var loli = parseInt((jQuery(window).width() - wrap + 1) / 2 - a - b);
        if (loli < 20) {
            loli = 20;
        }
        jQuery(".right-toolbar").css({
            right: loli,
            opacity: 1
        });
    }

    var currentState = window.location.href;
    window.addEventListener('popstate', function (event) {
        var _currentUrl = window.location.href;
        if (currentState != _currentUrl) {
            turnpage(_currentUrl);
            currentState = _currentUrl;
        }
    });

    jQuery(document).on("click", ".navigation a", function (event) {
        event.preventDefault();
        var currentLink = jQuery(this).attr("href");
        turnpage(currentLink);
        history.pushState(null, document.title, currentLink);
        currentState = window.location.href;
    });

    jQuery(document).on("click", "nav.search .dropdown", function () {
        var type = jQuery(this).data('filter');
        if (jQuery(this).hasClass('active')) {
            jQuery(this).removeClass('active');
            jQuery('.filters').removeClass('open');
            jQuery('.filters').slideToggle('slow');
            setTimeout(function () {
                jQuery('.filters .filter').hide();
            }, 500);
        } else {
            jQuery('nav.search .dropdown').removeClass('active');
            jQuery(this).addClass('active');
            if (jQuery('.filters').hasClass('open')) {
                jQuery('.filters .filter').hide();
                jQuery('.filters .filter.' + type).fadeIn();
            } else {
                jQuery('.filters').addClass('open');
                jQuery('.filters .filter.' + type).fadeIn();
                jQuery('.filters').slideToggle('slow');
            }
        }
    });
    jQuery(document).on("click", ".bt-search", function (event) {
        event.stopPropagation();
        if (jQuery(this).hasClass('active')) {
            jQuery(this).removeClass('active');
            jQuery('nav.search').removeClass('open');
            jQuery('nav.search .dropdown').removeClass('active');
            jQuery('nav.search, .filters').removeClass('open');
            jQuery('.filters, .filters .filter').hide();
        } else {
            jQuery(this).addClass('active');
            jQuery('nav.search').addClass('open');
            jQuery('nav .search-text input[type="text"]').focus();
        }
    });
    jQuery(window).scroll(function (event) {
        event.stopPropagation();
        var scrollTop = jQuery(window).scrollTop();
        if (scrollTop > 48) {
            jQuery('nav.search').removeClass('open');
            jQuery('.bt-search').removeClass('active');
            jQuery('body').addClass('header-fixed');
            jQuery('.main').addClass('white-bg');
            jQuery('nav.search .dropdown').removeClass('active');
            jQuery('nav.search, .filters').removeClass('open');
            jQuery('.filters, .filters .filter').hide();
        } else {
            if (jQuery('nav.search').hasClass('visible')) {
                jQuery('nav.search').addClass('open');
                jQuery('.bt-search').addClass('active');
            }
            jQuery('body').removeClass('header-fixed');
            jQuery('.main').removeClass('white-bg');
        }
    });
    //Display the moblie menu
    jQuery(document).on("click", "#menu-mobile .bt-menu", function (event) {
        event.stopPropagation();
        if (jQuery("#menu-mobile").hasClass('open')) {
            jQuery("#menu-mobile").removeClass('open');
        } else {
            jQuery("#menu-mobile").addClass('open');
        }
    });

    // Go down and up change
    var arrivedAtBottom = false;
    jQuery(window).scroll(function (event) {
        event.stopPropagation();
        arrivedAtBottom = jQuery(window).scrollTop() >= jQuery(document).height() - jQuery(window).height();
        if (arrivedAtBottom) {
            jQuery('.tool-goto').removeClass("tool-down icon-angle-down");
            jQuery('.tool-goto').addClass("tool-up icon-angle-up");
        } else {
            jQuery('.tool-goto').removeClass("tool-up icon-angle-up");
            jQuery('.tool-goto').addClass("tool-down icon-angle-down");
        }
    });
    jQuery(document).on("click", ".right-toolbar .tool-up", function () {
        jQuery('html, body').animate({scrollTop: 0}, 500);
    });
    jQuery(document).on("click", ".right-toolbar .tool-down", function () {
        jQuery('html, body').animate({scrollTop: jQuery('#page-wrap').height()}, 500);
    });
    jQuery(document).on("click", ".right-toolbar .icon-bubbles", function () {
        jQuery('html, body').animate({scrollTop: jQuery('#respond').position().top}, 500);
    });
    jQuery(document).on("click", ".right-toolbar .icon-share", function () {
        jQuery('html, body').animate({scrollTop: jQuery('.WPSNS_main').position().top}, 500);
    });


})
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
        sel = document.selection.createRange();
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

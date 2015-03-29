jQuery(document).ready(function () {
    var input_search,
            input_search = jQuery(".js-search-input"),
            searchWrapper = jQuery(".js-search-results"),
            delaySearch,
            ajaxSearchContent;
    var event_ajax_search = {
        bind_event: function () {
            input_search.bind('keyup',
                    function (e) {
                        if (input_search.val() != "") {
                            if (delaySearch) {
                                clearTimeout(delaySearch)
                            }
                            delaySearch = setTimeout(startSearch, 500);
                        } else if (input_search.val() == "") {
                            searchWrapper.empty().hide();
                        }
                    })
        },
        unbind_event: function () {
            input_search.unbind('keyup');
        }
    };
    jQuery(document).click(function (a) {
        if ((searchWrapper.is(":visible") || searchWrapper.is(":visible")) && !a.target) searchWrapper.hide()
    });
    input_search.focus(function () {
        event_ajax_search.bind_event();
    }).blur(function () {
        event_ajax_search.unbind_event();
    });
    function startSearch() {

        jQuery.ajax({
            url: 'http://www.xiami.com/search/json?t=1&k=' + input_search.val() + '&n=10&callback=jsonp978',
            type: 'GET',
            dataType: 'jsonp',
            success: function (data) {
                if (!data) console.log('sb');

                var html = ''
                for (var i = 0; i < data.length; i++) {
                    var item = data[i]
                    html += '<li class="add-xiamil" data-id="' + item.song_id + '"><div class="img"><img width="30" height="30" alt="爱你" src="http://img.xiami.net/' + item.album_logo + '"></div><div class="name"><p>' + item.song_name + '</p><p>' + item.artist_name + '</p></div><a class="play-btn"></a></li>'
                }
                ;
                html = '<div class="search-title">歌曲</div><ul class="pads">' + html + '</ul>';
                searchWrapper.empty();
                searchWrapper.html(html).show();
            }
        });
    }

});
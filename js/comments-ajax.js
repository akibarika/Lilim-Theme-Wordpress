jQuery(document).ready(function($) {
    var $commentform = $('#commentform'),
        txt1 = '<div id="loading">正在提交, 请稍候...</div>',
        txt2 = '<div id="error">#</div>',
        txt3 = '">提交成功',
        edt1 = ', 刷新页面之前可以<a rel="nofollow" class="comment-reply-link" href="#edit" onclick=\'return addComment.moveForm("',
        edt2 = ')\'>再编辑</a>',
        cancel_edit = '取消编辑',
        edit,
        num = 1,
        $comments = $('#comments-title'),
        $cancel = $('#cancel-comment-reply-link'),
        cancel_text = $cancel.text(),
        $submit = $('#commentform #submit');
    $submit.attr('disabled', false),
        $body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body'),
        comm_array = [];
    comm_array.push('');
    $('#comment').after(txt1 + txt2);
    $('#loading').hide();
    $('#error').hide();
    $(document).on("submit", "#commentform",
        function() {
            if (edit) $('#comment').after('<input type="text" name="edit_id" id="edit_id" value="' + edit + '" style="display:none;" />');
            editcode();
            $submit.attr('disabled', true).fadeTo('slow', 0.5);
            $('#loading').slideDown();
            $.ajax({
                url: ajax.ajax_url,
                data: $(this).serialize() + "&action=ajax_comment",
                type: $(this).attr('method'),
                error: function(request) {
                    $('#loading').hide();
                    $("#error").slideDown().html(request.responseText);
                    setTimeout(function() {
                            $submit.attr('disabled', false).fadeTo('slow', 1);
                            $('#error').slideUp();
                        },
                        3000);
                },
                success: function(data) {
                    $('#loading').hide();
                    comm_array.push($('#comment').val());
                    $('textarea').each(function() {
                        this.value = ''
                    });
                    var t = addComment,
                        cancel = t.I('cancel-comment-reply-link'),
                        temp = t.I('wp-temp-form-div'),
                        respond = t.I(t.respondId),
                        post = t.I('comment_post_ID').value,
                        parent = t.I('comment_parent').value;
                    if (!edit && $comments.length) {
                        n = parseInt($comments.text().match(/\d+/));
                        $comments.text($comments.text().replace(n, n + 1));
                    }
                    new_htm = '" id="new_comm_' + num + '"></';
                    new_htm = (parent == '0') ? ('\n<ol style="clear:both;" class="commentlist' + new_htm + 'ol>') : ('\n<ul class="children' + new_htm + 'ul>');
                    ok_htm = '\n<div class="ajax-notice" id="success_' + num + txt3;
                    div_ = (document.body.innerHTML.indexOf('div-comment-') == -1) ? '': ((document.body.innerHTML.indexOf('li-comment-') == -1) ? 'div-': '');
                    ok_htm = ok_htm.concat(edt1, div_, 'comment-', parent, '", "', parent, '", "respond", "', post, '", ', num, edt2);
                    ok_htm += '</span><span></span>\n';
                    ok_htm += '</div>\n';
                    $('#respond').before(new_htm);
                    $('#new_comm_' + num).append(data);
                    $('#new_comm_' + num + ' li').append(ok_htm);
                    $body.animate({
                            scrollTop: $('#new_comm_' + num).offset().top - 200
                        },
                        900);
                    countdown();
                    num++;
                    edit = '';
                    $('*').remove('#edit_id');
                    cancel.style.display = 'none';
                    cancel.onclick = null;
                    t.I('comment_parent').value = '0';
                    if (temp && respond) {
                        temp.parentNode.insertBefore(respond, temp);
                        temp.parentNode.removeChild(temp)
                    }
                }
            });
            return false;
        });
    addComment = {
        moveForm: function(commId, parentId, respondId, postId, num) {
            var t = this,
                div,
                comm = t.I(commId),
                respond = t.I(respondId),
                cancel = t.I('cancel-comment-reply-link'),
                parent = t.I('comment_parent'),
                post = t.I('comment_post_ID');
            if (edit) exit_prev_edit();
            num ? (t.I('comment').value = comm_array[num], edit = t.I('new_comm_' + num).innerHTML.match(/(comment-)(\d+)/)[2], $new_sucs = $('#success_' + num), $new_sucs.hide(), $new_comm = $('#new_comm_' + num), $new_comm.hide(), $cancel.text(cancel_edit)) : $cancel.text(cancel_text);
            t.respondId = respondId;
            postId = postId || false;
            if (!t.I('wp-temp-form-div')) {
                div = document.createElement('div');
                div.id = 'wp-temp-form-div';
                div.style.display = 'none';
                respond.parentNode.insertBefore(div, respond)
            } ! comm ? (temp = t.I('wp-temp-form-div'), t.I('comment_parent').value = '0', temp.parentNode.insertBefore(respond, temp), temp.parentNode.removeChild(temp)) : comm.parentNode.insertBefore(respond, comm.nextSibling);
            $body.animate({
                    scrollTop: $('#respond').offset().top - 180
                },
                400);
            if (post && postId) post.value = postId;
            parent.value = parentId;
            cancel.style.display = '';
            cancel.onclick = function() {
                if (edit) exit_prev_edit();
                var t = addComment,
                    temp = t.I('wp-temp-form-div'),
                    respond = t.I(t.respondId);
                t.I('comment_parent').value = '0';
                if (temp && respond) {
                    temp.parentNode.insertBefore(respond, temp);
                    temp.parentNode.removeChild(temp);
                }
                this.style.display = 'none';
                this.onclick = null;
                return false;
            };
            try {
                t.I('comment').focus();
            }
            catch(e) {}
            return false;
        },
        I: function(e) {
            return document.getElementById(e);
        }
    };
    function exit_prev_edit() {
        $new_comm.show();
        $new_sucs.show();
        $('textarea').each(function() {
            this.value = ''
        });
        edit = '';
    }
    var wait = 15,
        submit_val = $submit.val();
    function countdown() {
        if (wait > 0) {
            $submit.val(wait);
            wait--;
            setTimeout(countdown, 1000);
        } else {
            $submit.val(submit_val).attr('disabled', false).fadeTo('slow', 1);
            wait = 15;
        }
    }
    function editcode() {
        var a = "",
            b = $("#comment").val(),
            start = b.indexOf("<code>"),
            end = b.indexOf("</code>");
        if (start > -1 && end > -1 && start < end) {
            a = "";
            while (end != -1) {
                a += b.substring(0, start + 6) + b.substring(start + 6, end).replace(/<(?=[^>]*?>)/gi, "&lt;").replace(/>/gi, "&gt;");
                b = b.substring(end + 7, b.length);
                start = b.indexOf("<code>") == -1 ? -6: b.indexOf("<code>");
                end = b.indexOf("</code>");
                if (end == -1) {
                    a += "</code>" + b;
                    $("#comment").val(a)
                } else if (start == -6) {
                    myFielde += "&lt;/code&gt;"
                } else {
                    a += "</code>"
                }
            }
        }
        var b = a ? a: $("#comment").val(),
            a = "",
            start = b.indexOf("<pre>"),
            end = b.indexOf("</pre>");
        if (start > -1 && end > -1 && start < end) {
            a = a
        } else return;
        while (end != -1) {
            a += b.substring(0, start + 5) + b.substring(start + 5, end).replace(/<(?=[^>]*?>)/gi, "&lt;").replace(/>/gi, "&gt;");
            b = b.substring(end + 6, b.length);
            start = b.indexOf("<pre>") == -1 ? -5: b.indexOf("<pre>");
            end = b.indexOf("</pre>");
            if (end == -1) {
                a += "</pre>" + b;
                $("#comment").val(a)
            } else if (start == -5) {
                myFielde += "&lt;/pre&gt;"
            } else {
                a += "</pre>"
            }
        }
    }
    function grin(a) {
        var b;
        a = " " + a + " ";
        if (document.getElementById("comment") && document.getElementById("comment").type == "textarea") {
            b = document.getElementById("comment")
        } else {
            return false
        }
        if (document.selection) {
            b.focus();
            sel = document.selection.createRange();
            sel.text = a;
            b.focus()
        } else if (b.selectionStart || b.selectionStart == "0") {
            var c = b.selectionStart;
            var d = b.selectionEnd;
            var e = d;
            b.value = b.value.substring(0, c) + a + b.value.substring(d, b.value.length);
            e += a.length;
            b.focus();
            b.selectionStart = e;
            b.selectionEnd = e
        } else {
            b.value += a;
            b.focus()
        }
    }
});
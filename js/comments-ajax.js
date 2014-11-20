jQuery('document').ready(function($){
var commentform=$('#commentform');
    commentform.prepend('<div id="comment-status" ></div>');
    var statusdiv=$('#comment-status');
	var list ;
    $('a.comment-reply-link').click(function(){
        list = $(this).parent().parent().parent().parent().attr('id');
    });
	 
    commentform.submit(function(){
        var formdata=commentform.serialize();
        statusdiv.html('<p>发布中.</p>');
        var formurl=commentform.attr('action');
        
        $.ajax({
            type: 'post',
            url: formurl,
            data: formdata,
            error: function(XMLHttpRequest, textStatus, errorThrown)
                {
                    statusdiv.html('<p class="ajax-error" >出错啦...</p>');
                },
            success: function(data, textStatus){
                if(data == "success" || textStatus == "success"){
                    statusdiv.html('<p class="ajax-success" >感谢吐槽...</p>');
                    //alert(data); 
                    
                    if($("#comments").has("ol.commentlist").length > 0){
                        if(list != null){
                            $('div.rounded').prepend(data);
                        } else{
                            $('ol.commentlist').append(data);
                        }
                    } else {
                        $("#comments").prepend('<ol class="commentlist"> </ol>');
                        $('ol.commentlist').html(data);
                    }
                }else{
                    statusdiv.html('<p class="ajax-error" >发太快啦..受不了了..</p>');
                    commentform.find('textarea[name=comment]').val('');
                }
            }
        });
        return false;
    });
});


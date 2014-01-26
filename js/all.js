$(document).ready(function(){
	jQuery(function() {
		$('.search-text .text').focus(function() {
			if ($(this).val() == '找东西？') {
				$(this).val('')
			}
		}).blur(function() {
			if ($(this).val() == '') {
				$(this).val('找东西？')
			}
		})
	});

	$('.item').stop().fadeTo(100,1,function(){
		$('.item').addClass('stop');
	});

	var $post = $('#post'); 
	$post.imagesLoaded( function() {
	  $post.masonry({
		  	  itemSelector: '.item',
		  	  columnWidth: '.item',
		  	  transitionDuration: 0,
		  	  "gutter":20
			});
	});
	$(function() {
	    var $elem = $('#page-wrap');
	    $('.tool-up').fadeIn('slow');
	    $('.tool-down').fadeIn('slow'); 
	    $(window).bind('scrollstart', function(){
	        $('.tool-up,.tool-down,.tool-comment').stop().animate({'opacity':'0.2'});
	    });
	    $(window).bind('scrollstop', function(){
	        $('.tool-up,.tool-down,tool-comment').stop().animate({'opacity':'1'});
	    });

	    $('.tool-down').click(
	        function (e) {
	            $('html, body').animate({scrollTop: $elem.height()}, 800);
	        }
	    );
	    $('.tool-up').click(
	        function (e) {
	            $('html, body').animate({scrollTop: '0px'}, 800);
	        }
	    ); 
	    $('.tool-comment').click(
	        function (e) {
	            $('html, body').animate({scrollTop:$('#comments').position().top}, 800);
	        }
	    ); 	 	    	 	      
	 });
    $('nav.search .dropdown').click(function() {

        var type = $(this).data('filter');

        if ($(this).hasClass('active')) {

            $(this).removeClass('active');
            $('.filters').removeClass('open');

            $('.filters').slideToggle('slow');
            setTimeout(function() {
                $('.filters .filter').hide();
            }, 500);

        } else {

            $('nav.search .dropdown').removeClass('active');
            $(this).addClass('active');

            if ($('.filters').hasClass('open')) {

                $('.filters .filter').hide();
                $('.filters .filter.' + type).fadeIn();

            } else {

                $('.filters').addClass('open');
                $('.filters .filter.' + type).fadeIn();
                $('.filters').slideToggle('slow');

            }

        }

    });	 
	 $(window).scroll(function() {

        var scrollTop = $(window).scrollTop();

        if (scrollTop > 48) {
            $('body').addClass('header-fixed');
            $('.main').addClass('white-bg');
        } else {
            $('body').removeClass('header-fixed');
            $('.main').removeClass('white-bg');
        }

    });
            
	$("#menu-mobile .bt-menu").click(function() {
	if ($("#menu-mobile").hasClass('open')) {
	    $("#menu-mobile").removeClass('open');
	} else {
	    $("#menu-mobile").addClass('open');
	}
	});
	var wrap = 960;
	var a = 60;
	var b = 20;
	var loli = parseInt((jQuery(window).width() - wrap +1) / 2 - a - b);
	if (loli<20){
		loli = 20;
	}
	$(".right-toolbar").css({
		right:loli,
		opacity:1
	});	
	$('.wrapper-menu').css('height', $(window).height() + 'px');
	var count = $("ul#1st-menu li").size();
	var hentai = 100 / count;
	$("ul#1st-menu li").css('width', hentai +'%');
	
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

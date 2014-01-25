function initialise(content) {
	// Effects
	$easingType= 'easeInOutQuart';	
				
	
	
	/*---------------------------------------------- 
				 F L E X S L I D E R 
	------------------------------------------------*/
	$(content+' #slider .flexslider').flexslider({
		animation: "fade",
		slideshow: false,
		controlsContainer: "#slider",
		animationDuration: 700,
		start: function(slider){
			var defaultwidth = $(slider).find("ul li:first-child").width();
			var defaultheight = $(slider).find("ul li:first-child").height();
			var resizeamount = defaultwidth/$(slider).width();
			var resizedwidth = $(slider).width();
			var resizedheight = Math.round(defaultheight/resizeamount);
			if (defaultheight > 1) { $(slider).parent('#slider').css({ 'height': defaultheight+'px' }); }
		},
		before: function(slider) {
			var iframe = $(slider).find("li:eq("+(slider.currentSlide)+") .embeddedvideo").html();
			$(slider).find("li:eq("+(slider.currentSlide)+") .embeddedvideo").html("");
			$(slider).find("li:eq("+(slider.currentSlide)+") .embeddedvideo").html(iframe);
			var sliderheight = $(slider).find("li:eq("+(slider.animatingTo)+")").height();
			$(slider).parent('#slider').animate({ 'height': sliderheight+'px' }, 500, $easingType);
			// adapt to the #animationsection if is parent
			var sidebarheight = $(slider).closest('#pageloader').find('#sidebar').height() + parseFloat($(slider).closest('#pageloader').find('#sidebar').css('paddingTop')) + parseFloat($(slider).closest('#pageloader').find('#sidebar').css('paddingBottom')) ;
			var paddings = parseFloat($(slider).closest('#pageloader').css('paddingTop')) + parseFloat($(slider).closest('#pageloader').css('paddingBottom'));
			var sectionheight = paddings + sliderheight;
			if ((sidebarheight+paddings) < sectionheight) { resizeheight = sectionheight; } else { resizeheight = sidebarheight+paddings; }
			if ($(window).width() < 768) { resizeheight =  paddings+sidebarheight+sliderheight;}
			$(slider).closest('#animationsection').animate({ 'height': resizeheight+'px' }, 500, $easingType);
      	},
	});
	
	
	
	
	/*---------------------------------------------- 
				   I M G   H O V E R
	------------------------------------------------*/
	/* SETTINGS */
	var hoverFade = 300;	
		
	// check if .overlay already exists or not
	$('.img_holder a').each(function(index){
		if($(this).find('.overlay').length == 0) { 
			$(this).append('<div class="overlay"></div>');
			$(this).find('.overlay').css({ opacity: 0 });
		} 										
	});
	
	$(content+' .img_holder').hover(function(){
		$(this).find('.overlay').animate({ opacity: 0.5 }, hoverFade);
	}, function(){
		$(this).find('.overlay').animate({ opacity: 0 }, hoverFade);
	});	
	
	
	
	/*---------------------------------------------- 
				  F A N C Y B O X
	------------------------------------------------*/
	$(content+' .openfancybox').fancybox();
	$(content+' .gallery-item a').fancybox();
	
	
	
	/*---------------------------------------------- 
				      T O G G L E 
	------------------------------------------------*/	
	$(".article_content").on("click", '.toggle_title a', function() { 
		
		var status = $(this).find('span').html();
		if (status == '+') { $(this).find('span').html('-'); } else { $(this).find('span').html('+'); }
		
		$(this).parent().siblings('.toggle_inner').slideToggle(300);
		return(false);
	});
	
	
	
	/*---------------------------------------------- 
				  C H E C K   F O R M 
	------------------------------------------------*/
	// create the checkfalse div's
	$(content+' .checkform .req').each(function(){
		$(this).parent().append('<span class="checkfalse">false</span>');							   
	});
	$('.checkfalse').hide();
	
	// caching of the sart values
	labelstart = new Array();
	$(".checkform label.req").each(function(index){ 
		var name = $(this).attr('for');
		labelstart[index] = $('.'+name+'').val();
	});
	
	
	$(".checkform").on("click", 'input[type="submit"]', function() {
				
		form = $(this).parent('div');
		$form = $(form).parent('.checkform');
		form_action = $form.attr('target');
		id = $form.attr('id');
		
		var control = true;
		
		$form.find('label.req').each(function(index){
			var name = $(this).attr('for');
			value = $form.find('.'+name+'').val();
			formtype = $('.'+name).attr('type');
									
			if (formtype == 'radio' || formtype == 'checkbox') {
				if ($('.'+name+':checked').length == 0) { $(this).siblings('.checkfalse').fadeIn(200); control = false;  } else { $(this).siblings('.checkfalse').fadeOut(200); }
			} else if(name == 'email') {
				var re = /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/;
				if (!value.match(re)) { $(this).siblings('.checkfalse').fadeIn(200); control = false;  } else { $(this).siblings('.checkfalse').fadeOut(200); }
			} else {
				if (  value == '' || 
					  value == labelstart[index] 
					  ) { 
					$(this).siblings('.checkfalse').fadeIn(200); control = false;  } else { $(this).siblings('.checkfalse').fadeOut(200); 
				}
			}
			
		});
		
		
		if (!control) { return false; } else {
							
				var str = $form.serialize();
					
				$.ajax({
				   type: "POST",
				   url: form_action,
				   data: str,
				   success: function(msg){
					$form.siblings("#form-note").ajaxComplete(function(event, request, settings){
						$(this).html(msg);
						$(this).fadeIn(200);
					});
				   }
				});
				
				return false;
			
		} // END else {
		
	});
	
	
	/*---------------------------------------------- 
				   I S O T O P E   (masonry)
	------------------------------------------------*/
	var $container = $('#masonry');
	if (content == 'body') {
		$container.imagesLoaded( function(){
			$container.isotope({
				itemSelector : '.masonry_item'
			});	
		});
		
	}
	
	
	
	/*---------------------------------------------- 
				     F I L T E R
	------------------------------------------------*/
	// onclick reinitialise the isotope script
	$('.filter li a').click(function(){
		
		$('.filter li a').removeClass('active');
		$(this).addClass('active');
		
		var selector = $(this).attr('data-option-value');
		$container.isotope({ filter: selector });
		
		return(false);
	});
	
	
} // END function initialise()


$(document).ready(function($) {	

	initialise('body'); // call function
		
	
	/*---------------------------------------------- 
				 P A G I N T A I O N
	------------------------------------------------*/
	$('.pagination a').live('click', function(e){
		/*e.preventDefault();
		var page = $(this).attr('href');
		page = page.replace("?paged","?p=1&paged");
		page = page.replace("/page/","/p=0&paged="); 
		
		$('#main').load(page+' .main_inner', function() {
			setTimeout("initialise('body')", 500);
			
			$('html, body').delay(300).animate({
				scrollTop: $("#main").offset().top
			}, 500);
		});
		return(false);*/
	});
	
	
	var $container = $('#masonry');
	$('.additems a').live('click', function(e){
		e.preventDefault();
		var page = $(this).attr('href');
		page = page.replace("?paged","?p=0&paged"); 
		page = page.replace("/page/","/?p=0&paged="); 
				
		$('#caching-loadeditems').load(page+' #masonry', function() {
			
			setTimeout(function () {
				var $newEls = $($('#caching-loadeditems').html());
				$container.append( $newEls ).isotope( 'insert', $newEls ).isotope('reLayout');				 
			}, 500);

		});
		
		$('.additems').load(page+' .additems a', function() {
			if ($('.additems').html() == '') { $('.additems').delay(200).fadeout(200); }
		});
		
		return(false);
	});
	
	
	/*---------------------------------------------- 
				 S L I D E   U P 
	------------------------------------------------*/
	$('#slideup a').click(function() {
		$('.bottom_inner').slideToggle(600, $easingType);
		$(this).toggleClass('hide');
		return(false);
	});
	
});
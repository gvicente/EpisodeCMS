(function($) {
	var promoSliderTimers = [];
	$.fn.promoSlider = function(options) {
		var defaults = {
	    	slider: '.promo',
	    	navigation: true,
	    	auto:true,
	    	time:7000,
	    	loop:true
	    };
	    
	    var opts = $.extend(defaults, options);
		
	    function animateSlide(id, num){
			var current = $('#'+id).data('current');
			var width = $('#'+id).data('width');
			
			switch(num) {
				case('next'):
					var next = current+1;
					break;
				case('prev'):
					var next = current-1;
					break;
				default:
					var next = num;	
			}
							
			$('#'+id+'-prev').show();
			$('#'+id+'-next').show();

			if(opts.loop) { 
				if(next < 0)
					next = $('#'+id+' '+opts.slider).length-1;
				if(next > $('#'+id+' '+opts.slider).length-1)
					next = 0;	
			}
			
			if(next < 1) {
				$('#'+id+'-prev').hide();
				if(!opts.loop && next < 0) {
					if(opts.auto)
						clearInterval(promoSliderTimers[id]);
					return;
				}	
			}
			
			
			if(next > $('#'+id+' '+opts.slider).length-2) {
				$('#'+id+'-next').hide();
				if(!opts.loop && next > $('#'+id+' '+opts.slider).length-1) {
					if(opts.auto)
						clearInterval(promoSliderTimers[id]);
					return;
				}
			}
			
			$('#'+id+'-wrapper').animate({'margin-left':-width*next});
			$('#'+id+'-nav-'+current).removeClass('active');
			$('#'+id+'-nav-'+next).addClass('active');
			$('#'+id+'-nav-'+current).css({opacity:0.5});
			$('#'+id+'-nav-'+next).css({opacity:1});
			$('#'+id).data('current', next);
			return false;
		}		    

	    return this.each(function(e, obj){
		    var id = obj.id;
		    
			var $this = $(obj);
			var html = $this.html();
			
			$this.html('<div id="'+id+'-wrapper">'+html+'</div>');
			$('#'+id+'-wrapper').css({width:99999});
			
			if(opts.navigation) {
				$this.prepend('<a href="#" id="'+id+'-next" class="'+id+'-sides nav-sides next"></a><a href="#" id="'+id+'-prev" class="'+id+'-sides nav-sides prev"></a>');
				if(!opts.loop)
					$('#'+id+'-prev').hide();
				$('#'+id+'-next').click(function(){animateSlide(id, 'next');return false;});
				$('#'+id+'-prev').click(function(){animateSlide(id, 'prev');return false;});
			}
			
			if(opts.auto)
				promoSliderTimers[id] = setInterval(function(){animateSlide(id, 'next');}, opts.time);
			
			height = $this.css('height');
			bc = $this.css('background-color');
			width = parseInt($this.css('width').replace('px',''));
			pl = parseInt($this.css('padding-left').replace('px',''));
			pr = parseInt($this.css('padding-right').replace('px',''));
			$this.data('width', width+pl+pr);
			
			if(opts.navigation) {
				$('.'+id+'-sides').css({height:height, 'background-color':bc});
				navWidth = parseInt($('.nav-sides').css('width').replace('px',''));
				$('#'+id+'-next').css({'margin-left': width+pr-navWidth});
			}
			$('#'+id+' '+opts.slider).css({'float':'left', 'width':width+pl+pr});
			
			$this.after('<div id="'+id+'-nav"></div>');
			$('#'+id+' '+opts.slider).each(function(num){ 
				$('#'+id+'-nav').append('<a id="'+id+'-nav-'+num+'" href="#"></a>');
				
				if(opts.auto)
					$('#'+id+'-nav-'+num).hover(function(){
						clearInterval(promoSliderTimers[id]);
					}, function(){
						promoSliderTimers[id] = setInterval(function(){animateSlide(id, 'next');}, opts.time);
					});
				
				$('#'+id+'-nav-'+num).bind('click', function(){
					animateSlide(id, num);
					return false;
				})
			});
			$('#'+id+'-nav>a').css({display:'inline-block',background:'#9c0000',width:10,height:10,'margin-right':3,'-moz-border-radius':5,'border-radius':5,opacity:0.8,outline:'none'});
			
			$this.css({overflow:'hidden'});
			$this.data('current', 0);
			
			$('#'+id+'-nav-0').addClass('active');
			
		})
	}
})(jQuery); 
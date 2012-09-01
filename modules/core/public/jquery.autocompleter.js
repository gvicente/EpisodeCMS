(function($) {
	$.fn.autocompleter = function(options) {
		var defaults = {

	    };

	    var opts = $.extend(defaults, options);

	    return this.each(function(e, obj){

		    var id = obj.id;
			var $obj = $(obj);
			var $this = $('#'+id+' input');
			var $result = $('#'+id.replace('-autocomplete','')+'-list');
			var $input = $('#'+id.replace('-autocomplete',''));
			var $list = $('#'+id+'-list');
			var width = $this.width();

			if ($input.val()) {
				slugs = $input.val().split(',');
				text = '';
				$.each(slugs, function(i, slug){
					var $finded = $('a[slug='+slug+']', $list);
					title = $finded.text();
					$finded.remove();
					if(!title)
						title = slug;
					$result.append('<li>'+title+'<a slug="'+slug+'" class="'+id+' delete" href="#">x</a></li>');
				});
			}

			$this.after('<a id="'+id+'-add" class="add" href="#">»</a>');

			var $addButton = $('#'+id+'-add');

			function add(text, slug) {
				if(text.length) {
					if(!slug)
						slug = text;
					$result.append('<li>'+text+'<a slug="'+slug+'" class="'+id+' delete" href="#">x</a></li>');
					$this.val('');
	
					var ids = $input.val();
					if(ids!='')
						ids += ',';
					$input.val(ids + slug);
				}
			}

			$addButton.css({'margin-left':-23});

			$addButton.click(function(){
				add($this.val());
			})

			$list.css({position:'absolute',background:'#fff',padding:'5px','list-style':'none','margin-top':-1,width:width-10});
			$('#'+id+'-list li a').css({outline:'none'});
			$this.quicksearch('#'+id+'-list li');

			$this.keydown(function(e){
				$list.show();
				if(e.keyCode == 13) {
					add($this.val());
				}
			});

			$('#'+id+'-list li a').live('click', function(){
				add($(this).text(), $(this).attr('slug'));
				$(this).parent().remove();
				$list.hide();
				return false;
			});

			$('.'+id+'.delete').live('click', function(){
				var $parent = $(this).parent();
				$(this).remove();
				slug = $(this).attr('slug');
				$list.append('<li><a slug="'+slug+'" href="#">'+$parent.text()+'</a></li>');
				$parent.remove();
				$this.quicksearch('#'+id+'-list li');

				var ids = '';
				$('li a', $result).each(function(i, obj){
					slug = $(obj).attr('slug');
					if(ids!='')
						ids += ',';
					ids += slug;
				});
				$input.val(ids);
				return false;
			});

			$obj.hover(function(){

			}, function(){
				$list.hide();
			})
		})
	}
})(jQuery);
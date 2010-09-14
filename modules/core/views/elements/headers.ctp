<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title><?php echo $title_for_layout; ?></title>
	<meta name="description" content="<?php echo $description ?>">
	<meta name="keywords" content="<?php echo $keywords ?>">
	<meta name="generator" content="EpisodeCMS" />
	<meta name='yandex-verification' content='510cbae5d470308a' />
	<?php 
	foreach($scripts as $script) {
		echo $javascript->link($script);
	}
	foreach($styles as $style) {
		echo $html->css($style);
	}?>
	<script>
		(function($) {
			$.url = function (link, themed) {
				if(!themed) {
					link = link.substring(1,link.length);
					url = 'http://<?php echo $_SERVER['SERVER_NAME'].$html->url('/');?>'+link;
				} else {
					url = 'http://<?php echo $_SERVER['SERVER_NAME'].$html->url('/themes/'.$site_theme.'/'); ?>'+link;
				}
				
				return url; 	
			}
		})(jQuery); 
			
		$(function(){
			$('.htmleditor').tinymce({
				script_url : $.url('/modules/core/public/tinymce/tiny_mce.js'),
				content_css : $.url("content.css", true),
				theme : "advanced",
				skin : "o2k7",
				width:'100%',
				skin_variant : "silver",
				plugins : "safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
				theme_advanced_buttons1 : "fullscreen,formatselect,styleselect,removeformat,bold,italic,strikethrough,|,bullist,numlist,outdent,indent,blockquote,|,link,unlink,|,image,|,cite,abbr,acronym,del,ins,|,blockquote,pagebreak,spellchecker",
				theme_advanced_buttons2 : "",
				theme_advanced_toolbar_location : "top",
				theme_advanced_toolbar_align : "left",
				theme_advanced_statusbar_location : "none",
				theme_advanced_resizing : false
			});	
		});	
	</script>
</head>

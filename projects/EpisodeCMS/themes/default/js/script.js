/* Author: Aleksey Razbakov */
(function($){
    $(function(){
        var validEmail = /^((([a-z]|[0-9]|!|#|$|%|&|'|\*|\+|\-|\/|=|\?|\^|_|`|\{|\||\}|~)+(\.([a-z]|[0-9]|!|#|$|%|&|'|\*|\+|\-|\/|=|\?|\^|_|`|\{|\||\}|~)+)*)@((((([a-z]|[0-9])([a-z]|[0-9]|\-){0,61}([a-z]|[0-9])\.))*([a-z]|[0-9])([a-z]|[0-9]|\-){0,61}([a-z]|[0-9])\.)[\w]{2,4}|(((([0-9]){1,3}\.){3}([0-9]){1,3}))|(\[((([0-9]){1,3}\.){3}([0-9]){1,3})\])))$/;
        var animationEffect = 'easeInQuint';
        var animationTime = 600;
        var screenWidth = window.innerWidth;
        var screenHeight = window.innerHeight;

        $.fn.tooltip = function() {
            var id = $(this).attr('id');
            var tip_id = 'tooltip-for-'+id;
            var tooltip = $('#'+tip_id);
            return tooltip;
        };

        $.fn.enter = function(fn){
            $(this).keydown(function(e){
                if(e.keyCode == 13) {
                    fn();
                }
            });
        }

        $('[switch]').focus(function(){
            var switchText = $(this).val();
            var tipTitle = $(this).attr('title');
            $(this).val('');
            $(this).blur(function(){
                $(this).val(switchText);
                $(this).tooltip().html(tipTitle);
                $(this).tooltip().attr('class', 'tooltip');
            });
        });
        
        $('[tooltip]').each(function(){
            var title = $(this).attr('title');
            var id = $(this).attr('id');
            var tip_id = 'tooltip-for-'+id;
            var elem = document.getElementById(id);
            $(this).after('<span id="'+tip_id+'" class="tooltip" style="display:none">'+title+'</span>');

            $(this).tooltip().css({
                left:  elem.offsetLeft,
                top:   elem.offsetTop + elem.offsetHeight + 7,
                width: elem.offsetWidth
            });
            $(this).focus(function(){
                $(this).tooltip().show();
            });
            $(this).blur(function(){
                $(this).tooltip().hide();
            });
        });

        $('.newsletter').enter(function(){
            $this = $('.newsletter');
            if(validEmail.test($this.val())) {
                $this.tooltip().attr('class','tooltip success').html($this.attr('success'));
                $this.val('');
            } else {
                $this.tooltip().attr('class','tooltip error').html($this.attr('error'));
            }
        });
    });
})(window.jQuery);

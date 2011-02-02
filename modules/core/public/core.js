(function($){
    $.fn.tooltip = function() {
        var id = $(this).attr('id');
        var tip_id = 'tooltip-for-'+id;
        var tooltip = $('#'+tip_id);
        return tooltip;
    };

    $.fn.window = function() {
        var window_id = $(this).attr('window');
        var window = $('#'+window_id);
        return window;
    };

    $.fn.enter = function(fn){
        $(this).keydown(function(e){
            if(e.keyCode == 13) {
                fn();
            }
        });
    }
})(window.jQuery);

App = {
    current: '',
    components: {
        widget: {},
        action: {}
    },
    run: function(action, filter) {
        for (i in this.components) {
            for (j in this.components[i]) {
                for (k in this.components[i][j]) {
                    try {
                        switch (action) {
                            case('update'):
                                this.components[i][j][k].update();
                                break;
                            case('init'):
                                this.components[i][j][k].init();
                                break;
                        }
                    } catch(error) {

                    }
                }
            }
        }
    },
    add: function(component, id, module) {
        if(typeof this.components[component][id] == 'undefined')
            this.components[component][id] = [];
        this.components[component][id][this.components[component][id].length] = module;
    }
};

App.add('action', '*', {
    init: function() {
        $('[switch]').focus(function(){
            var switchText = $(this).val();
            var tipTitle = $(this).attr('tooltip');
            $(this).val('');
            $(this).blur(function(){
                $(this).val(switchText);
                $(this).tooltip().html(tipTitle);
                $(this).tooltip().attr('class', 'tooltip');
            });
        });

        $('[tooltip]').each(function(){
            var $this = $(this);
            var title = $this.attr('tooltip');
            var id = $this.attr('id');
            if (!id) {
                $.tips_id = $.tips_id || 1;
                id = 'tip-' + ++$.tips_id;
                $this.attr('id', id);
            }
            var tip_id = 'tooltip-for-'+id;
            $this.after('<span id="'+tip_id+'" class="tooltip" style="display:none">'+title+'</span>');
            var elem = document.getElementById(id);
            
            $(this).tooltip().css({
                position: 'absolute',
                left:  elem.offsetLeft,
                top:   elem.offsetTop + elem.offsetHeight + 2,
                width: elem.offsetWidth
            });
            if (this.tagName == 'INPUT' || this.tagName == 'TEXTAREA') {
                $this.focus(function(){
                    $this.tooltip().show();
                });
                $this.blur(function(){
                    $this.tooltip().hide();
                });
            } else {
                $this.hover(function(){
                    $this.tooltip().show();
                }, function(){
                    $this.tooltip().hide();
                });
            }
        });

        $('[window]').each(function(){
            var window = $(this).attr('window');
            var id = $(this).attr('id');
            var $this = $(this);
            $this.window().css({position:'absolute', top: $this.offset().top + $this.height() + 9, left: $this.offset().left, 'z-index': 9000, display: 'none'});
            $this.click(function(){
                $this.window().css({position:'absolute', top: $this.offset().top + $this.height() + 9, left: $this.offset().left, 'z-index': 9000, display: 'none'});
                if ($this.hasClass('active')) {
                    $this.window().hide();
                    $this.removeClass('active');
                } else {
                    $this.window().show();
                    $this.addClass('active');
                }
                return false;
            });
        });

        $('.select a').click(function(){
            $this = $(this);
            $li = $this.parent();
            $ul = $li.parent();
            $('li', $ul).removeClass('filter-active');
            $li.addClass('filter-active');
            return false;
        });
    }
})

// usage: log('inside coolFunc',this,arguments);
// paulirish.com/2009/log-a-lightweight-wrapper-for-consolelog/
window.log = function(){
  log.history = log.history || [];   // store logs to an array for reference
  log.history.push(arguments);
  if(this.console){
    console.log( Array.prototype.slice.call(arguments) );
  }
};



// catch all document.write() calls
(function(doc){
  var write = doc.write;
  doc.write = function(q){
    log('document.write(): ',arguments);
    if (/docwriteregexwhitelist/.test(q)) write.apply(doc,arguments);
  };
})(document);

$(document).ready(function() {
    App.run('init');
    App.run('update');
});
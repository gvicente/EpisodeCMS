App.add('action', '*', {
    update: function() {
        $('.button').each(function(){
            if($('span', $(this)).length == 0)
                $(this).prepend('<span>');
        });

        $('li').each(function(){
            var $this = $(this);
            if ($('ul li', $this).length > 0)
                $this.addClass('childs');
        });
    }
});

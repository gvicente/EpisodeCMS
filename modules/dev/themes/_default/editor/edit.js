$('.dev-editor-options li span').click(function() {
    $item = $(this).parent();
    $list = $item.parent();
    $('li', $list).removeClass('active');
    $item.addClass('active');
});
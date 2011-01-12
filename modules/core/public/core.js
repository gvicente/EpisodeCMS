App = {
    widgets: {},
    init: function() {
        for (i in this.widgets) {
            this.widgets[i].init();
        }

    },
    widget: function(id, module) {
        this.widgets[id] = module;
    }
};

$(document).ready(function() {
    App.init();
    
    $('#content').before('<div id="loading">Loading</div>');
    $('#loading').hide();

	// Check if url hash value exists (for bookmark)
//	$.history.init(pageload);
	    
	// Highlight the selected link
	$('a[href=' + document.location.hash + ']').addClass('selected');
	
	// Search for link with REL set to ajax
	$('a[rel=ajax]').click(function () {
		
		// Grab the full url
		var hash = this.href;
		
		// Remove the # value
		hash = hash.replace(/^.*#/, '');
		
		// For back button
//	 	$.history.load(hash);
	 	
	 	// Clear the selected class and add the class class to the selected link
	 	$('a[rel=ajax]').removeClass('selected');
	 	$(this).addClass('selected');
	 	
	 	// Hide the content and show the progress bar
	 	$('#content').hide();
	 	$('#loading').show();
	 	
	 	// Run the ajax
		getPage($(this).attr('href'));
	
		// Cancel the anchor tag behaviour
		return false;
	});	
});

function pageload(hash) {
	// If hash value exists, run the ajax
	if (hash)
        getPage();
}
		
function getPage(page) {
    if(!page)
        page = document.location.hash.replace(/^.*#/, '');

    page += '.json?html';

	if (page[0]=='/')
        $('#content').load(page, function () {
			$('#loading').hide();
			$('#content').show();
		});
}

function __(str) {
    return str;
}
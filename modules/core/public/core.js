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
            // $.history.load(hash);

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
    }
})

$(document).ready(function() {
    App.run('init');
    App.run('update');
});

function pageload(hash) {
	// If hash value exists, run the ajax
	if (hash)
        getPage();
}
		
function getPage(page) {
    if(!page)
        page = document.location.hash.replace(/^.*#/, '');
    filter = page;
    page += '.json?html';

	if (page[0]=='/')
        $('#content').load(page, function () {
            App.updated = false;
			$('#loading').hide();
			$('#content').show();
            App.run('update');
		});
}

function __(str) {
    return str;
}
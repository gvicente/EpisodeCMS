$(document).ready(function () {
	//Check if url hash value exists (for bookmark)
	$.history.init(pageload);	
	    
	//highlight the selected link
	$('a[href=' + document.location.hash + ']').addClass('selected');
	
	//Seearch for link with REL set to ajax
	$('a[rel=ajax]').click(function () {
		
		//grab the full url
		var hash = this.href;
		
		//remove the # value
		hash = hash.replace(/^.*#/, '');
		
		//for back button
	 	$.history.load(hash);	
	 	
	 	//clear the selected class and add the class class to the selected link
	 	$('a[rel=ajax]').removeClass('selected');
	 	$(this).addClass('selected');
	 	
	 	//hide the content and show the progress bar
	 	$('#content').hide();
	 	$('#loading').show();
	 	
	 	//run the ajax
		getPage();
	
		//cancel the anchor tag behaviour
		return false;
	});	
});

function pageload(hash) {
	//if hash value exists, run the ajax
	if (hash) getPage();    
}
		
function getPage() {
	page = document.location.hash.replace(/^.*#/, '')+'.json?html';
	if(page[0]=='/')
		$('#content').load(page, function () {
			$('#loading').hide();	
			$('#content').fadeIn('slow');		
		});
}
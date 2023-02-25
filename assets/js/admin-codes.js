/*
	This file holds the codes that are used on backed / in wp-admin
*/


/////////////////////////////////////////////////
// 1. HELPER FUNCTIONS                         //
/////////////////////////////////////////////////

	// on load
	window.addEventListener('load', function() {
		if(location.href.indexOf('page=nf-submissions') > -1) {
			// If we are on submissions page, we want to keep checking submissions from time to time
			// in case the page is changed or filter updated, etc.
			setInterval(ziggeoninjaformsSubmissionsCreatePreview, 4000);
		}
	});




/////////////////////////////////////////////////
// 1. SUBMISSIONS                              //
/////////////////////////////////////////////////

// Shows the preview insead of the code preview
function ziggeoninjaformsSubmissionsCreatePreview() {
	ns_cells = document.getElementsByClassName('nf-submissions-cell');

	for(i = 0, c = ns_cells.length; i < c; i++) {
		if(ns_cells[i].innerText.indexOf('&amp;lt;ziggeoplayer') > -1) {
			ns_cells[i].innerHTML = ns_cells[i].innerText.replaceAll('&amp;', '&').replaceAll('&quot;', '"').replaceAll('&lt;', '<').replaceAll('&gt;', '>');
			ns_cells[i].style.minHeight = '240px';
		}
	}
}




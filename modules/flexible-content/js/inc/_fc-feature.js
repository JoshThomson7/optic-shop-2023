/*
--------------------------------------------
    ______           __                
   / ____/__  ____ _/ /___  __________ 
  / /_  / _ \/ __ `/ __/ / / / ___/ _ \
 / __/ /  __/ /_/ / /_/ /_/ / /  /  __/
/_/    \___/\__,_/\__/\__,_/_/   \___/ 
                                       
-------------------------------------------
Feature
*/

jQuery(document).ready(function($){ 

	$('.do-modal-video').modalVideo();

	$(document).on('click', '.feature__action .has-dropdown', function(e) {
		e.preventDefault();
		$('.feature__action-dropdown').toggleClass('is-active');
	});

});
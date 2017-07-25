jQuery(document).ready(function($){
	//Slide toggle to preview the video
	$(document).on('click', '#bpfit-preview-video', function(){
		window.open( $(this).data('video'), 'pagename', 'resizable,height=600,width=700' );
		return false;
	});
});
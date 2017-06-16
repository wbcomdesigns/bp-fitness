jQuery(document).ready(function($){
	//Slide toggle to preview the video
	$(document).on('click', '#bpfit-preview-video', function(){
		$('.bpfit-preview-video-panel').slideToggle();
	});
});
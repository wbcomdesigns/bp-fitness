jQuery(document).ready(function($){

	//Slide toggle to update users new weight
	$(document).on('click', '#bpfit-edit-weight', function(){
		$('.bpfit-update-your-weight-panel').slideToggle();
		$('#bpfit-your-new-weight').focus();
	});

	$(document).on('keyup', '#bpfit-your-new-weight', function(){
		if( $(this).val() < 1 ) {
			$('#bpfit-update-your-weight').attr( 'disabled','disabled' );
		} else {
			$('#bpfit-update-your-weight').removeAttr( 'disabled' );
		}
	});
	//Update users new weight
	$(document).on('click', '#bpfit-update-your-weight', function(){
		var weight = $('#bpfit-your-new-weight').val();
		$(this).val('Updating..');
		var data = {
			'action' : 'bpfit_update_weight',
			'weight' : weight
		}
		$.ajax({
			dataType: "JSON",
			url: bpfit_front_js_object.ajaxurl,
			type: 'POST',
			data: data,
			success: function( response ) {
				$('.bpfit-weight-updated').html( response['data']['message'] ).show();
				$('#bpfit-update-your-weight').val('Update');
			},
		});
	});

	//Slide toggle walk edit panel
	$(document).on('click', '.bpfit-edit-walk', function(){
		var panel = $(this).data('panel');
		$('#bpfit-walk-edit-panel-'+panel).slideToggle();
	});

	//Open Modal
	$(document).on('click', '.show-modal', function () {
		$('#bpfit-daily-steps-modal').css('display', 'block');
	});

	// When the user clicks on <span> (x), close the modal
	$(document).on('click', '.close-modal', function () {
		$('#bpfit-daily-steps-modal').css('display', 'none');
	});

	// When the user clicks anywhere outside of the modal, close it
	$(document.body).click(function (event) {
		var daily_walk_modal = document.getElementById('bpfit-daily-steps-modal');
		if (event.target == daily_walk_modal) {
			$('#bpfit-daily-steps-modal').css('display', 'none');
		}
	});
});
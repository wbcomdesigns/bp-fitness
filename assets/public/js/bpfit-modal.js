jQuery(document).ready(function($){
	//Open Modal
	if( bpfit_modal_js_object.todays_walk_saved == 'no' ) {
		$('#bpfit-daily-steps-modal').css('display', 'block');
	}

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

	//Update the daily kilometers
	$(document).on('click', '#bpfit-update-daily-walk-kms', function(){
		var kms = $( '#bpfit-daily-walk-kms' ).val();
		if( kms == '' ) {
			$( '#bpfit-daily-walk-kms' ).addClass('bpfit-daily-walk-kms-empty').attr('placeholder', 'Please enter the kms walked!');
		} else if( kms < 0 ) {
			$( '#bpfit-daily-walk-kms' ).val('').addClass('bpfit-daily-walk-kms-empty').attr('placeholder', 'Kms walked cannot be in negative!');
		} else {
			$('#bpfit-update-daily-walk-kms').val('Updating...');
			var data = {
				'action' : 'bpfit_update_daily_walk',
				'kms' : kms
			}
			$.ajax({
				dataType	:"JSON",
				url			: bpfit_modal_js_object.ajaxurl,
				type 		: 'POST',
				data 		: data,
				success: function( response ) {
					$('.bpfit-daily-walk-updated').html( response['data']['message'] ).show();
					$('#bpfit-update-daily-walk-kms').val('Update');
				},
			});
		}
	});
});
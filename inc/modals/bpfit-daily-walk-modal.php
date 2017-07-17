<?php
defined( 'ABSPATH' ) || exit; // Exit if accessed directly
?>
<div id="bpfit-daily-steps-modal" class="modal">
	<!-- Modal content -->
	<div class="modal-content">
		<div class="modal-header">
			<span class="close close-modal">&times;</span>
			<h2><?php _e( 'Completed your walk today?', BPFIT_TEXT_DOMAIN );?></h2>
		</div>
		<div class="modal-body">
			<div class="bpfit-today-walk-panel">
				<div class="bpfit-update-your-daily-walk">
					<p class="bpfit-success bpfit-daily-walk-updated"></p>
					<input type="number" min="0" placeholder="<?php _e( 'Kilometers', BPFIT_TEXT_DOMAIN );?>" id="bpfit-daily-walk-kms" />
					<input type="button" value="<?php _e( 'Update', BPFIT_TEXT_DOMAIN );?>" id="bpfit-update-daily-walk-kms" />
				</div>
			</div>
		</div>
	</div>
</div>
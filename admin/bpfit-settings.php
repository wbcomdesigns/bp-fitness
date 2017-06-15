<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

//Save General Settings
if( isset( $_POST['bpfit-general-settings-submit'] ) ) {
	$settings_validations_errors = array();
	echo $video_url = sanitize_text_field( $_POST['bpfit-video-url'] );
}
?>
<div class="wrap">
	<h3><?php _e("General Settings", "bp-fitness"); ?></h3>
	<div class="bpfit-general-settings-container">
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row"><label for="video-url"><?php _e( 'Video URL', 'bp-fitness' );?></label></th>
					<td><input required name="bpfit-video-url" type="text" id="bpfit-video-url" class="regular-text" placeholder="<?php _e( 'Video URL', 'bp-fitness' );?>"></td>
				</tr>
			</tbody>
		</table>
		<p class="submit"><input type="submit" name="bpfit-general-settings-submit" class="button button-primary" value="<?php _e("Save Changes","bp-fitness"); ?>"></p>
	</div>
</div>
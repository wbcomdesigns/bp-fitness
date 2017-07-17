<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

//Save General Settings
if( isset( $_POST['bpfit-general-settings-submit'] ) ) {
	$settings_validations_errors = $bpfit_general_settings = array();

	/************************** VIDEO VALIDATION **************************/
	$video_url = sanitize_text_field( $_POST['bpfit-video-url'] );
	$is_url = Bpfit_Hooks::is_url( $video_url );
	if( $is_url === false ) {
		$settings_validations_errors[] = 'The URL entered is not a valid URL!';
	} else {
		/**
		 * Its a valid URL
		 * Check the type of the video, if its a youtube, or vimeo or any other
		 */
		$video_type = Bpfit_Hooks::get_video_type( $video_url );

		if( $video_type == 'other' ) {
			/**
			 * Check if the URL entered is a video URL
			 */
			$headers = get_headers( $video_url );
			$video_exist = implode( ',', $headers );
			if( stripos( $video_exist, 'video' ) === false ) {
				$settings_validations_errors[] = 'The URL entered does not contain a video!';
			} else {
				$video_settings = array(
					'video_type' => $video_type,
					'video_url' => $video_url
				);
				$bpfit_general_settings['video_settings'] = $video_settings;
			}
		} else {
			$video_settings = array(
				'video_type' => $video_type,
				'video_url' => $video_url
			);
			$bpfit_general_settings['video_settings'] = $video_settings;
		}
	}

	/************************** PAST DATES **************************/
	$bpfit_general_settings['past_dates_settings'] = sanitize_text_field( $_POST['bpfit-past-dates'] );

	/************************** BADGE OS POINTS / STEPS **************************/
	$bpfit_general_settings['badgeos_points_settings'] = sanitize_text_field( $_POST['bpfit-badgeos-points'] );
	$bpfit_general_settings['steps_walked_settings'] = sanitize_text_field( $_POST['bpfit-steps-walked'] );

	/**
	 * Check if there are any errors
	 */
	if( !empty( $settings_validations_errors ) ) {
		$err_msg = "<div class='error is-dismissible' id='message'>";
		foreach ( $settings_validations_errors as $key => $failure ) {
			$err_msg .= "<p>".__( $failure, BPFIT_TEXT_DOMAIN )."</p>";
		}
		$err_msg .= "</div>";
		echo $err_msg;
	} else {
		// echo '<pre>'; print_r( $bpfit_general_settings ); die;
		update_option( 'bpfit_general_settings', $bpfit_general_settings );
		$success_msg = "<div class='notice updated is-dismissible' id='message'>";
		$success_msg .= "<p>".__( 'BuddyPress Fitness Settings Saved.', BPFIT_TEXT_DOMAIN )."</p>";
		$success_msg .= "</div>";
		echo $success_msg;
	}
}

//Retrieve Settings
$settings = get_option( 'bpfit_general_settings', true );
$video_url = $past_dates = '';
if( isset( $settings['video_settings'] ) ) {
	$video_type = $settings['video_settings']['video_type'];
	$video_url = $settings['video_settings']['video_url'];
}

if( isset( $settings['past_dates_settings'] ) ) {
	$past_dates = $settings['past_dates_settings'];
}

if( isset( $settings['badgeos_points_settings'] ) ) {
	$badgeos_points = $settings['badgeos_points_settings'];
}

if( isset( $settings['steps_walked_settings'] ) ) {
	$steps_walked = $settings['steps_walked_settings'];
}

//echo '<pre>'; print_r( $settings ); die;
?>
<div class="wrap">
	<h3><?php _e("General Settings", "bp-fitness"); ?></h3>
	<div class="bpfit-general-settings-container">
		<table class="form-table">
			<tbody>
				<!-- VIDEO SETTINGS -->
				<tr>
					<th scope="row">
						<label for="video-url"><?php _e( 'Video URL', BPFIT_TEXT_DOMAIN );?></label>
					</th>
					<td>
						<input required name="bpfit-video-url" type="text" id="bpfit-video-url" class="regular-text" placeholder="<?php _e( 'Video URL', BPFIT_TEXT_DOMAIN );?>" value="<?php echo $video_url;?>">
						<?php if( isset( $settings['video_settings'] ) ) {?>
							<input type="button" class="button button-secondary" id="bpfit-preview-video" value="<?php _e( 'Preview', BPFIT_TEXT_DOMAIN );?>">
						<?php }?>
						<p class="description"><?php _e( 'This is the Video URL that\'ll manage user\'s fitness. Get points while playing it.', BPFIT_TEXT_DOMAIN );?></p>
						<?php
						if( isset( $settings['video_settings'] ) ) {
							if( $video_type == 'youtube' ) {
								$exploded_url = explode( '=', $video_url );
								$video_code = $exploded_url[1];
								$iframe_src = 'http://www.youtube.com/embed/'.$video_code.'?enablejsapi';
							} elseif ( $video_type == 'vimeo' ) {
								$exploded_url = explode( '/', $video_url );
								$video_code_index = count($exploded_url) - 1;
								$video_code = $exploded_url[$video_code_index];
								$iframe_src = 'http://player.vimeo.com/video/'.$video_code;
							} else {
								$iframe_src = $video_url;
							}
							echo '<div class="bpfit-preview-video-panel"><iframe width="520" height="360" src="'.$iframe_src.'" frameborder="0" allowtransparency="true" allowfullscreen></iframe></div>';
						}
						?>
					</td>
				</tr>

				<!-- NO. OF PAST DAYS FOR WALK AVERAGE SETTINGS -->
				<tr>
					<th scope="row">
						<label for="walk-avg-dates"><?php _e( 'Number Of Past Dates To Show Walk Average', BPFIT_TEXT_DOMAIN );?></label>
					</th>
					<td>
						<input required name="bpfit-past-dates" type="number" min="1" class="regular-text" placeholder="<?php _e( 'No. Of Past Dates', BPFIT_TEXT_DOMAIN );?>" value="<?php echo $past_dates;?>">
						<p class="description"><?php _e( 'This is the past number of dates that the user will get average of his walking. Will be shown on the profile page.', BPFIT_TEXT_DOMAIN );?></p>
					</td>
				</tr>

				<!-- BADGE OS POINTS ASSIGNING -->
				<tr>
					<th scope="row">
						<label for="badgeos-points"><?php _e( 'BadgeOs Points on Steps', BPFIT_TEXT_DOMAIN );?></label>
					</th>
					<td>
						<p>
							<?php _e( 'Points Scored: ', BPFIT_TEXT_DOMAIN );?>
							<input required name="bpfit-badgeos-points" type="number" min="1" class="regular-text" placeholder="<?php _e( 'BadgeOs Points', BPFIT_TEXT_DOMAIN );?>" value="<?php echo $badgeos_points;?>">
						</p>
						<p>
							<?php _e( 'Steps Walked: ', BPFIT_TEXT_DOMAIN );?>
							<input required name="bpfit-steps-walked" type="number" min="1" class="regular-text" placeholder="<?php _e( 'Steps', BPFIT_TEXT_DOMAIN );?>" value="<?php echo $steps_walked;?>">
						</p>
						<p class="description"><?php _e( 'You can assign the number of points the user will get as per the number of steps he walks on daily purpose.', BPFIT_TEXT_DOMAIN );?></p>
					</td>
				</tr>
			</tbody>
		</table>
		<p class="submit"><input type="submit" name="bpfit-general-settings-submit" class="button button-primary" value="<?php _e('Save Changes', BPFIT_TEXT_DOMAIN); ?>"></p>
	</div>
</div>
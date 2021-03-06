<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $bpfitness;
if( !empty( $bpfitness->video_url ) ) {
	$video_url = $bpfitness->video_url;
	$video_type = $bpfitness->video_type;
}
// echo '<pre>'; print_r( $bpfitness ); die;
?>
<div class="wrap">
	<h3><?php _e("General Settings", "bp-fitness"); ?></h3>
	<div class="bpfit-general-settings-container">
		<table class="form-table">
			<tbody>
				<!-- PROFILE MENU LABEL -->
				<tr>
					<th scope="row"><label for="bpfit-profile-menu-label"><?php _e( 'Profile Menu Label', BPFIT_TEXT_DOMAIN );?></label></th>
					<td>
						<input type="text" placeholder="<?php _e( 'Label', BPFIT_TEXT_DOMAIN );?>" name="bpfit-profile-menu-label" value="<?php echo $bpfitness->profile_menu_label;?>" class="regular-text" required>
						<p class="description"><?php _e( 'This label will be seen in the profile menu(Please make sure you enter <strong>singular</strong> text).', BPFIT_TEXT_DOMAIN );?></p>
					</td>
				</tr>
				<!-- VIDEO SETTINGS -->
				<tr>
					<th scope="row">
						<label for="video-url"><?php _e( 'Video URL', BPFIT_TEXT_DOMAIN );?></label>
					</th>
					<td>
						<input required name="bpfit-video-url" type="text" id="bpfit-video-url" class="regular-text" placeholder="<?php _e( 'Video URL', BPFIT_TEXT_DOMAIN );?>" value="<?php echo $bpfitness->video_url;?>">
						<?php if( !empty( $bpfitness->video_url ) ) {?>
							<input type="button" class="button button-secondary" id="bpfit-preview-video" value="<?php _e( 'Preview', BPFIT_TEXT_DOMAIN );?>" data-video="<?php echo $video_url;?>">
						<?php }?>
						<p class="description"><?php _e( 'This is the Video URL that\'ll manage user\'s fitness. Get points while playing it.', BPFIT_TEXT_DOMAIN );?></p>
					</td>
				</tr>

				<!-- NO. OF PAST DAYS FOR WALK AVERAGE SETTINGS -->
				<tr>
					<th scope="row">
						<label for="walk-avg-dates"><?php _e( 'Number Of Past Dates To Show Walk Average', BPFIT_TEXT_DOMAIN );?></label>
					</th>
					<td>
						<input required name="bpfit-past-dates" type="number" min="1" class="regular-text" placeholder="<?php _e( 'No. Of Past Dates', BPFIT_TEXT_DOMAIN );?>" value="<?php echo $bpfitness->past_dates;?>">
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
							<input required name="bpfit-badgeos-points" type="number" min="1" class="regular-text" placeholder="<?php _e( 'BadgeOs Points', BPFIT_TEXT_DOMAIN );?>" value="<?php echo $bpfitness->badgeos_points;?>">
						</p>
						<p>
							<?php _e( 'Steps Walked: ', BPFIT_TEXT_DOMAIN );?>
							<input required name="bpfit-steps-walked" type="number" min="1" class="regular-text" placeholder="<?php _e( 'Steps', BPFIT_TEXT_DOMAIN );?>" value="<?php echo $bpfitness->steps_walked;?>">
						</p>
						<p class="description"><?php _e( 'You can assign the number of points the user will get as per the number of steps he walks on daily purpose.', BPFIT_TEXT_DOMAIN );?></p>
					</td>
				</tr>
			</tbody>
		</table>
		<p class="submit"><input type="submit" name="bpfit-general-settings-submit" class="button button-primary" value="<?php _e('Save Changes', BPFIT_TEXT_DOMAIN); ?>"></p>
	</div>
</div>
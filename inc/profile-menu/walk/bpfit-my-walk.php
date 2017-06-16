<?php
defined( 'ABSPATH' ) || exit; // Exit if accessed directly
global $bp;
$user_id = bp_displayed_user_id();
$settings = get_option( 'bpfit_general_settings', true );
$past_dates = 7;
if( isset( $settings['past_dates_settings'] ) ) {
	$past_dates = $settings['past_dates_settings'];
}
$last_n_dates = Bpfit_Hooks::get_last_n_dates( $past_dates, 'F jS, Y' );
// echo '<pre>'; print_r( $last_n_dates ); die;
$my_avg_walk = '';
?>
<div class="bpfit-your-walk-content">
	<!-- SHOW MY WALK FOR PAST 'N' DAYS -->
	<div class="bpfit-show-your-walk">
		<h3><?php _e( 'My walk record of past '.$past_dates.' days -', 'bp-fitness' );?></h3>
		<?php foreach( $last_n_dates as $key => $last_date ) {?>
			<?php $steps = 0;?>
			<p>
				<?php _e( 'Steps walked on: <strong>'.$last_date.'</strong> : <i>'.$steps.'</i>', 'bp-fitness' );?>
				<a href="javascript:void(0);" class="bpfit-edit-walk" data-panel="<?php echo $key;?>"><?php _e( 'Edit', 'bp-fitness' );?></a>
				<div id="bpfit-walk-edit-panel-<?php echo $key;?>" class="bpfit-walk-edit-panel">
					<p class="bpfit-success bpfit-walk-updated"></p>
					<input type="number" placeholder="<?php _e( 'Your Walked Steps', 'bp-fitness' );?>" id="bpfit-" />
					<input type="button" value="<?php _e( 'Update', 'bp-fitness' );?>" id="bpfit-update" />
				</div>
			</p>
		<?php }?>
	</div>

	<a href="javascript:void(0)" class="show-modal">Show Modal</a>
</div>
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
<div class="tabs">
	<ul class="tab-links">
		<li class="active"><a href="#tab1">Daily Walk</a></li>
		<li><a href="#tab2">Watching Video</a></li>
	</ul>

	<div class="tab-content bpfit-your-walk-content">
		<div id="tab1" class="tab active">
			<?php include 'templates/bpfit-daily-walk-record.php';?>
		</div>

		<div id="tab2" class="tab">
			<?php include 'templates/bpfit-watch-video-n-record.php';?>
		</div>
	</div>
</div>
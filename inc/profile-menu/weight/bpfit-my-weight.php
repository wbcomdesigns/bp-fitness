<?php
defined( 'ABSPATH' ) || exit; // Exit if accessed directly
global $bp;
$user_id = bp_displayed_user_id();
$my_weight = get_user_meta( $user_id, 'my_weight', true );
if( $my_weight == '' ) {
	$my_weight = '--';
} else {
	$my_weight = $my_weight.' kgs.';
}

//Weight comparison
$user_count = $total_weight = 0;
foreach ( get_users() as $key => $user ) {
	$user_weight = get_user_meta( $user->ID, 'my_weight', true );
	if( $user_weight != '' ) {
		$user_count++;
		$total_weight += $user_weight;
	}
	//echo '<pre>'; print_r( $user ); die;
}
$avg_weight = '';
?>
<div class="bpfit-your-weight-content">
	<!-- COMPARISON OF MY WEIGHT FROM OTHERS -->
	<?php if( $total_weight !== 0 ) {?>
		<!-- CHECK IF I'M THE ONLY ONE TO SAVE MY WEIGHT -->
		<?php if( $my_weight == $total_weight ) {?>
			<?php $weight_compare_msg = __( 'Oooops! Nobody else has updated his/her weight.', 'bp-fitness' );?>
			<?php $weight_compare_msg_id = 'bpfit-only-my-weight-to-compare';?>
		<?php } else {?>
		<?php }?>
		<div class="bpfit-weights-comparison">
			<p><?php _e( 'Weight Comparison: <label id="'.$weight_compare_msg_id.'">'.$weight_compare_msg.'</label>', 'bp-fitness' );?></p>
		</div>
	<?php }?>
	<!-- SHOW MY WEIGHT -->
	<div class="bpfit-show-your-weight">
		<p>
			<?php _e( 'My weight', 'bp-fitness' );?>: <?php echo $my_weight;?>
			<?php if( bp_loggedin_user_id() === bp_displayed_user_id() ) {?>
				<a href="javascript:void(0);" title="<?php _e( 'Click to update your weight!', 'bp-fitness' );?>" id="bpfit-edit-weight">
					<?php _e( 'Edit', 'bp-fitness' );?>
				</a>
			<?php }?>
		</p>
	</div>
	<!-- UPDATE MY NEW WEIGHT -->
	<div class="bpfit-update-your-weight-panel">
		<p class="bpfit-success bpfit-weight-updated"></p>
		<input type="number" placeholder="<?php _e( 'Your Weight', 'bp-fitness' );?>" id="bpfit-your-new-weight" />
		<input type="button" value="<?php _e( 'Update', 'bp-fitness' );?>" id="bpfit-update-your-weight" />
	</div>
</div>
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
?>
<div class="bpfit-my-weight-content">
	<p>
		<?php _e( 'My weight', 'bp-fitness' );?>: <?php echo $my_weight;?>
		<?php if( bp_loggedin_user_id() === bp_displayed_user_id() ) {?>
			<a href="javascript:void(0);" title="<?php _e( 'Click to update your weight!', 'bp-fitness' );?>" id="bpfit-edit-weight">
				<?php _e( 'Edit', 'bp-fitness' );?>
			</a>
		<?php }?>
	</p>
	<div class="bpfit-update-your-weight-panel">
		<p class="bpfit-success bpfit-weight-updated"></p>
		<input type="number" placeholder="<?php _e( 'Your Weight', 'bp-fitness' );?>" id="bpfit-your-new-weight" />
		<input type="button" value="<?php _e( 'Update', 'bp-fitness' );?>" id="bpfit-update-your-weight" />
	</div>
</div>
<!-- SHOW MY WALK FOR PAST 'N' DAYS -->
<div class="bpfit-show-your-walk">
	<h3><?php _e( 'My walk record of past '.$past_dates.' days -', 'bp-fitness' );?></h3>
	<?php foreach( $last_n_dates as $key => $date ) {?>
		<?php
		$steps = 0;
		$saved_steps = get_user_meta( $user_id, 'my_steps', true );
		if( !empty( $saved_steps ) && array_key_exists( $date, $saved_steps['daily_steps'] ) ) {
			$steps = $saved_steps['daily_steps'][$date];
		}
		?>
		<p>
			<?php _e( 'Steps walked on: <strong>'.$date.'</strong> : <i>'.$steps.'</i>', 'bp-fitness' );?>
			<!-- <a href="javascript:void(0);" class="bpfit-edit-walk" data-panel="<?php //echo $key;?>"><?php //_e( 'Edit', 'bp-fitness' );?></a> -->
			<div id="bpfit-walk-edit-panel-<?php echo $key;?>" class="bpfit-walk-edit-panel">
				<p class="bpfit-success bpfit-walk-updated"></p>
				<input type="number" placeholder="<?php _e( 'Your Walked Steps', 'bp-fitness' );?>" id="bpfit-" />
				<input type="button" value="<?php _e( 'Update', 'bp-fitness' );?>" id="bpfit-update" />
			</div>
		</p>
	<?php }?>
</div>
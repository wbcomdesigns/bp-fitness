<?php
defined( 'ABSPATH' ) || exit; // Exit if accessed directly

/**
* Class to ajax requests for this plugin
*
* @since    1.0.0
* @author   Wbcom Designs
*/
if( !class_exists( 'Bpfit_Ajax' ) ) {
	class Bpfit_Ajax {
		/**
		* Constructor.
		*
		* @since    1.0.0
		* @access   public
		* @author   Wbcom Designs
		*/
		public function __construct() {
			//Update users weight
			add_action( 'wp_ajax_bpfit_update_weight', array($this, 'bpfit_update_weight' ) );
			add_action( 'wp_ajax_nopriv_bpfit_update_weight', array($this, 'bpfit_update_weight' ) );

			//Update daily walk
			add_action( 'wp_ajax_bpfit_update_daily_walk', array($this, 'bpfit_update_daily_walk' ) );
			add_action( 'wp_ajax_nopriv_bpfit_update_daily_walk', array($this, 'bpfit_update_daily_walk' ) );
		}

		/**
		 * Actions performed to setup navigation on BP member profile
		 */
		public function bpfit_update_weight(){
			if( isset( $_POST['action'] ) && $_POST['action'] == 'bpfit_update_weight' ) {
				$weight = sanitize_text_field( $_POST['weight'] );
				$user_id = get_current_user_id();
				update_user_meta( $user_id, 'my_weight', $weight );
				$response = array(
					'message' => 'Weight Updated Successfully!'
				);
				wp_send_json_success( $response );
				die;
			}
		}

		/**
		 * Actions performed to save daily kilometers walked
		 */
		public function bpfit_update_daily_walk(){
			if( isset( $_POST['action'] ) && $_POST['action'] == 'bpfit_update_daily_walk' ) {
				$kms = sanitize_text_field( $_POST['kms'] );
				$steps_walked = $kms * 1312;
				$today = date( 'F jS, Y' );
				$user_id = get_current_user_id();

				//Walk Record
				$walk = get_user_meta( $user_id, 'my_walk', true );
				$walk['daily_walk'][$today] = $kms;
				//update_user_meta( $user_id, 'my_walk', $walk );

				//Steps Record
				$steps = get_user_meta( $user_id, 'my_steps', true );
				$steps['daily_steps'][$today] = $steps_walked;
				//update_user_meta( $user_id, 'my_steps', $steps );

				echo '<pre>'; print_r( $walk ); print_r( $steps ); die("lkoo");

				$points = 0;
				$settings = get_option( 'bpfit_general_settings', true );
				if( isset( $settings['badgeos_points_settings'] ) ) {
					$badgeos_points = $settings['badgeos_points_settings'];
					$steps_needed = $settings['steps_walked_settings'];
					if( $steps_walked >= $steps_needed ) {
						$points = $badgeos_points;
					}
				}

				//Update assign points based on steps walked
				update_user_meta( $user_id, '_badgeos_points', $points );
				$response = array(
					'message' => 'Walk Record Updated Successfully!'
				);
				wp_send_json_success( $response );
				die;
			}
		}
	}
	new Bpfit_Ajax();
}
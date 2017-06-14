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
	}
	new Bpfit_Ajax();
}
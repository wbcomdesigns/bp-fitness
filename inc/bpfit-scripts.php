<?php
defined( 'ABSPATH' ) || exit; // Exit if accessed directly

/**
* Class to add custom scripts and styles for this plugin
*
* @since    1.0.0
* @author   Wbcom Designs
*/
if( !class_exists( 'Bpfit_Styles_Scripts' ) ) {
	class Bpfit_Styles_Scripts {
		/**
		* Constructor.
		*
		* @since    1.0.0
		* @access   public
		* @author   Wbcom Designs
		*/
		public function __construct() {
			add_action( 'wp_enqueue_scripts', array($this, 'bpfit_enqueue_public_scripts' ) );
			//WP Footer Scripts and Styles
			add_action( 'wp_footer', array($this, 'bpfit_modal_scripts_styles' ) );

			//Enqueue admin scripts
			if( stripos($_SERVER['REQUEST_URI'], 'bpfit-settings') !== false ) {
				add_action( 'admin_enqueue_scripts', array($this, 'bpfit_enqueue_admin_scripts' ) );
			}
		}

		/**
		 * Actions performed to setup navigation on BP member profile
		 */
		public function bpfit_enqueue_public_scripts(){
			if( stripos($_SERVER['REQUEST_URI'], 'fitness') !== false ) {
				wp_enqueue_style( 'bpfit-front-css', BPFIT_PLUGIN_URL.'assets/public/css/bpfit-front.css' );
				wp_enqueue_script( 'bpfit-front-js', BPFIT_PLUGIN_URL.'assets/public/js/bpfit-front.js', array( 'jquery' ) );

				wp_localize_script(
					'bpfit-front-js',
					'bpfit_front_js_object',
					array(
						'ajaxurl' => admin_url('admin-ajax.php')
					)
				);
			}
		}

		/**
		 * Actions performed to setup navigation on BP member profile
		 */
		public function bpfit_enqueue_admin_scripts(){
			wp_enqueue_style( 'bpfit-admin-css', BPFIT_PLUGIN_URL.'assets/admin/css/bpfit-admin.css' );
			wp_enqueue_script( 'bpfit-admin-js', BPFIT_PLUGIN_URL.'assets/admin/js/bpfit-admin.js', array( 'jquery' ) );
		}

		/**
		 * Actions performed to load scripts and styles for modals
		 */
		public function bpfit_modal_scripts_styles(){
			wp_enqueue_style( 'bpfit-modal-css', BPFIT_PLUGIN_URL.'assets/public/css/bpfit-modal.css' );
			wp_enqueue_script( 'bpfit-modal-js', BPFIT_PLUGIN_URL.'assets/public/js/bpfit-modal.js', array( 'jquery' ) );

			//Check if today's walk record is saved or not
			$user_id = get_current_user_id();
			$today = date( 'F jS, Y' );
			$steps = get_user_meta( $user_id, 'my_steps', true );
			$todays_walk_saved = 'no';
			if( !empty( $steps ) && array_key_exists( $today, $steps['daily_steps'] ) ) {
				$todays_walk_saved = 'yes';
			}

			wp_localize_script(
				'bpfit-modal-js',
				'bpfit_modal_js_object',
				array(
					'ajaxurl' => admin_url('admin-ajax.php'),
					'todays_walk_saved' => $todays_walk_saved
				)
			);
		}
	}
	new Bpfit_Styles_Scripts();
}
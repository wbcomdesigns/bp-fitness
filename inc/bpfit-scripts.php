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
			add_action( 'wp_enqueue_scripts', array($this, 'bpfit_enqueue_scripts' ) );
		}

		/**
		 * Actions performed to setup navigation on BP member profile
		 */
		public function bpfit_enqueue_scripts(){
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
	}
	new Bpfit_Styles_Scripts();
}
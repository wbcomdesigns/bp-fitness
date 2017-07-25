<?php
defined( 'ABSPATH' ) || exit; // Exit if accessed directly

/**
* Class to define global variable for this plugin
*
* @since    1.0.0
* @author   Wbcom Designs
*/
if( !class_exists( 'Bpfit_Globals' ) ) {
	class Bpfit_Globals{

		public  $video_type,
				$video_url,
				$past_dates,
				$badgeos_points,
				$steps_walked,
				$profile_menu_label,
				$profile_menu_slug;
		/**
		* Constructor.
		*
		* @since    1.0.0
		* @access   public
		* @author   Wbcom Designs
		*/
		public function __construct() {
			$this->setup_globals();
		}

		/**
		 * Setup this global variable: $bpfitness
		 */
		public function setup_globals() {
			global $bpfitness;
			$settings = get_option( 'bpfit_general_settings', true );
			$this->video_type = $this->video_url = $this->past_dates = '';
			if( isset( $settings['video_settings'] ) ) {
				$this->video_type = $settings['video_settings']['video_type'];
				$this->video_url = $settings['video_settings']['video_url'];
			}

			if( isset( $settings['past_dates_settings'] ) ) {
				$this->past_dates = $settings['past_dates_settings'];
			}

			if( isset( $settings['badgeos_points_settings'] ) ) {
				$this->badgeos_points = $settings['badgeos_points_settings'];
			}

			if( isset( $settings['steps_walked_settings'] ) ) {
				$this->steps_walked = $settings['steps_walked_settings'];
			}

			//Profile menu label
			$this->profile_menu_label = 'Fitness';
			if( isset( $settings['profile_menu_label'] ) ) {
				$this->profile_menu_label = $settings['profile_menu_label'];
			}
			$this->profile_menu_slug = str_replace( ' ', '-', strtolower( $this->profile_menu_label ) );
		}

		public static function pluralize($singular, $plural=null) {
			if($plural!==null) return $plural;

			$last_letter = strtolower($singular[strlen($singular)-1]);
			switch($last_letter) {
				case 'y':
					return substr($singular,0,-1).'ies';
				case 's':
					return $singular.'es';
				default:
					return $singular.'s';
			}
		}
	}
}
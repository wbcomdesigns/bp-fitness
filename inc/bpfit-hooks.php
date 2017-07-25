<?php
defined( 'ABSPATH' ) || exit; // Exit if accessed directly

/**
* Class to add custom hooks for this plugin
*
* @since    1.0.0
* @author   Wbcom Designs
*/
if( !class_exists( 'Bpfit_Hooks' ) ) {
	class Bpfit_Hooks {
		/**
		* Constructor.
		*
		* @since    1.0.0
		* @access   public
		* @author   Wbcom Designs
		*/
		public function __construct() {
			add_action( 'bp_setup_nav', array($this, 'bpfit_member_profile_fitness_tab' ) );

			//Debug on init
			add_action( 'init', array( $this, 'bpfit_debug' ) );
			add_action( 'admin_init', array( $this, 'bpfit_debug' ) );

			add_action( 'bp_setup_admin_bar', array( $this, 'bpfit_setup_admin_bar' ), 80 );

			//Modals
			add_action( 'wp_footer', array( $this, 'bpfit_modals' ) );
		}

		/**
		 * Actions performed to setup navigation on BP member profile
		 */
		public function bpfit_member_profile_fitness_tab(){
			global $bp, $bpfitness;
			$profile_menu_label = $bpfitness->profile_menu_label;
			$profile_menu_slug = $bpfitness->profile_menu_slug;
			
			$displayed_uid = bp_displayed_user_id();
			$displayed_user_link = bp_core_get_userlink( $displayed_uid, false, true );

			$tab_args = array(
				'name'                      => __( $profile_menu_label, 'bp-fitness' ),
				'slug'                      => $profile_menu_slug,
				'screen_function'           => 'bpfit_fitness_menu_function_to_show_screen',
				'position'                  => 75,
				'default_subnav_slug'       => 'walk',
				'show_for_displayed_user'   => true,
			);
			bp_core_new_nav_item( $tab_args );

			//Add subnav walk
			bp_core_new_subnav_item(
				array(
					'name' => 'Walk',
					'slug' => 'walk',
					'parent_url' => $bp->loggedin_user->domain . $profile_menu_slug.'/',
					'parent_slug' => $profile_menu_slug,
					'screen_function' => array($this, 'bpfit_walk_subtab_show_screen'),
					'position' => 100,
					'link' => $displayed_user_link.$profile_menu_slug.'/walk',
				)
			);

			//Add subnav weight
			bp_core_new_subnav_item(
				array(
					'name' => 'Weight',
					'slug' => 'weight',
					'parent_url' => $bp->loggedin_user->domain . $profile_menu_slug.'/',
					'parent_slug' => $profile_menu_slug,
					'screen_function' => array($this, 'bpfit_weight_subtab_show_screen'),
					'position' => 100,
					'link' => $displayed_user_link.$profile_menu_slug.'/weight',
				)
			);
		}

		/**
		 * Actions performed for "walk" subtab screen show
		 */
		function bpfit_walk_subtab_show_screen() {
			add_action( 'bp_template_title', array($this, 'bpfit_walk_subtab_function_to_show_title') );
			add_action( 'bp_template_content', array($this, 'bpfit_walk_subtab_function_to_show_content') );
			bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
		}

		/**
		 * Actions performed for "walk" subtab screen title show
		 */
		function bpfit_walk_subtab_function_to_show_title() {
			echo 'Walk Desc.';
		}

		/**
		 * Actions performed for "walk" subtab screen content show
		 */
		function bpfit_walk_subtab_function_to_show_content() {
			include 'profile-menu/walk/bpfit-my-walk.php';
		}

		/**
		 * Actions performed for "weight" subtab screen show
		 */
		function bpfit_weight_subtab_show_screen() {
			add_action( 'bp_template_title', array($this, 'bpfit_weight_subtab_function_to_show_title') );
			add_action( 'bp_template_content', array($this, 'bpfit_weight_subtab_function_to_show_content') );
			bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
		}

		/**
		 * Actions performed for "weight" subtab screen title show
		 */
		function bpfit_weight_subtab_function_to_show_title() {
			echo 'Weight Desc.';
		}

		/**
		 * Actions performed for "weight" subtab screen content show
		 */
		function bpfit_weight_subtab_function_to_show_content() {
			include 'profile-menu/weight/bpfit-my-weight.php';
		}

		/**
		 *
		 */
		public function bpfit_setup_admin_bar( $wp_admin_nav = array() ) {
			global $wp_admin_bar, $bpfitness;
			$profile_menu_label = $bpfitness->profile_menu_label;
			$profile_menu_slug = $bpfitness->profile_menu_slug;

			$base_url = bp_loggedin_user_domain().$profile_menu_slug;
			$walk_url = $base_url.'/walk';
			$weight_url = $base_url.'/weight';
			if ( is_user_logged_in() ) {
				$wp_admin_bar->add_menu( array(
					'parent' => 'my-account-buddypress',
					'id' => 'my-account-'.$profile_menu_slug,
					'title' => __( $profile_menu_label, BPFIT_TEXT_DOMAIN ),
					'href' => trailingslashit( $walk_url )
				) );

				// Add add-new submenu
				$wp_admin_bar->add_menu( array(
					'parent' => 'my-account-'.$profile_menu_slug,
					'id'     => 'my-account-'.$profile_menu_slug.'-'.'walk',
					'title'  => __( 'Walk', BPFIT_TEXT_DOMAIN ),
					'href'   => trailingslashit( $walk_url )
				) );

				// Add add-new submenu
				$wp_admin_bar->add_menu( array(
					'parent' => 'my-account-'.$profile_menu_slug,
					'id'     => 'my-account-'.$profile_menu_slug.'-'.'weight',
					'title'  => __( 'Weight', BPFIT_TEXT_DOMAIN ),
					'href'   => trailingslashit( $weight_url )
				) );
			}
		}

		/**
		 * Actions performed to check if input string is a valid URL
		 */
		public static function is_url( $url ) {
			if(preg_match( '/^(http|https):\\/\\/[a-z0-9_]+([\\-\\.]{1}[a-z_0-9]+)*\\.[_a-z]{2,5}'.'((:[0-9]{1,5})?\\/.*)?$/i' ,$url)){
				return true;
			}
			return false;
		}

		/**
		 * Actions performed to check video type from valid video URL
		 */
		public static function get_video_type( $url ) {
			if ( strpos( $url, 'youtube' ) !== false ) {
				return 'youtube';
			} elseif ( strpos( $url, 'vimeo' ) !== false ) {
				return 'vimeo';
			} else {
				return 'other';
			}
		}

		/**
		 * Debug Mode
		 */
		function bpfit_debug() {
			error_reporting(E_ALL);
			ini_set('display_errors', 1);
		}

		/**
		 * Modals used.
		 */
		function bpfit_modals() {
			if( is_user_logged_in() ) {
				if( file_exists( BPFIT_PLUGIN_PATH.'/inc/modals/bpfit-daily-walk-modal.php' ) ) {
					include BPFIT_PLUGIN_PATH.'/inc/modals/bpfit-daily-walk-modal.php';
				}
			}
		}

		/**
		 * Get last N dates
		 */
		function get_last_n_dates( $days, $format = 'd/m/Y' ) {
			$m = date("m");
			$de= date("d");
			$y= date("Y");
			$dateArray = array();
			for( $i=0; $i<=$days-1; $i++ ) {
				$dateArray[] = date($format, mktime(0,0,0,$m,($de-$i),$y)); 
			}
			return array_reverse( $dateArray );
		}
	}
}
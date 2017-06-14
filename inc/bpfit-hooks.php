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
		}

		/**
		 * Actions performed to setup navigation on BP member profile
		 */
		public function bpfit_member_profile_fitness_tab(){
			global $bp;
			$name = bp_get_displayed_user_username();
			$parent_slug = 'fitness';
			$tab_args = array(
				'name'                      => __( 'Fitness', 'bp-fitness' ),
				'slug'                      => $parent_slug,
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
					'parent_url' => $bp->loggedin_user->domain . $parent_slug.'/',
					'parent_slug' => $parent_slug,
					'screen_function' => array($this, 'bpfit_walk_subtab_show_screen'),
					'position' => 100,
					'link' => home_url( "/members/$name/$parent_slug/walk/" ),
				)
			);

			//Add subnav weight
			bp_core_new_subnav_item(
				array(
					'name' => 'Weight',
					'slug' => 'weight',
					'parent_url' => $bp->loggedin_user->domain . $parent_slug.'/',
					'parent_slug' => $parent_slug,
					'screen_function' => array($this, 'bpfit_weight_subtab_show_screen'),
					'position' => 100,
					'link' => home_url( "/members/$name/$parent_slug/weight/" ),
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
			echo 'My Walking';
		}

		/**
		 * Actions performed for "walk" subtab screen content show
		 */
		function bpfit_walk_subtab_function_to_show_content() {
			echo 'My Walking Content';
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
	}
	new Bpfit_Hooks();
}
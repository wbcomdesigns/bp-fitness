<?php
if( !defined( 'ABSPATH' ) ) exit; //Exit if accessed directly

add_action( 'bp_setup_nav', 'bpfit_profile_menu_fitness' );
function bpfit_profile_menu_fitness(){
  $displayed_user_id = bp_displayed_user_id();
  global $bp;
  $name = bp_get_displayed_user_username();
  $tab_args = array(
    'name'                      => __( 'Fitness', 'bp-fitness' ),
    'slug'                      => 'fitness',
    'screen_function'           => 'bpfit_fitness_menu_function_to_show_screen',
    'position'                  => 75,
    'default_subnav_slug'       => 'my-fitness',
    'show_for_displayed_user'   => true,
  );
  bp_core_new_nav_item( $tab_args );
}
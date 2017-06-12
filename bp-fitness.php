<?php
/**
 * Plugin Name: BuddyPress Fitness
 * Plugin URI: https://wbcomdesigns.com/contact/
 * Description: This plugin deals with the fitness of the buddypress users.
 * Version: 1.0.0
 * Author: Wbcom Designs
 * Author URI: http://wbcomdesigns.com
 * License: GPLv2+
 * Text Domain: bp-fitness
 */

if( !defined('ABSPATH') ) exit; // Exit if accessed directly

/**
 * Check plugin requirement on plugins loaded
 * this plugin requires buddypress to be installed and active
 */
add_action('plugins_loaded', 'bpfit_plugin_init');
function bpfit_plugin_init() {
	$bp_active = in_array('buddypress/bp-loader.php', get_option('active_plugins'));
	if ( current_user_can('activate_plugins') && $bp_active !== true ) {
		add_action('admin_notices', 'bpfit_plugin_admin_notice');
	} else {
		run_bp_fitness_plugin();
	}
}

function bpfit_plugin_admin_notice() {
	$bpfit_plugin = __( 'BuddyPress Fitness', 'bp-fitness' );
	$bp_plugin = __( 'BuddyPress', 'bp-fitness' );

	echo '<div class="error"><p>'
	. sprintf(__('%1$s requires %2$s to function correctly. Please activate %2$s before activating %1$s.', 'bp-fitness'), '<strong>' . esc_html($bpfit_plugin) . '</strong>', '<strong>' . esc_html($bp_plugin) . '</strong>')
	. '</p></div>';
	if (isset($_GET['activate'])) unset($_GET['activate']);
}

function run_bp_fitness_plugin(){
	$include_files = array(
		'inc/bpfit-scripts.php',
		'inc/bpfit-hooks.php',
	);
	foreach ($include_files  as $include_file) include $include_file;
}
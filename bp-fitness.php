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
if( !defined('BPFIT_TEXT_DOMAIN') ) define( 'BPFIT_TEXT_DOMAIN', 'bp-fitness' );
global $bpfitness;

/**
 * Check plugin requirement on plugins loaded
 * this plugin requires buddypress to be installed and active
 */
add_action('plugins_loaded', 'bpfit_plugin_init');
function bpfit_plugin_init() {
	$bp_active = in_array('buddypress/bp-loader.php', get_option('active_plugins'));
	$badgeos_active = in_array('badgeos/badgeos.php', get_option('active_plugins'));
	if ( current_user_can('activate_plugins') && ( $bp_active !== true || $badgeos_active !== true ) ) {
		add_action('admin_notices', 'bpfit_plugin_admin_notice');
	} else {
		run_bp_fitness_plugin();
		add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'bpfit_admin_settings_link' );
	}
}

function bpfit_plugin_admin_notice() {
	$bpfit_plugin = 'BuddyPress Fitness';
	$badgeos_plugin = 'BadgeOS';
	$bp_plugin = 'BuddyPress';

	echo '<div class="error"><p>'.sprintf(__('%1$s is ineffective now as it requires %2$s and %3$s to function correctly.', BPFIT_TEXT_DOMAIN ), '<strong>' . esc_html($bpfit_plugin) . '</strong>', '<strong>' . esc_html($bp_plugin) . '</strong>', '<strong>' . esc_html($badgeos_plugin) . '</strong>').'</p></div>';
	if (isset($_GET['activate'])) unset($_GET['activate']);
}

function run_bp_fitness_plugin(){
	//Defining constants
	define( 'BPFIT_PLUGIN_PATH', plugin_dir_path(__FILE__) );
	define( 'BPFIT_PLUGIN_URL', plugin_dir_url(__FILE__) );

	//Include required files
	$include_files = array(
		'inc/bpfit-scripts.php',
		'admin/bpfit-admin.php',
		'inc/bpfit-globals.php',
		'inc/bpfit-hooks.php',
		'inc/bpfit-ajax.php'
	);
	foreach ($include_files  as $include_file) include $include_file;

	//Initialize admin class
	new BPFit_AdminPage();
	
	//Initialize globals class
	global $bpfitness;
	$bpfitness = new Bpfit_Globals();

	//Initialize Hooks class
	new Bpfit_Hooks();
}

function bpfit_admin_settings_link( $links ) {
	$settings_link = array( '<a href="'.admin_url('admin.php?page=bpfit-settings').'">'.__( 'Settings', BPFIT_TEXT_DOMAIN ).'</a>' );
	return array_merge( $links, $settings_link );
}
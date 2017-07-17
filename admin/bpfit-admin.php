<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

//Add admin page for displaying buddypress fitness settings
if( !class_exists( 'BPFit_AdminPage' ) ) {
	class BPFit_AdminPage{

		private $plugin_slug = 'bpfit-settings',
				$plugin_settings_tabs = array();

		//constructor
		function __construct() {
			add_action( 'admin_menu', array( $this, 'bpfit_add_menu_page' ) );

			add_action('admin_init', array($this, 'register_general_settings'));
			add_action('admin_init', array($this, 'register_support_settings'));
		}

		//Actions performed to create a custom menu on loading admin_menu
		function bpfit_add_menu_page() {
			add_menu_page( __( 'BuddyPress Fitness Settings', 'bp-fitness' ), __( 'Fitness', 'fitness' ), 'manage_options', $this->plugin_slug, array( $this, 'bpfit_admin_settings_page' ), 'dashicons-universal-access-alt' );
		}

		function bpfit_admin_settings_page() {
			$tab = isset($_GET['tab']) ? $_GET['tab'] : 'bpfit-settings';
			?>
			<div class="wrap">
				<h2><?php _e('BuddyPress Fitness', 'bp-fitness'); ?></h2>
				<p><?php _e('This plugin will manage the fitness of the BuddyPress members.', 'bp-fitness'); ?></p>
				<?php $this->bpfit_plugin_settings_tabs(); ?>
				<form action="" method="POST" id="<?php echo $tab;?>-settings-form">
				<?php do_settings_sections( $tab );?>
				</form>
			</div>
			<?php
		}

		function bpfit_plugin_settings_tabs() {
			$current_tab = isset($_GET['tab']) ? $_GET['tab'] : 'bpfit-settings';
			echo '<h2 class="nav-tab-wrapper">';
			foreach ($this->plugin_settings_tabs as $tab_key => $tab_caption) {
				$active = $current_tab == $tab_key ? 'nav-tab-active' : '';
				echo '<a class="nav-tab ' . $active . '" href="?page=' . $this->plugin_slug . '&tab=' . $tab_key . '">' . $tab_caption . '</a>';
			}
			echo '</h2>';
		}

		function register_general_settings() {
			$this->plugin_settings_tabs['bpfit-settings'] = __( 'General', 'bp-fitness' );
			register_setting('bpfit-settings', 'bpfit-settings');
			add_settings_section('section_general', ' ', array(&$this, 'bpfit_section_general'), 'bpfit-settings');
		}

		function register_support_settings() {
			$this->plugin_settings_tabs['bpfit-support'] = __( 'Support', 'bp-fitness' );
			register_setting('bpfit-support', 'bpfit-support');
			add_settings_section('section_support', ' ', array(&$this, 'bpfit_section_support'), 'bpfit-support');
		}

		function bpfit_section_support() {
			if (file_exists(dirname(__FILE__) . '/bpfit-support.php')) {
				require_once( dirname(__FILE__) . '/bpfit-support.php' );
			}
		}

		 function bpfit_section_general() {
			if (file_exists(dirname(__FILE__) . '/bpfit-settings.php')) {
				require_once( dirname(__FILE__) . '/bpfit-settings.php' );
			}
		}
	}
	new BPFit_AdminPage();
}
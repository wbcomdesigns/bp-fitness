<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

//Add admin page for displaying buddypress fitness settings
if( !class_exists( 'BPFit_AdminPage' ) ) {
	class BPFit_AdminPage{

		private $form_action = 'options.php',
				$plugin_slug = 'bpfit-settings',
				$plugin_settings_tabs = array(),
				$network_activated = false;

		//constructor
		function __construct() {
			add_action( 'admin_menu', array( $this, 'bpfit_add_menu_page' ) );

			add_action('admin_init', array($this, 'register_general_settings'));
			add_action('admin_init', array($this, 'register_support_settings'));
		}

		//Actions performed to create a custom menu on loading admin_menu
		function bpfit_add_menu_page() {
			add_menu_page( __( 'BuddyPress Fitness Settings', 'bp-fitness' ), __( 'Fitness', 'fitness' ), 'manage_options', 'bpfit-settings', array( $this, 'bpfit_admin_settings_page' ), 'dashicons-universal-access-alt' );
		}

		function bpfit_admin_settings_page() {
			if (isset($_REQUEST['page']) && $_REQUEST['page'] === $this->plugin_slug && isset($_GET['settings-updated'])) {
			?>
				<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible">
					<p><strong><?php _e('BuddyPress Fitness Settings Saved.', 'bp-fitness'); ?></strong></p>
					<button type="button" class="notice-dismiss">
						<span class="screen-reader-text">Dismiss this notice.</span>
					</button>
				</div>
			<?php
			}
			$tab = isset($_GET['tab']) ? $_GET['tab'] : __FILE__;
			?>
			<div class="wrap">
				<h2><?php _e('BuddyPress Fitness', 'bp-fitness'); ?></h2>
				<p><?php _e('This plugin will manage the fitness of the BuddyPress members.', 'bp-fitness'); ?></p>
				<?php $this->bpfit_plugin_settings_tabs(); ?>
				<form action="<?php echo $this->form_action; ?>" method="post">
				<?php
				if ($this->network_activated && isset($_GET['updated'])) {
				echo "<div class='updated'><p>" . __('BuddyPress Fitness Settings Saved.', 'bp-fitness') . "</p></div>";
				}
				if ('bpfit-settings' == $tab || empty($_GET['tab'])) {
					settings_fields('bpfit-settings');
					do_settings_sections(__FILE__);
					?>
					<p class="submit">
					<input name="bpfit_settings_submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
					</p><?php
				} else {
					settings_fields($tab);
					do_settings_sections($tab);
				}
				?>
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
			register_setting('bpfit-settings', 'bpfit-settings', array($this, 'bpfit_plugin_options_validate'));

			add_settings_section('general_section', __('General Settings', 'bp-fitness'), array($this, 'bpfit_section_general'), __FILE__);
			
			add_settings_field('redirection-url', __('Redirection URL', 'buddyboss-wpld'), array($this, 'wpld_redirection_url'), __FILE__, 'general_section');
		}

		function register_support_settings() {
			$this->plugin_settings_tabs['bpfit-support'] = __( 'Support', 'bp-fitness' );
			register_setting('bpfit-support', 'bpfit-support');
			add_settings_section('section_support', ' ', array(&$this, 'section_support_desc'), 'bpfit-support');
		}

		function section_support_desc() {
			if (file_exists(dirname(__FILE__) . '/bpfit-support.php')) {
				require_once( dirname(__FILE__) . '/bpfit-support.php' );
			}
		}

		/**
		 * Validate plugin option
		 *
		 * @since BuddyBoss WPLD (1.0.0)
		 */
		public function bpfit_plugin_options_validate($input) {
			$input['enabled'] = sanitize_text_field($input['enabled']);
			return $input; // return validated input
		}

		function bpfit_section_general() {

		}
	}
	new BPFit_AdminPage();
}
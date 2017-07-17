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

			$this->bpfit_save_general_settings();
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

		/**
		 *
		 */
		function bpfit_save_general_settings(){
			if( isset( $_POST['bpfit-general-settings-submit'] ) ) {
				$settings_validations_errors = $bpfit_general_settings = array();

				/************************** VIDEO VALIDATION **************************/
				$video_url = sanitize_text_field( $_POST['bpfit-video-url'] );
				$is_url = Bpfit_Hooks::is_url( $video_url );
				if( $is_url === false ) {
					$settings_validations_errors[] = 'The URL entered is not a valid URL!';
				} else {
					/**
					 * Its a valid URL
					 * Check the type of the video, if its a youtube, or vimeo or any other
					 */
					$video_type = Bpfit_Hooks::get_video_type( $video_url );

					if( $video_type == 'other' ) {
						/**
						 * Check if the URL entered is a video URL
						 */
						$headers = get_headers( $video_url );
						$video_exist = implode( ',', $headers );
						if( stripos( $video_exist, 'video' ) === false ) {
							$settings_validations_errors[] = 'The URL entered does not contain a video!';
						} else {
							$video_settings = array(
								'video_type' => $video_type,
								'video_url' => $video_url
							);
							$bpfit_general_settings['video_settings'] = $video_settings;
						}
					} else {
						$video_settings = array(
							'video_type' => $video_type,
							'video_url' => $video_url
						);
						$bpfit_general_settings['video_settings'] = $video_settings;
					}
				}

				/************************** PAST DATES **************************/
				$bpfit_general_settings['past_dates_settings'] = sanitize_text_field( $_POST['bpfit-past-dates'] );

				/************************** BADGE OS POINTS / STEPS **************************/
				$bpfit_general_settings['badgeos_points_settings'] = sanitize_text_field( $_POST['bpfit-badgeos-points'] );
				$bpfit_general_settings['steps_walked_settings'] = sanitize_text_field( $_POST['bpfit-steps-walked'] );

				/**
				 * Check if there are any errors
				 */
				if( !empty( $settings_validations_errors ) ) {
					$err_msg = "<div class='error is-dismissible' id='message'>";
					foreach ( $settings_validations_errors as $key => $failure ) {
						$err_msg .= "<p>".__( $failure, BPFIT_TEXT_DOMAIN )."</p>";
					}
					$err_msg .= "</div>";
					echo $err_msg;
				} else {
					// echo '<pre>'; print_r( $bpfit_general_settings ); die;
					update_option( 'bpfit_general_settings', $bpfit_general_settings );
					$success_msg = "<div class='notice updated is-dismissible' id='message'>";
					$success_msg .= "<p>".__( 'BuddyPress Fitness Settings Saved.', BPFIT_TEXT_DOMAIN )."</p>";
					$success_msg .= "</div>";
					echo $success_msg;
				}
			}
		}
	}
}
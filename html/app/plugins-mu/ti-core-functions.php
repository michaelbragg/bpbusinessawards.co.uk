<?php
/**
 * Plugin Name: TI Core Functions
 * Plugin URI:
 * Description: Functions that perform some core functionality that we would love to live inside of WordPress one day.
 * Author: Michael Bragg
 * Author URI:
 * Version: 0.1.0
 */

class TI_Core_Functions {

	/**
	 * Maintain the single instance of TI_Core_Functions
	 *
	 * @var bool
	 */
	private static $instance = false;

	/**
	 * Add required hooks
	 */
	function __construct() {

		add_action(
			'admin_menu',
			array( $this, 'ti_add_home_to_menu' )
		);

		remove_action(
			'wpmu_new_user',
			'newuser_notify_siteadmin'
		);

		add_action(
			'wpmu_new_user',
			array( $this, 'newuser_notify_siteadmin_enhanced' )
		);

	}

	/**
	 * Handle requests for the instance.
	 *
	 * @return bool
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new TI_Core_Functions();
		}
		return self::$instance;
	}

	/**
	 * Add link to front page in admin menu
	 * @since 0.1.0
	 */
	public function ti_add_home_to_menu() {

		$homepage_id = get_option( 'page_on_front' );

		add_menu_page(
			'Home Page',
			'Home Page',
			'edit_pages',
			'post.php?post=' . $homepage_id . '&action=edit',
			false,
			'dashicons-admin-home',
			4
		);

	}

	/**
	 * Add extra information to registration email
	 *
	 * (https://buddydev.com/buddypress/enhancing-the-new-user-registration-message-on-wordpress-multisite-and-buddypress-to-make-it-more-informative-for-site-admins/)
	 * @since 0.1.0
	 */

	public function newuser_notify_siteadmin_enhanced( $user_id ) {

		if ( 'yes' !== get_site_option( 'registrationnotification' ) ) {
			return false;
		}

		$email = get_site_option( 'admin_email' );

		if ( false === is_email( $email ) ) {
			return false;
		}

		$user = new WP_User( $user_id );

		if ( function_exists( 'bp_core_get_user_domain' ) ) { // Just make sure to not cause trouble when bp is disables.
			$user_link = bp_core_get_user_domain( $user_id );
		} else {
			$user_link = network_admin_url( 'user-edit.php?user_id=' . $user_id );//just making sure it works on normal wpms installs too
		}

		$options_site_url = esc_url( network_admin_url( 'ms-options.php' ) );

		$msg = sprintf(
			__('New User: %1s
			User email: %2s
			View Profile: %3s

			Disable these notifications: %4s'),
			$user->user_login,
			$user->user_email,
			$user_link,
			$options_site_url
		);

		$msg = apply_filters( 'newuser_notify_siteadmin_enhanced', $msg, $user );

		wp_mail(
			$email,
			sprintf(
				apply_filters(
					'new_user_registration_message_subject',
					__( 'New User Registration: %s' )
				),
				$user->user_login
			),
			$msg
		);

		return true;

	}

}

function ti_core_functions_init() {
		TI_Core_Functions::get_instance();
}

add_action( 'plugins_loaded', 'ti_core_functions_init' );

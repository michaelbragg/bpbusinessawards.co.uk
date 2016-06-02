<?php
/**
 * Plugin Name: TM Multisite Signup
 * Plugin URI:
 * Description: Extend the WordPress Multisite registration functionality.
 * Author: Michael Bragg <michael.bragg@trinitymirror.com>
 * Author URI: http://www.trinitymirror.com/
 * Version: 0.1.0
 */

class TM_Multisite_Signup {

	/**
	 * Maintain the single instance of TM_Multisite_Signup
	 *
	 * @var bool
	 */
	private static $instance = false;

	/**
	 * Add required hooks
	 */
	function __construct() {

		add_action(
			'wpmu_activate_user',
			array( $this, 'activate_user' ),
			10,
			3
		);

	}

	/**
	 * Handle requests for the instance.
	 *
	 * @return bool
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new TM_Multisite_Signup();
		}
		return self::$instance;
	}

	/**
	 * Add user to current blog users list as a subscriber
	 * @since 0.1.0
	 */
	public function activate_user( $user_id, $password, $meta ) {

		global $blog_id;

		add_user_to_blog(
			$blog_id,
			$user_id,
			get_site_option(
				'default_user_role',
				'subscriber'
			)
		);

	}

}

function tm_multisite_signup_init() {
		TM_Multisite_Signup::get_instance();
}

add_action( 'plugins_loaded', 'tm_multisite_signup_init' );

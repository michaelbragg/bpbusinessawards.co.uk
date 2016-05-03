<?php
/**
 * Plugin Name: TI Roles and Capabilities
 * Plugin URI:
 * Description: Updates the roles and capabilities
 * Author: Michael Bragg <michael@michaelbragg.net>
 * Version: 0.1.0
*/

class TI_Roles_And_Capabilities {

	/**
	 * Maintain the single instance of TI_Roles_And_Capabilities
	 *
	 * @var bool
	 */
	private static $instance = false;

	/**
	 * Add required hooks
	 */
	function __construct() {

		/* If user is Editor or below */
		if ( ! current_user_can( 'manage_options' ) ) {

			add_action(
				'admin_menu',
				array( $this, 'ti_hide_tools_menu' ),
				9999
			);

			add_action(
				'admin_notices',
				array( $this, 'ti_proper_update_message' ),
				1
			);

			add_action(
				'wp_before_admin_bar_render',
				array( $this, 'ti_remove_multisite_admin_link' ),
				9999
			);

		}

		/* If user is Author or below */
		if ( ! current_user_can( 'publish_pages' ) ) {

		}

		/* If user is subscriber */
		if ( ! current_user_can( 'edit_posts' ) ) {
			// @codingStandardsIgnoreStart
			// Hide the admin bar
			show_admin_bar( false );
			add_filter(
				'show_admin_bar',
				array( $this, 'remove_admin_bar_space' )
			);
			// @codingStandardsIgnoreEnd
		}

	}

	/**
	 * Handle requests for the instance.
	 *
	 * @return bool
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new TI_Roles_And_Capabilities();
		}
		return self::$instance;
	}

	/**
	 * Only show WordPress update message to administrator roles
	 * @since 0.1.0
	 */
	public static function ti_proper_update_message() {
		remove_action( 'admin_notices', 'update_nag', 3 );
	}

	/**
	 * Hide Tools option for Editor role and below
	 * @since  0.1.0
	 */
	public static function ti_hide_tools_menu() {
		remove_menu_page( 'tools.php' ); // Tools
	}

	/**
	 * Remove space left by not showing the admin bar
	 */
	public function remove_admin_bar_space(){
		return false;
	}

	/**
	 * Remove multisite link in admin bar
	 */
	public function ti_remove_multisite_admin_link( ) {
		global $wp_admin_bar;
		$wp_admin_bar->remove_node( 'my-sites' );
	}

}

function ti_roles_and_capabilities_init() {
	TI_Roles_And_Capabilities::get_instance();
}

add_action( 'plugins_loaded', 'ti_roles_and_capabilities_init' );

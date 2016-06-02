<?php
/**
 * Entires CPT
 *
 * @package WordPress
 * @subpackage BA_Entries
 */

class BA_Entries {

	protected $post_type = 'ba-entries';

	protected $metabox_id = '_ba_entries_';

	public function __construct() {

		add_action(
			'after_setup_theme',
			array(
				$this,
				'define_constants',
			),
			1
		);

		add_action(
			'init',
			array( $this, 'add_caps_editor' )
		);

		add_action(
			'init',
			array( $this, 'add_post_type' )
		);

		add_action(
			'manage_users_columns',
			array( $this, 'update_users_columns' )
		);

		add_action(
			'manage_users_custom_column',
			array( $this, 'users_columns_add_entries' ),
			10,
			3
		);

		add_filter(
			'query_vars',
			array( $this, 'add_query_vars_filter' )
		);

	}

	public function define_constants() {
		// Path to the child theme directory
		/*$this->bpba_override_constant(
			'GRD_DIR',
			get_stylesheet_directory_uri()
		);*/

	}

	public function bpba_override_constant( $constant, $value ) {

		if ( ! defined( $constant ) ) {
			define( $constant, $value ); // Constants can be overidden via wp-config.php
		}

	}

	/**
	 * Allow Editor role to view users list
	 */
	public function add_caps_editor() {
		$role = get_role( 'editor' );
		// Check if Editor has `list_users` capabilities.
		if ( true !== $role->capabilities['list_users'] ) {
			$role->add_cap( 'list_users' );
		}
	}

	public function enqueue_scripts() {

	}

	public function add_post_type() {

		$labels = array(
			'name'                  => _x( 'Entries', 'Post Type General Name', 'bpba_entries' ),
			'singular_name'         => _x( 'Entry', 'Post Type Singular Name', 'bpba_entries' ),
			'menu_name'             => __( 'Entries', 'bpba_entries' ),
			'name_admin_bar'        => __( 'Entries', 'bpba_entries' ),
			'archives'              => __( 'Entry Archives', 'bpba_entries' ),
			'parent_item_colon'     => __( 'Parent Item:', 'bpba_entries' ),
			'all_items'             => __( 'All Entries', 'bpba_entries' ),
			'add_new_item'          => __( 'Add New Item', 'bpba_entries' ),
			'add_new'               => __( 'Add New', 'bpba_entries' ),
			'new_item'              => __( 'New Item', 'bpba_entries' ),
			'edit_item'             => __( 'Edit Item', 'bpba_entries' ),
			'update_item'           => __( 'Update Item', 'bpba_entries' ),
			'view_item'             => __( 'View Item', 'bpba_entries' ),
			'search_items'          => __( 'Search Item', 'bpba_entries' ),
			'not_found'             => __( 'Not found', 'bpba_entries' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'bpba_entries' ),
			'insert_into_item'      => __( 'Insert into item', 'bpba_entries' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'bpba_entries' ),
			'items_list'            => __( 'Items list', 'bpba_entries' ),
			'items_list_navigation' => __( 'Items list navigation', 'bpba_entries' ),
			'filter_items_list'     => __( 'Filter items list', 'bpba_entries' ),
		);
		$args = array(
			'label'                 => __( 'Entries', 'bpba_entries' ),
			'description'           => __( 'Post Type Description', 'bpba_entries' ),
			'public'                => false,
			'publicly_queryable'    => false,
			'exclude_from_search'   => true,
			'show_in_nav_menus'     => false,
			'show_ui'               => true,
			'show_in_admin_bar'     => false,
			'menu_position'         => 5,
			//'menu_icon'							=> '',
			'can_export'            => true,
			'delete_with_user'			=> false,
			'hierarchical'          => false,
			'has_archive'           => false,
			'menu_icon'						=> 'dashicons-tickets-alt',
			'query_var'           	=> true,
			'capability_type'       => 'page',
			'map_meta_cap'        	=> true,
			'rewrite'									 => array(
				'slug'			 => 'entries',
				'with_front' => false,
				'pages' 	 	 => false,
			),
			'supports'            	   => array(
				'title',
				'revisions',
				'author',
			),
			'labels'              	   => $labels,
		);

		register_post_type( 'ba-entries', $args );

	}

	public function print_header_scripts() {

	}

	public function print_footer_scripts() {

	}

	/**
	 * Update manage user table columns
	 */
	public function update_users_columns( $column_headers ) {
		unset( $column_headers['posts'] );
		$column_headers['telephone'] = __( 'Telephone', 'ba-entries' );
		$column_headers['entries'] = __( 'Entries (Pending)', 'ba-entries' );
		return $column_headers;
	}

	/**
	 * Add content to custom columns
	 */
	public function users_columns_add_entries( $output, $column_name, $user_id ) {

		if ( 'entries' === $column_name ) {
			return sprintf(
				'%1$s (%2$s)',
				count_user_posts( $user_id , $this->post_type ),
				$this->get_users_pending_posts( $user_id )
			);
		}

		if ( 'telephone' === $column_name ) {
			return $this->get_users_telephone( $user_id );
		}

		return $output;

	}

	/**
	 * Get count of pending entries
	 */
	public function get_users_pending_posts( $user_id ) {
		$args = array(
			'author'	=> $user_id,
			'post_type'	=> $this->post_type,
			'post_status'	=> 'pending',
		);
		$myquery = new WP_Query( $args );
		return $myquery->found_posts;
	}

	/**
	 * Get users telephone from most recent entry.
	 */
	public function get_users_telephone( $user_id ) {
		$args = array(
			'author'	=> $user_id,
			'post_type'	=> $this->post_type,
			'post_status'	=> array( 'pending', 'publish' ),
			'orderby'	=> 'DATETIME',
			'order'	=> 'DESC',
			'posts_per_page'	=> 1,
		);
		$myquery = new WP_Query( $args );

		if ( ! empty( $myquery->post ) ) {
			return get_post_meta( $myquery->post->ID, $this->$metabox_id . 'contact_phone', true );
		}

		return false;

	}

	public function add_query_vars_filter( $vars ){
		$vars[] = 'entry';
		return $vars;
	}

}


function ba_enteries_init() {
	$BA_Entries = new BA_Entries();
}

add_action( 'plugins_loaded', 'ba_enteries_init' );

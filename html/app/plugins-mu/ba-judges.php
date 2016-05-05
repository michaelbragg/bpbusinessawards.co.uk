<?php
/**
 * Judges CPT
 *
 * @package WordPress
 * @subpackage BA
 */

class BA_Judges {

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
			array(
				$this,
				'add_post_type',
			)
		);

		add_filter(
			'admin_post_thumbnail_html',
			array(
				$this,
				'explain_feature_image',
			)
		);

	}

	public function define_constants() {
		// Path to the child theme directory
		/*$this->ba_override_constant(
			'GRD_DIR',
			get_stylesheet_directory_uri()
		);*/

	}

	public function ba_override_constant( $constant, $value ) {

		if ( ! defined( $constant ) ) {
			define( $constant, $value ); // Constants can be overidden via wp-config.php
		}

	}

	public function enqueue_scripts() {

	}

	public function add_post_type() {

		$labels = array(
			'name'                  => _x( 'Judges', 'Post Type General Name', 'ba_judges' ),
			'singular_name'         => _x( 'Judge', 'Post Type Singular Name', 'ba_judges' ),
			'menu_name'             => __( 'Judges', 'ba_judges' ),
			'name_admin_bar'        => __( 'Judges', 'ba_judges' ),
			'archives'              => __( 'Judge Archives', 'ba_judges' ),
			'parent_item_colon'     => __( 'Parent Item:', 'ba_judges' ),
			'all_items'             => __( 'All Judges', 'ba_judges' ),
			'add_new_item'          => __( 'Add New Item', 'ba_judges' ),
			'add_new'               => __( 'Add New', 'ba_judges' ),
			'new_item'              => __( 'New Item', 'ba_judges' ),
			'edit_item'             => __( 'Edit Item', 'ba_judges' ),
			'update_item'           => __( 'Update Item', 'ba_judges' ),
			'view_item'             => __( 'View Item', 'ba_judges' ),
			'search_items'          => __( 'Search Item', 'ba_judges' ),
			'not_found'             => __( 'Not found', 'ba_judges' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'ba_judges' ),
			'featured_image'        => __( 'Profile Image', 'ba_judges' ),
			'set_featured_image'    => __( 'Set profile image', 'ba_judges' ),
			'remove_featured_image' => __( 'Remove profile image', 'ba_judges' ),
			'use_featured_image'    => __( 'Use as profile image', 'ba_judges' ),
			'insert_into_item'      => __( 'Insert into item', 'ba_judges' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'ba_judges' ),
			'items_list'            => __( 'Items list', 'ba_judges' ),
			'items_list_navigation' => __( 'Items list navigation', 'ba_judges' ),
			'filter_items_list'     => __( 'Filter items list', 'ba_judges' ),
		);
		$args = array(
			'label'                 => __( 'Judges', 'ba_judges' ),
			'description'           => __( 'Post Type Description', 'ba_judges' ),
			'labels'                => $labels,
			'supports'              => array(
				'title',
				'editor',
				'thumbnail',
				'revisions',
				'page-attributes',
			),
			'taxonomies'            => array(),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'menu_icon'							=> 'dashicons-clipboard',
			'rewrite'								=> array(
				'slug' => 'judges',
				'with_front' => false,
				'pages' => false,
			),
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
		);
		register_post_type( 'ba-judges', $args );

	}

	public function explain_feature_image( $content ) {

		if ( 'ba-judges' === get_post_type() ) {

			$content .= '<p>The Profile Image will be associated with this judge throughout the website.</p>';
			$content .= '<p><em>Recommended site for this image is&nbsp;480px&nbsp;&#215;&nbsp;600px.</em></p>';

		}

		return $content;

	}

	public function print_header_scripts() {

	}

	public function print_footer_scripts() {

	}

}

function ba_judges_init() {
	$BA_Judges = new BA_Judges();
}

add_action( 'plugins_loaded', 'ba_judges_init' );

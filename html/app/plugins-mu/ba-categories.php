<?php
/**
 * Must-Use Functions
 *
 * A class filled with functions that will never go away upon theme deactivation.
 *
 * @package WordPress
 * @subpackage BA
 */

class BA_Categories {

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
			'name'                  => _x( 'Categories', 'Post Type General Name', 'ba_categories' ),
			'singular_name'         => _x( 'Category', 'Post Type Singular Name', 'ba_categories' ),
			'menu_name'             => __( 'Categories', 'ba_categories' ),
			'name_admin_bar'        => __( 'Categories', 'ba_categories' ),
			'archives'              => __( 'Category Archives', 'ba_categories' ),
			'parent_item_colon'     => __( 'Parent Item:', 'ba_categories' ),
			'all_items'             => __( 'All Categories', 'ba_categories' ),
			'add_new_item'          => __( 'Add New Item', 'ba_categories' ),
			'add_new'               => __( 'Add New', 'ba_categories' ),
			'new_item'              => __( 'New Item', 'ba_categories' ),
			'edit_item'             => __( 'Edit Item', 'ba_categories' ),
			'update_item'           => __( 'Update Item', 'ba_categories' ),
			'view_item'             => __( 'View Item', 'ba_categories' ),
			'search_items'          => __( 'Search Item', 'ba_categories' ),
			'not_found'             => __( 'Not found', 'ba_categories' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'ba_categories' ),
			'featured_image'        => __( 'Category Icon', 'ba_categories' ),
			'set_featured_image'    => __( 'Set category icon', 'ba_categories' ),
			'remove_featured_image' => __( 'Remove category icon', 'ba_categories' ),
			'use_featured_image'    => __( 'Use as category icon', 'ba_categories' ),
			'insert_into_item'      => __( 'Insert into item', 'ba_categories' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'ba_categories' ),
			'items_list'            => __( 'Items list', 'ba_categories' ),
			'items_list_navigation' => __( 'Items list navigation', 'ba_categories' ),
			'filter_items_list'     => __( 'Filter items list', 'ba_categories' ),
		);
		$args = array(
			'label'                 => __( 'Categories', 'ba_categories' ),
			'description'           => __( 'Post Type Description', 'ba_categories' ),
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
			'menu_icon'							=> 'dashicons-awards',
			'rewrite'								=> array(
				'slug' => 'categories',
				'with_front' => false,
				'pages' => false,
			),
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
		);
		register_post_type( 'ba_categories', $args );

	}

	public function explain_feature_image( $content ) {

		if ( 'ba_categories' === get_post_type() ) {

			$content .= '<p>The Category Icon will be associated with this category throughout the website.</p>';
			$content .= '<p><em>Recommended site for this image is&nbsp;200px&nbsp;&#215;&nbsp;200px.</em></p>';

		}

		return $content;

	}

	public function print_header_scripts() {

	}

	public function print_footer_scripts() {

	}


}


function ba_categories_init() {
	$BA_Categories = new BA_Categories();
}

add_action( 'plugins_loaded', 'ba_categories_init' );

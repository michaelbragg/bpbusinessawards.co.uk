<?php
/**
 * Must-Use Functions
 *
 * A class filled with functions that will never go away upon theme deactivation.
 *
 * @package WordPress
 * @subpackage BA
 */

class BA_Partners {

	protected $metabox_id = '_ba_partners_';

	public function __construct() {

		add_action(
			'after_setup_theme',
			array( $this, 'define_constants' ),
			1
		);

		add_action(
			'init',
			array( $this, 'add_post_type' )
		);

		add_action(
			'init',
			array( $this, 'add_taxonomy' )
		);

		add_filter(
			'admin_post_thumbnail_html',
			array(
				$this,
				'explain_feature_image',
			)
		);

		add_action(
			'cmb2_init',
			array( $this, 'partner_url_metabox' )
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
			'name'                  => _x( 'Partners', 'Post Type General Name', 'ba_partners' ),
			'singular_name'         => _x( 'Partner', 'Post Type Singular Name', 'ba_partners' ),
			'menu_name'             => __( 'Partners', 'ba_partners' ),
			'name_admin_bar'        => __( 'Partners', 'ba_partners' ),
			'archives'              => __( 'Partner Archives', 'ba_partners' ),
			'parent_item_colon'     => __( 'Parent Item:', 'ba_partners' ),
			'all_items'             => __( 'All Partners', 'ba_partners' ),
			'add_new_item'          => __( 'Add New Item', 'ba_partners' ),
			'add_new'               => __( 'Add New', 'ba_partners' ),
			'new_item'              => __( 'New Item', 'ba_partners' ),
			'edit_item'             => __( 'Edit Item', 'ba_partners' ),
			'update_item'           => __( 'Update Item', 'ba_partners' ),
			'view_item'             => __( 'View Item', 'ba_partners' ),
			'search_items'          => __( 'Search Item', 'ba_partners' ),
			'not_found'             => __( 'Not found', 'ba_partners' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'ba_partners' ),
			'featured_image'		=> __( 'Logo', 'ba_partners' ),
			'set_featured_image' => __( 'Set logo', 'ba_partnes' ),
			'remove_featured_image' => __( 'Remove logo', 'ba_partners' ),
			'use_featured_image' => __( 'Use as logo', 'ba_partnes' ),
			'insert_into_item'      => __( 'Insert into item', 'ba_partners' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'ba_partners' ),
			'items_list'            => __( 'Items list', 'ba_partners' ),
			'items_list_navigation' => __( 'Items list navigation', 'ba_partners' ),
			'filter_items_list'     => __( 'Filter items list', 'ba_partners' ),
		);
		$args = array(
			'label'                 => __( 'Partners', 'ba_partners' ),
			'description'           => __( 'Post Type Description', 'ba_partners' ),
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
			'menu_icon'							=> 'dashicons-networking',
			'rewrite'								=> array(
				'slug' => 'partners',
				'with_front' => false,
				'pages' => false,
			),
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
		);
		register_post_type( 'ba-partners', $args );

	}

	public function add_taxonomy() {

		// Add new taxonomy, make it hierarchical (like categories)
		$labels = array(
			'name'              => _x( 'Partner Levels', 'taxonomy general name' ),
			'singular_name'     => _x( 'Partner Level', 'taxonomy singular name' ),
			'search_items'      => __( 'Search Partner Levels' , 'ba_partners' ),
			'all_items'         => __( 'All Partner Levels' , 'ba_partners' ),
			'parent_item'       => __( 'Parent Partner Level' , 'ba_partners' ),
			'parent_item_colon' => __( 'Parent Partner Level:' , 'ba_partners' ),
			'edit_item'         => __( 'Edit Partner Level' , 'ba_partners' ),
			'update_item'       => __( 'Update Partner Level' , 'ba_partners' ),
			'add_new_item'      => __( 'Add New Partner Level' , 'ba_partners' ),
			'new_item_name'     => __( 'New Partner Level Name' , 'ba_partners' ),
			'menu_name'         => __( 'Partner Level' , 'ba_partners' ),
		);

		$rewrite = array(
			'slug'                       => 'partner-levels',
			'with_front'                 => false,
			'hierarchical'               => true,
		);

		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
			'query_var'                  => true,
			'rewrite'                    => $rewrite,
		);

		register_taxonomy(
			'partner-levels',
			array( 'ba-partners' ),
			$args
		);

	}

	public function explain_feature_image( $content ) {

		if ( 'ba-partners' === get_post_type() ) {

			$content .= '<p>The Logo will be associated with this partner throughout the website.</p>';
			$content .= '<p><em>Recommended site for this image is&nbsp;800px&nbsp;&#215;&nbsp;300px.</em></p>';

		}

		return $content;

	}

	public function partner_url_metabox() {;

		$profile = new_cmb2_box( array(
			'id'						=> $this->metabox_id . 'profile',
			'title'				 	=> __( 'Company Details', 'ba-partners' ),
			'description'		=> __( 'Add the partners website address.', 'ba-partners' ),
			'object_types'	=> array( 'ba-partners', ),
			'context'				=> 'normal',
			'priority'			=> 'high',
			'show_names'		=> 'true',
		) );

		$profile->add_field( array(
			'id'						=> $this->metabox_id . 'partners_url',
			'name'				 	=> __( 'URL', 'ba-partners' ),
			'description'		=> __( 'Add the partners website address.', 'ba-partners' ),
			'type'					=> 'text_url',
			'protocols'			=> array( 'http', 'https', 'mailto' ),
			'attributes'		=> array(
			'placeholder'		=> __( 'eg, http://www.example.co.uk', 'ba-partners' ),
			'class'					=> '',
			),
		) );
	}

	public function print_header_scripts() {

	}
	public function print_footer_scripts() {

	}

}

/**
 * A function accessible via the front-end of the theme that will
 * return the swatches associated with the current post ID.
 *
 * @since    1.0.0
 *
*/
function ba_partners_get_url() {
	return get_post_meta( get_the_ID(), '_ba_partners_partners_url', true );
}

function ba_partners_init() {
	$BA_Partners = new BA_Partners();
}

add_action( 'plugins_loaded', 'ba_partners_init' );

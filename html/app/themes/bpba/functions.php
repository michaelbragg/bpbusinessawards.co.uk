<?php

/**
 * Fix for ACF not being able to handle symlinks
 * @TODO Remove when fixed or ACF is removed
 */
add_action( 'init', 'acf_hook', 0 );  // We use the 0 to bypass priority

function acf_hook() {
	if ( function_exists( 'acf' ) ) {
		acf()->settings['dir'] = WP_CONTENT_URL. '/plugins/advanced-custom-fields/';
	}
}

/**
 * Load functions files
 */
$function_includes = array(
	'functions/helper.php',						// Helper functions
	'functions/assets.php',						// Scripts and stylesheets
//	'functions/fields.php',						// Custom Template Admin Fields
//	'functions/template-tags.php',		// Custom template tags
	'functions/media.php',							// Updates to media files
);

foreach ( $function_includes as $file ) {
	if ( ! $filepath = locate_template( $file ) ) {
		trigger_error( sprintf( __( 'Error locating %s for inclusion', 'eecm_waterside' ), $file ), E_USER_ERROR );
	}
	require_once $filepath;
}

unset( $file, $filepath );


/**
 * bpba functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package bpba
 */

if ( ! function_exists( 'bpba_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function bpba_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on bpba, use a find and replace
		 * to change 'bpba' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'bpba', get_template_directory() . '/languages' );

		/**
		 * Let the end user add a custom logo via the WordPress admin
		 */
		add_theme_support( 'custom-logo' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary', 'bpba' ),
			'social'  => __( 'Social Links Menu', 'bpba' ),
			'nominate'  => __( 'Nominate Menu', 'bpba' ),
			'events'  => __( 'Events Sites', 'bpba' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		/*
		 * Enable support for Post Formats.
		 * See https://developer.wordpress.org/themes/functionality/post-formats/
		 */
		add_theme_support( 'post-formats', array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'bpba_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );
	}
	endif;

	add_action( 'after_setup_theme', 'bpba_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function bpba_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'bpba_content_width', 640 );
}
add_action( 'after_setup_theme', 'bpba_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function bpba_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'bpba' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'bpba_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function bpba_scripts() {

	wp_enqueue_style( 'bpba-fonts', '//fast.fonts.net/cssapi/2896c3ef-2b78-4bc2-9652-3329e9098a71.css', array(), '1.0.0', 'all' );

	wp_enqueue_style( 'bpba-style', get_stylesheet_uri(), array( 'bpba-fonts' ), '1.0.0' );

	wp_enqueue_script( 'bpba-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'bpba-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_page() && is_page( 'entry' ) ) {
		wp_enqueue_script( 'bpba-nomination', get_template_directory_uri() . '/js/jquery.nomination.js', array( 'jquery' ), '0.1.0', true );
	}

}
add_action( 'wp_enqueue_scripts', 'bpba_scripts' );

/**
 * Alter the default WP Query for Categries post type
 */
function change_archive_categories_loop( $query ) {
	if ( $query->is_main_query() && ! is_admin() && is_post_type_archive( 'ctba_categories' ) ) {
		$query->set( 'posts_per_page', '30' );
		$query->set( 'order', 'ASC' );
		$query->set( 'orderby', 'menu_order' );
	}
}

add_action( 'pre_get_posts', 'change_archive_categories_loop' );


/**
 * Add custom query variable for failed logins.
 */

function add_query_vars_login( $vars ){
	$vars[] = 'status';
	return $vars;
}

add_filter( 'query_vars', 'add_query_vars_login' );

/**
 * Redirect failed login to referrer page
 */

function my_front_end_login_fail( $username ) {
	// Check if referer is present
	if ( isset( $_SERVER['HTTP_REFERER'] ) ) {
		$referrer = esc_url( $_SERVER['HTTP_REFERER'] );
	}
	// if there's a valid referrer, and it's not the default log-in screen
	if ( ! empty( $referrer ) && ! strstr( $referrer,'wp-login' ) && ! strstr( $referrer,'wp-admin' ) ) {
		wp_redirect( esc_url_raw( add_query_arg( array( 'status' => 'failed' ), $referrer ) ) );
		exit;
	}
}

add_action( 'wp_login_failed', 'my_front_end_login_fail' );

/**
 * Set up Editor stylesheet
 */
function bpba_add_editor_styles() {
	add_editor_style( 'editor-style.css' );
}

add_action( 'admin_init', 'bpba_add_editor_styles' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

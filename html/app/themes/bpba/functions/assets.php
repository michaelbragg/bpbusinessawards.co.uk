<?php
/**
 * Manage assets for theme
 */

/**
 * Dequeue scripts.
 */

function bpba_dequeue_scripts()  {
	//wp_dequeue_script( 'name' );
}

add_action( 'wp_print_scripts', 'bpba_dequeue_scripts', 100 );

/**
 * Dequeue styles.
 */

function bpba_dequeue_styles()  {
	//wp_dequeue_style( 'name' );
}

add_action( 'wp_print_styles', 'bpba_dequeue_styles', 100 );

/**
 * Register scripts
 */

wp_register_script(
	'bpba-navigation',
	get_template_directory_uri() . '/js/navigation.js',
	array( 'jquery' ),
	'20120206',
	true
);

wp_register_script(
	'bpba-skip-link-focus-fix',
	get_template_directory_uri() . '/js/skip-link-focus-fix.js',
	array(),
	'20130115',
	true
);

wp_register_script(
	'bpba-nomination',
	get_template_directory_uri() . '/js/jquery.nomination.js',
	array( 'jquery' ),
	'0.1.0',
	true
);

wp_register_script(
	'bpba-fitvids',
	get_template_directory_uri() . '/library/FitVids/jquery.fitvids.js',
	array( 'jquery' ),
	'1.1.0',
	true
);

wp_add_inline_script(
	'bpba-fitvids',
	'(function( $ ) { $(document).ready(function(){$(".entry-content").fitVids();});} )( jQuery );'
);


/**
 * Register styles
 */

// Default WordPress stylesheet

wp_register_style(
	'bpba-style',
	get_stylesheet_uri(),
	array( 'bpba-fonts' ),
	'0.1.0'
);

wp_register_style(
	'bpba-fonts',
	'//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,700italic,700',
	array(),
	null
);

/**
 * Enqueue scripts
 */

function bpba_scripts_load_global() {
	// Scripts to be loaded globally
	wp_enqueue_script( 'bpba-navigation' );
	wp_enqueue_script( 'bpba-skip-link-focus-fix' );

	//Scripts to be loaded for nomination pages
	if ( is_page() && is_page( 'entry' ) ) {
		wp_enqueue_script( 'bpba-nomination' );
	}

	if ( is_page() && is_front_page() ) {
		wp_enqueue_script( 'bpba-fitvids' );
	}

}

add_action(
	'wp_enqueue_scripts',
	'bpba_scripts_load_global',
	100
);

/**
 * Enqueue styles
 */

function bpba_styles_load_global() {
	// Styles to be loaded globally
	wp_enqueue_style( 'bpba-style' );
	wp_enqueue_style( 'bpba-fonts' );
}

add_action(
	'wp_enqueue_scripts',
	'bpba_styles_load_global',
	100
);

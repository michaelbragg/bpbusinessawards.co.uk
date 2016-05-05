<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ctba-2016
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php if ( ! get_field( 'hero_hide' ) ) { body_class( 'has-hero' ); } else { body_class(); }; ?>>

	<?php if ( function_exists( 'HM_GTM\tag' ) ) { HM_GTM\tag(); } ?>

	<div id="page" class="site">
		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'ctba-2016' ); ?></a>

		<header class="header__main site-header fixed cf" id="masthead">
		  <div class="wrapper__sub">

				<?php echo bpba_custom_logo(); ?>

		    <nav id="site-navigation" class="nav__main">

		      <a href="#nav-footer" class="navicon navicon__right ls-hidden" aria-controls="site-navigation" aria-expanded="false">Menu</a>

		      <?php wp_nav_menu(
		      	array(
		      		'theme_location' => 'primary',
		      		'menu_id' => 'js-nav__main' ,
		      		'menu_class' => 'nav__main__right list menu',
		      		'container' => '',
	      		)
	      	);
		      ?>

		    </nav>

		  </div>
		</header>

<?php if ( get_field( 'hero_hide' ) ) {
	return;
} else { ?>
<section class="hero wrapper box__large hero--image" style="background-image: url(<?php if( get_field( 'hero_image' ) ){ echo wp_get_attachment_url( get_field( 'hero_image' ) ); } else { echo get_template_directory_uri() . '/gui/hero_default.jpg'; }  ?>);">

  <section class="wrapper__sub">

    <div class="hero__content">
      <?php if( get_field( 'hero_tagline' ) ){ ?><p class="hero__copy gamma"><?php the_field( 'hero_tagline' ); ?></p><?php } else { echo '<p class="hero__copy gamma">Celebrate your success in business with the Birmingham Post.</p>'; } ?>
      <?php if( get_field( 'hero_btn_link' ) ){ ?><a class="hero__btn btn btn--primary" href="<?php the_field( 'hero_btn_link' ); ?>"><?php the_field( 'hero_btn_text' ); ?></a><?php } ?>
    </div>

  </section>

</section>
<?php } ?>

	<div id="content" class="site-content">

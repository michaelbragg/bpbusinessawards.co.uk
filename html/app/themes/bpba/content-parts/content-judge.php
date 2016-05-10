<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package bpba
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
			the_title( '<h1 class="gamma heading--main entry-title">', '</h1>' );
		?>
	</header><!-- .entry-header -->

	<div class="entry-content">

			<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail(
				'profile-judge',
				array(
					'class' => 'alignright sizemedium image',
				)
			); ?>
			<?php endif; ?>

			<?php
			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'bpba' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );
			?>

	</div><!-- .entry-content -->

	<footer class="entry-footer cf">
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'bpba' ),
				'after'  => '</div>',
			) );
		?>
		<?php ba_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->

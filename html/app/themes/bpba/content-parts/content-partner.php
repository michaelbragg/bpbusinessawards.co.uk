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
				array( 280 ),
				array(
					'class' => 'image__responsive alignright sizemedium',
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

			<?php if ( get_field( 'ba-partners-url' ) ) : ?><p><a href="<?php echo esc_url( get_field( 'ba-partners-url' ) ); ?>" target="_blank" class="outbound link"  rel="nofollow"><?php the_title(); ?></a></p><?php endif; ?>

		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'bpba' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php ctba_2016_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->

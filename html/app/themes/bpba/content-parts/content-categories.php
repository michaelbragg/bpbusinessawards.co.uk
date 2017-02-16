<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package bpba
 */

?>

<li class="block category-item">
	<aside class="block__aside category-item__aside">
	<a href="<?php echo esc_url( get_permalink() ); ?>">
		<?php
		if ( has_post_thumbnail() ) {
			the_post_thumbnail( array( 88, 88 ), array( 'class' => '' ) );
		}
		?>
	</a>
	</aside>
	<p class="block__content category-item__title">
	<a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
	</p>
</li>

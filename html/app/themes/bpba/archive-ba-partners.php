<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package bpba
 */

get_header(); ?>

	<div id="primary" class="content-area">

		<main id="main" class="box__large content__main wrapper cf">
		  <div class="wrapper__sub">
		    <article class="content__main ss1-ss4 ms1-ms6 ls1-ls8 separator">

	<?php
	if ( have_posts() ) :
		// @TODO Move copy to plugin
	?>
			<header class="page-header box">
				<h1 class="gamma heading--main page-title">2016 Partners</h1>
				<h2>Become a partner:</h2>
				<p>For more information regarding sponsorship opportunities, call Sophia Hayes on <a href="tel:08453313031">08453 31 30 31</a> / <a href="tel:07557133880">07557 133 880</a> or email <a href="mailto:shayes@championsukplc.com">shayes@championsukplc.com</a>.</p>
			</header><!-- .page-header -->

  <ul class="judges judges__columns list">

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();?>

			<li class="block partners-item box separator--horizontal">
			  <aside class="block__aside partners-item__aside">
			    <?php if ( has_post_thumbnail() ) : ?>
			    <a href="<?php echo esc_url( get_permalink() ); ?>">
					<?php the_post_thumbnail(
						'logo-parter',
						array(
							'class' => 'image__responsive',
						)
					); ?>
					</a>
					<?php endif; ?>
			  </aside>
			  <articles class="block__content partners-item__content">
			    <h3><?php the_title(); ?></h3>
			    <p>
						<a href="<?php echo esc_url( get_permalink() ); ?>">View Profile</a><?php if ( ba_partners_get_url() ) : ?> | <a target="_blank" class="outbound link" href="<?php echo esc_url( ba_partners_get_url() ); ?>" rel="nofollow">View Website</a><?php endif; ?>
					</p>
			  </articles>
			</li>

			<?php endwhile; ?>
			</ul>
	<?php else : ?>

		<?php get_template_part( 'content-parts/content', 'none' ); ?>

	<?php endif; ?>

		    </article>

			<aside id="secondary" class="content__aside widget-area ss1-ss4 ms1-ms6 ls9-ls12">
				<?php get_sidebar(); ?>
			</aside>

		  </div>
		</main>

	</div><!-- #primary -->

<?php

get_footer();

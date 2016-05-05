<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ctba-2016
 */

get_header(); ?>

	<div id="primary" class="content-area">

		<main id="main" class="box__large content__main wrapper cf">
			<div class="wrapper__sub">
				<article class="content__main ss1-ss4 ms1-ms6 ls1-ls8 separator">

			<?php if ( have_posts() ) : ?>
					<header class="page-header">
						<h1 class="gamma heading--main page-title">Entry Categories</h1>
						<h2>Choose a category/categories that you would like to enter below:</h2>
						<p>Was 2015 or the start of 2016 a good year for your business? Have you launched a <strong>new</strong> product or enjoyed <strong>success</strong> with exporting? Have you launched a new <strong>business</strong> or <strong>expanded</strong> your existing business? If the answer is &lsquo;yes&rsquo; to any of the questions then you can enter any of the award categories for <strong>free</strong> below:</p>
					</header><!-- .page-header -->

					<ul class="categories categories__columns list cf">

					<?php
					/* Start the Loop */
					while ( have_posts() ) : the_post();?>
					<?php

						get_template_part( 'content-parts/content', 'categories' );

					endwhile;
					?>
					</ul>
			<?php else :

					get_template_part( 'content-parts/content', 'none' );

				endif; ?>

				</article>

				<aside class="content__aside ss1-ss4 ms1-ms6 ls9-ls12">
					<?php get_sidebar(); ?>
				<aside>

			</div>
		</main>

	</div><!-- #primary -->

<?php

get_footer();

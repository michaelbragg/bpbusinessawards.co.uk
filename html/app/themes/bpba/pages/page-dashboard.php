<?php /* Template Name: Dashboard */

/**
 * Check the user is logged in
 */
if ( ! is_user_logged_in() ) {
	wp_redirect( home_url( $path = 'login' ) );
	exit;
}

// Only get out entry information once by storing it as a variable
$get_entry = get_entry( $current_user->ID );

// Get current users details
$current_user = wp_get_current_user();

get_header(); ?>

<div id="primary" class="content-area">

	<main id="main" class="box__large content__main wrapper cf" role="main">
	  <div class="wrapper__sub">
	    <article class="content__main ss1-ss4 ms1-ms6 ls1-ls12">
				<?php wp_nav_menu( array( 'theme_location' => 'nominate', ) ); ?>

				<header class="entry-header">
					<?php printf( '<h1 class="gamma heading--main entry-title">%1$s</h1>', esc_html__( 'Dashboard', 'ctba-2016' ) ); ?>
					<p><?php
					printf( '%1$s, %2$s ', esc_html__( 'Welcome', 'ctba-2016' ), esc_html( $current_user->display_name ) );
					printf( '(%1$s <a href="%2$s">%3$s</a>).', esc_html__( 'not you', 'ctba-2016' ), esc_url( home_url( $path = 'logout' ) ), esc_html__( 'log out', 'ctba-2016' ) );
					?></p>

				</header><!-- .entry-header -->

				<div class="entry-content">

				<?php the_content(); ?>

				<?php if ( $get_entry->have_posts() ) : ?>
				<table class="table-dashboard">
				<thead>
				<tr>
				<th class="table-dashboard-company"><?php esc_html_e( 'Company', 'ctba-2016' ); ?></th>
				<th class="table-dashboard-categories"><?php esc_html_e( 'Categories', 'ctba-2016' ); ?></th>
				<th class="table-dashboard-status"><?php esc_html_e( 'Status', 'ctba-2016' ); ?></th>
				<th class="table-dashboard-edit"><?php esc_html_e( 'Edit', 'ctba-2016' ); ?></th>
				</tr>
				</thead>
				<tbody>

				<?php while ( $get_entry->have_posts() ) : $get_entry->the_post(); ?>

					<tr id="entry-<?php the_ID(); ?>">
					<td><?php the_title( '<strong>', '</strong>' ); ?></td>
					<td><?php echo esc_html( get_entered_categories( ) ); ?></td>
					<td><?php the_post_status(); ?></td>
					<td><a href="<?php echo esc_url( edit_entries_link() ); ?>">Edit</a></td>
					</tr>

					<?php endwhile; ?>
					</tbody>
					</table>
				<?php  // reset the query
				wp_reset_postdata(); ?>

			<?php else : ?>
				<?php /* Add new entry link */ ?>
				<?php printf( '<a href="%2$s" class="btn">%1$s</a>', esc_html__( 'New entry form', 'ctba-2016' ), esc_url( site_url( '/nominate/entry/' ) ) ); ?>
			<?php endif; ?>
				</div><!-- .entry-content -->


	    </article>

	  </div>
	</main>

</div><!-- .content-area -->

<?php get_footer(); ?>

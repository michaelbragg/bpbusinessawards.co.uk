<?php /* Template Name: Login */

if ( is_user_logged_in() ) {
	wp_redirect( home_url( '/' ) );
	exit;
}

/** @TODO: Refactor to Site Settings Option. */
$nomination_status = false;

// Check if the login failed
$login_status = ( get_query_var( 'status' ) === 'failed' ? true : false );

get_header(); ?>

	<div id="primary" class="content-area">

		<main id="main" class="content__main wrapper cf" role="main">
			<div class="wrapper__sub">
				<article class="ss1-ss4 ms1-ms6 ls1-ls12 module login-form">

				<?php the_title( '<h1 class="gamma heading--main page-title">', '</h1>' ); ?>

				<?php if( $nomination_status ):?>
					<p>
					<?php printf(
						'%1$s <a href="%2$s">%3$s</a>.',
						esc_html__( 'Not got an account?', 'bpba-2016' ),
						esc_url( home_url( 'register/' ) ),
						esc_html__( 'Click here to register', 'bpba-2016' )
					); ?>
					</p>
				<?php else: ?>
					<section class="alert alert--message alert--info alert--type box" role="alert">
						<p>
						<?php printf(
							'<strong>%1$s</strong> %2$s</p>',
							esc_html__( 'Info', 'bpba-2016' ),
							esc_html__( 'Registration for this year&rsquo;s awards have closed.', 'bpba-2016' )
						); ?>
						</p>
					</section>
				<?php endif;?>

				<?php if ( true === $login_status ) : ?>
					<section class="alert alert--message alert--warning alert--type box" role="alert">
						<!--<a class="alert__close" href="#">×</a>-->
						<p>
						<?php printf(
							'<strong>%1$s</strong> %2$s</p>',
							esc_html__( 'Ooops', 'bpba-2016' ),
							esc_html__( 'Incorrect username or password. Please try again.', 'bpba-2016' )
						); ?>
						</p>

					</section>
				<?php endif; ?>

				<form id="member-login" action="<?php echo esc_url( home_url( 'wp-login.php' ) ); ?>" method="POST" enctype="multipart/form-data">

					<fieldset id="account-details">

						<label for="log"><?php esc_html_e( 'Username', 'bpba-2016' ); ?></label>
						<input type="text" name="log" id="log" required>

						<label for="pwd"><?php esc_html_e( 'Password', 'bpba-2016' ); ?></label>
						<input type="password" name="pwd" id="pwd" required>

						<label class="checkbox">
							<input type="checkbox" name="rememberme" value="forever"> <?php esc_html_e( 'Remember Me', 'bpba-2016' ); ?>
						</label>

						<input type="hidden" name="redirect_to" value="<?php echo esc_url( home_url( 'nominate/' ) ); ?>">

						<button class="btn btn__large" type="submit" name="submit" id="submit"><?php esc_html_e( 'Login', 'bpba-2016' ); ?></button>

					</fieldset>

				</form>

				</article>
			</div>
		</main>

	</div><!-- .content-area -->

<?php get_footer(); ?>

<?php
/**
 * The template used for displaying dashboard content
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

$entry = get_query_var( 'entry' );
$object_id = ( get_query_var( 'entry' ) !== '' ? $entry : 0 );
// Check if the login failed
$entry_status = ( get_query_var( 'status' ) === 'saved' ? true : false );
?>

<article id="entry-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="gamma heading--main entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">

		<?php if ( true === $entry_status ) : ?>
			<section class="alert alert--message alert--positive alert--type box" role="alert">
				<!--<a class="alert__close" href="#">×</a>-->
				<p>
				<?php printf(
					'<strong>%1$s!</strong> %2$s</p>',
					esc_html__( 'Saved', 'bpba-2016' ),
					esc_html__( 'Your entry has been saved. Feel free to come back and edited it before submitting.', 'bpba-2016' )
				); ?>
				</p>

			</section>
		<?php endif; ?>

		<p>Please use the questions below as a guide and feel free to expand on these by providing supporting documents as you wish.</p>
<?php

function get_meta_boxes(){

	/**
	 * This is the metabox id, and array of options to be used in styling the metabox
	 * Add metabox to be outputted must be listed here.
	 */

	$array = array(
		'_bpba_entries_2016_common' => array(
			'title' => 'Common Questions',
			'js-id' => '_bpba_entries_2016_common',
		),
		'_bpba_entries_2016_companyyear' => array(
			'title' => 'Company of the Year',
			'js-id' => '_bpba_entries_2016_companyyear',
		),
		'_bpba_entries_2016_smallbusiness' => array(
			'title' => 'Small Business of the Year',
			'js-id' => '_bpba_entries_2016_smallbusiness',
		),
		'_bpba_entries_2016_newbusiness' => array(
			'title' => 'New Business of the Year',
			'js-id' => '_bpba_entries_2016_newbusiness',
		),
		'_bpba_entries_2016_entrepreneur' => array(
			'title' => 'Business Entrepreneur of the Year',
			'js-id' => '_bpba_entries_2016_entrepreneur',
		),
		'_bpba_entries_2016_legal' => array(
			'title'	=> 'Legal Services',
			'js-id'	=> '_bpba_entries_2016_legal',
		),
		'_bpba_entries_2016_financial' => array(
			'title'	=> 'Financial Services',
			'js-id'	=> '_bpba_entries_2016_financial',
		),
		'_bpba_entries_2016_marketing' => array(
			'title' => 'Sales and Marketing',
			'js-id' => '_bpba_entries_2016_marketing',
		),
		'_bpba_entries_2016_manufacturing' => array(
			'title' => 'Excellence in Manufacturing',
			'js-id' => '_bpba_entries_2016_manufacturing',
		),
		'_bpba_entries_2016_technology' => array(
			'title' => 'Excellence in Science and Technology',
			'js-id' => '_bpba_entries_2016_technology',
		),
		'_bpba_entries_2016_retail' => array(
			'title' => 'Retail Business of the Year',
			'js-id' => '_bpba_entries_2016_retail',
		),
		'_bpba_entries_2016_creative' => array(
			'title' => 'Creative Communications &amp; Digital Business of the Year',
			'js-id' => '_bpba_entries_2016_creative',
		),
		'_bpba_entries_2016_export' => array(
			'title' => 'Export',
			'js-id' => '_bpba_entries_2016_export',
		),
		'_bpba_entries_2016_community' => array(
			'title' => 'Contribution to the Community',
			'js-id' => '_bpba_entries_2016_community',
		),
		'_bpba_entries_2016_notforprofit' => array(
			'title' => 'Not-for-profit Organisation',
			'js-id' => '_bpba_entries_2016_notforprofit',
		),
		'_bpba_entries_2016_additional' => array(
			'title' => 'Additional Information',
			'js-id' => '_bpba_entries_2016_additional',
		),
	);

	return $array;
}


echo '<form class="cmb-form" method="post" id="bpba-2016-entries-form" enctype="multipart/form-data" encoding="multipart/form-data">
    <input type="hidden" name="object_id" value="'. esc_attr( $object_id ) .'">';

$args = array(
	'form_format' => '%3$s',
	'save_fields' => false,
);


//$form;
foreach ( get_meta_boxes() as $metabox => $options ) { // loop over config array ?>
	<?php $category_status = ( ! in_array( $metabox, array( '_bpba_entries_2016_common', '_bpba_entries_2016_additional' ) ) ) ? 'data-state="visible"' : null; ?>
	<div id="<?php echo esc_attr( $options['js-id'] ); ?>" class="entry-category form-table" <?php echo esc_html( $category_status ); ?>>
	<h2 class="gamma heading--main"><?php echo esc_html( $options['title'] ); ?></h2>
	<?php cmb2_metabox_form( $metabox, $object_id, $args ); ?>
	<div class="save-button">
		<button type="submit" name="submit-cmb" value="Submit" class="btn btn--primary">Save</button>
	</div>
	</div>
<?php } ?>
<div class="submit-button">
<input type="submit" name="submit-cmb" value="Submit" class="btn btn--primary">
</div>
</form>



	</div><!-- .entry-content -->

	<?php
		edit_post_link(
			sprintf(
				/* translators: %s: Name of current post */
				__( 'Edit<span class="screen-reader-text"> "%s"</span>', 'twentysixteen' ),
				get_the_title()
			),
			'<footer class="entry-footer"><span class="edit-link">',
			'</span></footer><!-- .entry-footer -->'
		);
	?>

</article><!-- #entry-<?php the_ID(); ?> -->

<section id="bpba-alert" class="alert alert--message alert--type box" role="alert" data-state="hidden">
	<!--<a class="alert__close" href="#">×</a>-->
	<p>
	<?php printf(
		'<strong>%1$s</strong> %2$s</p>',
		esc_html__( 'Info', 'bpba-2016' ),
		esc_html__( 'Entry&rsquo;s are limited to 3 categories.', 'bpba-2016' )
	); ?>
	</p>

</section>

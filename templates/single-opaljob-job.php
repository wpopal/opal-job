<?php
/**
 * The Template for displaying all single Opaljob Forms.
 *
 * Override this template by copying it to yourtheme/opaljob/single-opaljob-forms.php
 *
 * @package       Opaljob/Templates
 * @version       1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();

/**
 * Fires in single form template, before the main content.
 *
 * Allows you to add elements before the main content.
 *
 * @since 1.0
 */
do_action( 'opaljob_before_main_content' );

while ( have_posts() ) : the_post();
	global $job; 

	$job = opaljob_new_job_object ( get_the_ID() );

	opaljob_render_template( 'single-job/content-single-job' );

endwhile; // end of the loop.

/**
 * Fires in single form template, after the main content.
 *
 * Allows you to add elements after the main content.
 *
 * @since 1.0
 */
do_action( 'opaljob_after_main_content' );

/**
 * Fires in single form template, on the sidebar.
 *
 * Allows you to add elements to the sidebar.
 *
 * @since 1.0
 */
do_action( 'opaljob_sidebar' );

get_footer();
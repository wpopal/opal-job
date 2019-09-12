<?php 
/**
 * Define 
 * Note: only use for internal purpose.
 *
 * @package     OpalJob
 * @copyright   Copyright (c) 2019, WpOpal <https://www.wpopal.com>
 * @license     https://opensource.org/licenses/gpl-license GNU Public License
 * @since       1.0
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_footer', 'opaljob_login_register_form_popup', 9 );
add_action( 'wp_footer', 'opaljob_apply_form_popup', 9 );
/**
 * Single Job Hook To Templates
 */

/**
 * ///////Single Job Hook To Templates/////////////////////////////////////////
 */


/**
 * The args to pass to the give_get_collection() query
 *
 * @since  1.0
 */

add_action( "opaljob_single_job_content_before" , "opaljob_display_employer_summary" );

add_action( "opaljob_single_job_content_after", "opaljob_render_related_job" );
// content sections 
add_action( "opaljob_single_job_content_sections" , "opaljob_single_job_content_sections_content" );
//content sidebar
add_action( "opaljob_single_job_content_sidebar" , "opaljob_single_job_content_sections_map" );
add_action( "opaljob_single_job_content_sidebar" , "opaljob_single_job_content_sections_job_summary" );

/**
 * Single Candicate Hooks to Templates
 */
/**
 * The args to pass to the give_get_collection() query
 *
 * @since  1.0
 */
// top 
add_action( "opaljob_single_candidate_content_before" , "opaljob_single_candidate_content_section_summary" );

// sections 
add_action( "opaljob_single_candidate_content_sections" , "opaljob_single_candidate_content_section_meta" );
add_action( "opaljob_single_candidate_content_sections" , "opaljob_single_candidate_content_section_content" );
add_action( "opaljob_single_candidate_content_sections" , "opaljob_single_candidate_content_section_resume" );
// sidebar 
add_action( "opaljob_single_candidate_content_sidebar", "opaljob_display_candidate_contact_form" );


/**
 * ///////Single EMPLOYER Hook To Templates/////////////////////////////////////////
 */
//add_action( "opaljob_single_employer_content_sidebar", "opaljob_display_employer_contact_form" );

// top/// 
add_action( "opaljob_single_employer_content_before" , "opaljob_single_employer_content_section_navbar" , 2 );

add_action( "opaljob_single_employer_content_before" , "opaljob_single_employer_content_sections_summary" , 3 );

add_action( "opaljob_single_employer_content_sidebar" , "opaljob_single_employer_content_sections_jobs" , 3 );
add_action( "opaljob_single_employer_content_sidebar" , "opaljob_single_employer_content_sections_content" , 5 );

add_action( "opaljob_single_employer_content_sidebar" , "opaljob_single_employer_content_sections_gallery" , 6 );
add_action( "opaljob_single_employer_content_sidebar" , "opaljob_single_employer_content_sections_video", 7 );
add_action( "opaljob_single_employer_content_sidebar" , "opaljob_single_employer_content_sections_map", 8 );
?>
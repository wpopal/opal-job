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

/********************************************************************************************************************************************************
 *  
 *  ARCHIVE JOB -- HOOKS FUNCTIONS 
 *  
 *********************************************************************************************************************************************************/

add_action( 'opaljob_before_archive_content_before', 'opaljob_get_search_job_form', 3 );
/// /////
///  Main Layout
/// ///
add_action( 'init', 'opaljob_layout_container', 9 );
// dashboard////
// 
// 


///
add_action( 'wp_footer', 'opaljob_login_register_form_popup', 9 );
add_action( 'wp_footer', 'opaljob_apply_form_popup', 9 );
/**
 * Single Job Hook To Templates
 */

/********************************************************************************************************************************************************
 *  
 *  SINGLE JOB -- HOOKS FUNCTIONS 
 *  
 *********************************************************************************************************************************************************/
function opaljob_single_job_tab_style () {
	/// create job tab setting
	add_action( "opaljob_single_job_content_before", "opaljob_single_tab_nav" , 10 );
	add_action( "opaljob_single_job_content_after" , "opaljob_single_job_employer_info" , 16 );
	add_action( "opaljob_single_job_content_after" , "opaljob_single_job_listing" , 16 );


	opaljob_single_job_tab_contents();
}
add_action( "opaljob_before_main_content", "opaljob_single_job_tab_style" , 1 );
/// end 

/**
 * The args to pass to the give_get_collection() query
 *
 * @since  1.0
 */

add_action( "opaljob_single_job_content_before" , "opaljob_display_employer_summary" , 3 );
add_action( "opaljob_single_job_content_after", "opaljob_render_related_job" , 6 );

// content sections 
add_action( "opaljob_single_job_content_sections" , "opaljob_single_job_content_sections_content" , 10 );
add_action( "opaljob_single_job_content_sections" , "opaljob_single_job_content_sections_map" , 12  );
add_action( "opaljob_single_job_content_sections" , "opaljob_single_job_content_sections_job_tags", 15 );

//content sidebar
add_action( "opaljob_single_job_content_sidebar" , "opaljob_single_job_meta_list", 3 );
add_action( "opaljob_single_job_content_sidebar" , "opaljob_single_job_content_sections_job_summary", 6 );

add_action( "opaljob_single_job_content_sidebar" , "opaljob_display_enquiry_form" , 12  );






/**
 * Single Candidate Hooks to Templates
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


add_action( "opaljob_single_employer_content_before" , "opaljob_single_employer_content_sections_summary" , 2 );


add_action( "opaljob_single_employer_content_before" , "opaljob_single_employer_content_sections_jobs_listing" , 5 );

add_action( "opaljob_single_employer_content_before" , "opaljob_single_employer_content_section_navbar" , 7 );

add_action( "opaljob_single_employer_content_sections" , "opaljob_single_employer_content_sections_content" , 8 );

add_action( "opaljob_single_employer_content_sections" , "opaljob_single_employer_content_sections_gallery" , 10 );
add_action( "opaljob_single_employer_content_sections" , "opaljob_single_employer_content_sections_video", 12 );
//// sidebar 

add_action( "opaljob_single_employer_content_sidebar" , "opaljob_single_employer_meta_list", 8 );
add_action( "opaljob_single_employer_content_sidebar" , "opaljob_display_employer_contact_form", 10 );
add_action( "opaljob_single_employer_content_sidebar" , "opaljob_single_employer_content_sections_map", 12 );
?>
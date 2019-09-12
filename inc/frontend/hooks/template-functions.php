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

function opaljob_display_member_social_icons () {
    global $member; 
    $socials = array(
        'facebook' => $member->get_meta( 'facebook' ),
        'twitter' => $member->get_meta( 'twitter' ),
        'pinterest' => $member->get_meta( 'pinterest' ),
        'google' => $member->get_meta( 'google' ),
        'instagram' => $member->get_meta( 'instagram' ),
        'linkedIn' => $member->get_meta( 'linkedIn' )
    );    
    opaljob_render_template( 'common/social-icons', $socials );
}

if ( ! function_exists( "opaljob_login_register_form_popup" ) ) {
    function opaljob_login_register_form_popup() {  
        opaljob_render_template( 'user/my-account-popup' );
    }
}


function opaljob_apply_form_popup() {
    
}


function opaljob_render_related_job () {
    $module = new \Opal_Job\Common\Module\Related_Job();
    $module->render();
}

/**
 * The args to pass to the give_get_collection() query
 *
 * @since  1.0
 * @access public
 *
 * @var    array
 */
function opaljob_display_enquiry_form() {
	opaljob_render_template( 'messages/enquiry-form' );
}

function opaljob_following_button( $atts ) {   
    opaljob_render_template( 'single-employer/parts/following-button' ,$atts );
}
/////////////////////////// CANDIDATE Templates functions ////////////////////////////
///
/**
 * The args to pass to the give_get_collection() query
 *
 * @since  1.0
 * @access public
 *
 * @var    array
 */
function opaljob_display_candidate_contact_form() {
	global $member; 
    $email = $member->get_email();
    $args  = [
        'post_id' => 0,
        'id'      => $member->ID,
        'email'   => $email,
        'message' => '',
        'type'    => 'employer',
        'popup'   => false
    ];
    opaljob_render_template( 'messages/contact-form', $args );
}

function opaljob_single_candidate_content_section_navbar () {
    opaljob_render_template( 'single-candidate/parts/navbar' );
}

function opaljob_single_candidate_content_section_meta () {
    opaljob_render_template( 'single-candidate/parts/meta' );
}


function opaljob_single_candidate_content_section_content() {
    opaljob_render_template( 'single-candidate/parts/content' );
}


function opaljob_single_candidate_content_section_summary () {
    opaljob_render_template( 'single-candidate/parts/summary' );
}

function opaljob_single_candidate_content_section_resume () {
    opaljob_render_template( 'single-candidate/parts/resume' );
}
 

/////////////////////////// Employer Templates functions ////////////////////////////

/**
 * The args to pass to the give_get_collection() query
 *
 * @since  1.0
 * @access public
 *
 * @var    array
 */
function opaljob_display_employer_contact_form() {
	global $member; 
	$email = $member->get_email();
    $args  = [
        'post_id' => 0,
        'id'      => $member->ID,
        'email'   => $email,
        'message' => '',
        'heading' => 'Contact Us',
        'type'    => 'employer',
        'popup'   => true
    ];
	opaljob_render_template( 'messages/contact-form', $args );
}

/// 
function opaljob_display_employer_summary() {  
    $args = array();
    opaljob_render_template( 'single-job/parts/employer-summary', $args );
}

/**
 * The args to pass to the give_get_collection() query
 *
 * @since  1.0
 * @access public
 *
 * @var    array
 */
function opaljob_single_job_content_sections_content() {
     opaljob_render_template( 'single-job/parts/job-content' );
}

/**
 * The args to pass to the give_get_collection() query
 *
 * @since  1.0
 * @access public
 *
 * @var    array
 */
function opaljob_single_job_content_sections_map() {
     opaljob_render_template( 'single-job/parts/map' );
}

/**
 * The args to pass to the give_get_collection() query
 *
 * @since  1.0
 * @access public
 *
 * @var    array
 */
function opaljob_single_job_content_sections_job_summary() {
    
    $summaries = array();
    $summaries[] =  array(
                'icon'   => 'fa fa-gear',
                'label'  => esc_html__( "Date Posted", "opaljob" ),
                'value'  => '17/12/8888'
    );

    $summaries[] = array(
                'icon'   => 'fa fa-gear',
                'label'  => esc_html__( "Date Posted", "opaljob" ),
                'value'  => '17/12/8888'
    );

    $summaries[] = array(
                'icon'   => 'fa fa-gear',
                'label'  => esc_html__( "Date Posted", "opaljob" ),
                'value'  => '17/12/8888'
    );

    $summaries[] = array(
                'icon'   => 'fa fa-gear',
                'label'  => esc_html__( "Date Posted", "opaljob" ),
                'value'  => '17/12/8888'
    );
    opaljob_render_template( 'single-job/parts/job-summary' , array('summaries'=> $summaries ) );
}

/**
 * The args to pass to the give_get_collection() query
 *
 * @since  1.0
 * @access public
 *
 * @var    array
 */
function opaljob_job_render_favorite_button() {
    echo do_shortcode('[opaljob_favorite_button job_id='.get_the_ID() .']');
}
/////////////////////////////////// Employer ////////////////
function opaljob_single_employer_content_sections_summary() {
     opaljob_render_template( 'single-employer/parts/summary' );
}

function opaljob_single_employer_content_sections_content() {
     opaljob_render_template( 'single-employer/parts/content' );
}
function opaljob_single_employer_content_sections_map() {
     opaljob_render_template( 'single-employer/parts/map' );
}

function opaljob_single_employer_content_sections_gallery() {
     opaljob_render_template( 'single-employer/parts/gallery' );
}
function opaljob_single_employer_content_sections_video() {
     opaljob_render_template( 'single-employer/parts/video' );
}
function opaljob_single_employer_content_sections_jobs() {
    opaljob_render_template( 'single-employer/parts/jobs-listing' );
}

function opaljob_single_employer_content_section_navbar () {
    opaljob_render_template( 'single-employer/parts/navbar' );
}

?>
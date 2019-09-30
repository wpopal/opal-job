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

/**
 * The args to pass to the give_get_collection() query
 *
 * @since  1.0
 * @access public
 *
 * @var    array
 */
function opaljob_get_search_keyword_suggestion () {
    
}

/**
 * The args to pass to the give_get_collection() query
 *
 * @since  1.0
 * @access public
 *
 * @var    array
 */
function opaljob_get_search_job_form() {
    opaljob_render_template( 'search-form/vertical-job' );
}


/**
 * The args to pass to the give_get_collection() query
 *
 * @since  1.0
 * @access public
 *
 * @var    array
 */
function opaljob_select_specialisms_field ( $selected='' ) {
    $id   = 'opaljob_specialism' . rand();

    $args = [
        'show_option_none' => esc_html__( 'Specialisms', 'opaljob' ),
        'id'               => $id,
        'class'            => 'form-control',
        'name'             => 'specialisms',
        'show_count'       => 0,
        'hierarchical'     => '',
        'selected'         => $selected,
        'value_field'      => 'slug',
        'taxonomy'         => 'opaljob_specialism',
        'orderby'          => 'name',
        'order'            => 'ASC',
        'echo'             => 0,
    ];

    $label = '<label class="opaljob-label opaljob-label--types" for="' . esc_attr( $id ) . '">' 
        . esc_html__( 'Specialisms', 'opaljob' ) . '</label>';

    echo $label . wp_dropdown_categories( $args );
}

/**
 * The args to pass to the give_get_collection() query
 *
 * @since  1.0
 * @access public
 *
 * @var    array
 */
function opaljob_select_types_field ( $selected='' ) {

    $id   = 'opaljob_types' . rand();

    $args = [
        'show_option_none' => esc_html__( 'Categories', 'opaljob' ),
        'id'               => $id,
        'class'            => 'form-control',
        'name'             => 'types',
        'show_count'       => 0,
        'hierarchical'     => '',
        'selected'         => $selected,
        'value_field'      => 'slug',
        'taxonomy'         => 'opaljob_types',
        'orderby'          => 'name',
        'order'            => 'ASC',
        'echo'             => 0,
    ];

    $label = '<label class="opaljob-label opaljob-label--types" for="' 
        . esc_attr( $id ) . '">' . esc_html__( 'Types', 'opaljob' ) . '</label>';

    echo $label . wp_dropdown_categories( $args );
}
/**
 * The args to pass to the give_get_collection() query
 *
 * @since  1.0
 * @access public
 *
 * @var    array
 */
function opaljob_select_category_field ( $selected='' ) {

    $id   = 'opaljob_location' . rand();

    $args = [
        'show_option_none' => esc_html__( 'Categories', 'opaljob' ),
        'id'               => $id,
        'class'            => 'form-control',
        'name'             => 'categories',
        'show_count'       => 0,
        'hierarchical'     => '',
        'selected'         => $selected,
        'value_field'      => 'slug',
        'taxonomy'         => 'opaljob_category',
        'orderby'          => 'name',
        'order'            => 'ASC',
        'echo'             => 0,
    ];

    $label = '<label class="opaljob-label opaljob-label--location" for="' . esc_attr( $id ) . '">' . esc_html__( 'Categories', 'opaljob' ) . '</label>';

    echo $label . wp_dropdown_categories( $args );
}

/**
 * The args to pass to the give_get_collection() query
 *
 * @since  1.0
 * @access public
 *
 * @var    array
 */
function opaljob_select_location_field ( $selected='' ) {

    $id   = 'opaljob_location' . rand();

    $args = [
        'show_option_none' => esc_html__( 'Location', 'opaljob' ),
        'id'               => $id,
        'class'            => 'form-control',
        'name'             => 'location',
        'show_count'       => 0,
        'hierarchical'     => '',
        'selected'         => $selected,
        'value_field'      => 'slug',
        'taxonomy'         => 'opaljob_location',
        'orderby'          => 'name',
        'order'            => 'ASC',
        'echo'             => 0,
    ];

    $label = '<label class="opaljob-label opaljob-label--location" for="' . esc_attr( $id ) . '">' . esc_html__( 'Location', 'opaljob' ) . '</label>';

    echo $label . wp_dropdown_categories( $args );
}

/**
 * The args to pass to the give_get_collection() query
 *
 * @since  1.0
 * @access public
 *
 * @var    array
 */
function opaljob_display_member_social_icons () {
    global $member; 
    $socials = array(
        'facebook'  => $member->get_meta( 'facebook' ),
        'twitter'   => $member->get_meta( 'twitter' ),
        'pinterest' => $member->get_meta( 'pinterest' ),
        'google'    => $member->get_meta( 'google' ),
        'instagram' => $member->get_meta( 'instagram' ),
        'linkedIn'  => $member->get_meta( 'linkedIn' )
    );    
    opaljob_render_template( 'common/social-icons', $socials );
}

if ( ! function_exists( "opaljob_login_register_form_popup" ) ) {
    function opaljob_login_register_form_popup() {  
        opaljob_render_template( 'user/my-account-popup' );
    }
}

/**
 * The args to pass to the give_get_collection() query
 *
 * @since  1.0
 * @access public
 *
 * @var    array
 */
function opaljob_apply_form_popup() {
    
}

/**
 * The args to pass to the give_get_collection() query
 *
 * @since  1.0
 * @access public
 *
 * @var    array
 */
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

/**
 * The args to pass to the give_get_collection() query
 *
 * @since  1.0
 * @access public
 *
 * @var    array
 */
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

/**
 * The args to pass to the give_get_collection() query
 *
 * @since  1.0
 * @access public
 *
 * @var    array
 */
function opaljob_single_candidate_content_section_navbar () {
    opaljob_render_template( 'single-candidate/parts/navbar' );
}

/**
 * The args to pass to the give_get_collection() query
 *
 * @since  1.0
 * @access public
 *
 * @var    array
 */
function opaljob_single_candidate_content_section_meta () {
    opaljob_render_template( 'single-candidate/parts/meta' );
}

/**
 * The args to pass to the give_get_collection() query
 *
 * @since  1.0
 * @access public
 *
 * @var    array
 */
function opaljob_single_candidate_content_section_content() {
    opaljob_render_template( 'single-candidate/parts/content' );
}

/**
 * The args to pass to the give_get_collection() query
 *
 * @since  1.0
 * @access public
 *
 * @var    array
 */
function opaljob_single_candidate_content_section_summary () {
    opaljob_render_template( 'single-candidate/parts/summary' );
}

/**
 * The args to pass to the give_get_collection() query
 *
 * @since  1.0
 * @access public
 *
 * @var    array
 */
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
        'type'    => 'employer'
    ];
	opaljob_render_template( 'messages/contact-form', $args );
}

/// 
function opaljob_display_employer_summary() {  
    $args = array();
    opaljob_render_template( 'single-job/parts/employer-summary', $args );
}

/********************************************************************************************************************************************************
 *  
 *  SINGLE JOB FUNCTIONS
 *  
 *********************************************************************************************************************************************************/

function opaljob_single_tab_nav () { ?>
<div class="opaljob-job-nav opaljob-tab">
    <div class="job-tab-head">
        <a href="#job-information" class="tab-item"><?php esc_html_e( 'Information', 'opaljob' ); ?></a>
        <a href="#job-employer" class="tab-item"><?php esc_html_e( 'Employer', 'opaljob' ); ?></a>
        <a href="#job-listing" class="tab-item"><?php esc_html_e( 'Jobs From This Employer', 'opaljob' ); ?></a>
    </div>
        
<?php }

function opaljob_single_job_tab_contents () {
    add_action( "opaljob_single_job_content_before", function(){
        echo '<div class="opaljob-tab-wrap"><div class="opaljob-tab-content" id="job-information">'; 
    } , 11 );
    add_action( "opaljob_single_job_content_after", function(){
        echo '</div>'; 
    } , 15 );

    add_action( "opaljob_single_job_content_after", function(){
        echo '</div></div>'; 
    } , 99 );
}

function opaljob_single_job_employer_info () { ?>
    <div class="opaljob-tab-content" id="job-employer">
        <?php  opaljob_render_template( 'single-job/parts/job-employer' ); ?>
    </div>    
<?php }

function opaljob_single_job_listing () { ?>
    <div class="opaljob-tab-content" id="job-listing">
        <?php  opaljob_render_template( 'single-job/parts/job-listing' ); ?>
    </div>    
<?php }


function opaljob_single_job_content_sections_content() {
     opaljob_render_template( 'single-job/parts/job-content' );
}


function opaljob_single_job_meta_list () {
    global $job; 
    
    $metas = array();

    $metas[]  = array(
        'icon'    => 'fa fa-gear',
        'label'   => esc_html__( 'Offerd Salary', 'opaljob' ),
        'content' => '400$ - 990$'
    );

    $metas =  apply_filters( 'opaljob_single_meta_list', $metas )  ; 

    opaljob_render_template( 'single-job/parts/meta', array( 'metas' => $metas ) );
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
    opaljob_render_template( 'single-job/parts/job-summary' );
}


function opaljob_single_job_content_sections_job_tags() {
    opaljob_render_template( 'single-job/parts/job-tags' );
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
function opaljob_single_employer_content_sections_jobs_listing() {
    opaljob_render_template( 'single-employer/parts/jobs-listing' );
}

function opaljob_single_employer_content_section_navbar () {
    opaljob_render_template( 'single-employer/parts/navbar' );
}

function opaljob_single_employer_meta_list () {
    
    $metas = array();
    $metas =  apply_filters( 'opaljob_single_employer_meta_list', $metas )  ; 

    opaljob_render_template( 'single-employer/parts/meta', array( 'metas' => $metas ) );
}

function opaljob_render_share_socials_block() {
    opaljob_render_template( 'common/share-socials' );
}

///// // MAIN LAYOUT / / /
function opaljob_layout_container () { 
    add_action( 'opaljob_before_main_content', function () {
        echo '<div class="opal-container">';
    } , 4 );

    add_action( 'opaljob_after_main_content', function () {
        echo '</div>';
    }, 4 );
}


function opaljob_favorite_candidate_button ( $user_id, $atts = array() ) {

    $atts['user_id'] = get_current_user_id();   

    if( !isset($atts['member_id']) ){
        $atts['member_id'] = $user_id;
    }

    $items = get_user_meta( $atts['user_id'],  'opaljob_candidate_favorite', true );


    if( is_array($items) && in_array( $atts['member_id'] , $items ) ){
        $atts['existed'] = 1;
    } else {
        $atts['existed'] = 0;
    }
    
    ob_start();
    echo opaljob_render_template( 'common/member/favorite-candidate-button' , $atts );
    $ouput = ob_get_contents();
    ob_end_clean();

    return $ouput;
}
?>
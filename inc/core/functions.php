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

function opaljob_get_job_statuses() {
	return apply_filters( "opaljob_get_job_statuses", array(
		'pending-payment' => esc_html__( 'Pending Payment', 'opaljob' ),
		'unpublish'	 	  => esc_html__( 'Un-Publish', 'opaljob' ),
		'expired'	 	  => esc_html__( 'Expired', 'opaljob' ),
		'rejected'	 	  => esc_html__( 'Rejected', 'opaljob' )
	) );
}
/**
 * Fired during plugin deactivation
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @link       http://wpopal.com
 * @since      1.0.0
 *
 * @author     WpOpal
 **/

function opaljob_output_msg_json( $result = false, $message = '', $args = array(), $return = false ){
	
	$out = new stdClass();
	$out->status = $result;
	$out->message = $message;
	if( $args ){
		foreach( $args as $key => $arg ){
			$out->$key = $arg;
		}
	}
	if( $return ){
		return json_encode( $out );
	} else {
		echo json_encode( $out ); die;
	}
}


/**
 * Fired during plugin deactivation
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @link       http://wpopal.com
 * @since      1.0.0
 *
 * @author     WpOpal
 **/

function is_single_job() {
	global $post;
	$post_type = get_post_type();

	return $post_type == 'opaljob_job' && is_single();
}

/**
 * Get Options Value by Key
 *
 *	Display Sidebar on left side and next is main content 
 *
 * @since 1.0
 *
 * @return string
 */
function opaljob_options( $key , $default='' ) {
	global $opaljob_options;

	$value = isset( $opaljob_options[ $key ] ) ? $opaljob_options[ $key ] : $default;
	$value = apply_filters( 'opaljob_option_', $value, $key, $default );

	return apply_filters( 'opaljob_option_' . $key, $value, $key, $default );
}

/**
 * Render Sidebar
 *
 *	Display Sidebar on left side and next is main content 
 *
 * @since 1.0
 *
 * @return string
 */
function opaljob_render_template( $template, $args=array() ){
	echo Opal_Job\Core\View::render_template( $template, $args );
}

/**
 * Render Sidebar
 *
 *	Display Sidebar on left side and next is main content 
 *
 * @since 1.0
 *
 * @return string
 */
function opaljob_new_statistic_object() {
	return \Opal_Job\Common\Model\Statistic::get_instance(); 
}


/**
 * Render Sidebar
 *
 *	Display Sidebar on left side and next is main content 
 *
 * @since 1.0
 *
 * @return string
 */
function opaljob_new_employer_object( $id ) {
	return new \Opal_Job\Common\Model\Entity\Employer_Entity(  $id ); 
}

/**
 * Render Sidebar
 *
 *	Display Sidebar on left side and next is main content 
 *
 * @since 1.0
 *
 * @return string
 */
function opaljob_new_job_object( $id ) {
	return new \Opal_Job\Common\Model\Entity\Job_Entity(  $id ); 
}


function opaljob_new_user_object( $id ) { 
	return new \Opal_Job\Common\Model\Entity\User_Entity(  $id );   	
}

/**
 * Render Sidebar
 *
 *	Display Sidebar on left side and next is main content 
 *
 * @since 1.0
 *
 * @return string
 */
function opaljob_new_candidate_object( $id ) {
	return new \Opal_Job\Common\Model\Entity\Candicate_Entity(  $id ); 
}

function opaljob_get_user_model(){
	return \Opal_Job\Common\Model\User::get_instance();
}

/**
 * Render Sidebar
 *
 *	Display Sidebar on left side and next is main content 
 *
 * @since 1.0
 *
 * @return string
 */
function opaljob_get_register_page_uri() {
}

function opaljob_has_role ( $role , $user_id=null){ 
	if( function_exists("wp_get_current_user") ) {  
		$user = $user_id ? get_user_by( 'ID', $user_id ) : wp_get_current_user(); 
		if ( in_array(  'opaljob_'.$role, (array) $user->roles ) ) {
		   return true;
		}
	}
	return false;
}
/**
 * Render Sidebar
 *
 *	Display Sidebar on left side and next is main content 
 *
 * @since 1.0
 *
 * @return string
 */
if ( ! function_exists( 'opaljob_add_notice' ) ) {
	function opaljob_add_notice( $type = 'error', $message = '' ) { 
		return; 
		if ( ! $type || ! $message ) {
			return;
		}
		$notices = OpalEstate()->session->get( 'notices', [] );
		if ( ! isset( $notices[ $type ] ) ) {
			$notices[ $type ] = [];
		}
		$notices[ $type ][] = $message;
		OpalEstate()->session->set( 'notices', $notices );
	}
}

/**
 * print all notices
 *
 *	Display Sidebar on left side and next is main content 
 *
 * @since 1.0
 *
 * @return string
 */
if ( ! function_exists( 'opaljob_print_notices' ) ) {
	function opaljob_print_notices() {

		return ;
		$notices = OpalEstate()->session->get( 'notices', [] );
		if ( empty( $notices ) ) {
			return;
		}
		ob_start();
		foreach ( $notices as $type => $messages ) {
			echo opaljob_load_template_path( 'notices/' . $type, [ 'messages' => $messages ] );
		}
		OpalEstate()->session->set( 'notices', [] );
		echo ob_get_clean();
	}
}

function opaljob_user_can_submit_job() {
	return opaljob_get_user_model()->can_submit_job( );
}

function opaljob_user_can_edit_job( $job_id ) {

	return opaljob_get_user_model()->can_edit_job( $job_id );
}

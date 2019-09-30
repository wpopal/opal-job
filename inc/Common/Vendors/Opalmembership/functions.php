<?php
/**
 * $Desc$
 *
 * @version    $Id$
 * @package    opaljob
 * @author     Opal  Team <info@wpopal.com >
 * @copyright  Copyright (C) 2019 wpopal.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.wpopal.com
 * @support  http://www.wpopal.com/support/forum.html
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


/**
 * Render Sidebar
 *
 *  Display Sidebar on left side and next is main content 
 *
 * @since 1.0
 *
 * @return string
 */ 
function opaljob_get_user_current_listings( $user_id ){
	$args = array(
        'post_type'   => 'opaljob_job',
        'post_status' => array( 'pending', 'publish' ),
        'author'      => $user_id,

    );
    $posts = new WP_Query( $args );
    return $posts->found_posts;
    wp_reset_postdata();
}

/**
 * Count Number of featured listing following user
 */
function opaljob_get_user_current_featured_listings( $user_id ){

	$args = array(
        'post_type'     =>  'opaljob_job',
        'post_status'   =>  array( 'pending', 'publish' ),
        'author'        =>  $user_id,
        'meta_query'    =>  array(
            array(
                'key'   => OPALMEMBERSHIP_USER_PREFIX_.'featured',
                'value' => 1,
                'meta_compare '=>'='
            )
        )
    );
    $posts = new WP_Query( $args );
    return $posts->found_posts;
    wp_reset_postdata();
}

/**
 * Check current package is downgrade package or not via current number of featured, listing lesser
 */
function opaljob_check_package_downgrade_status( $user_id, $package_id ){

	$pack_listings            =   get_post_meta( $package_id, OPALMEMBERSHIP_USER_PREFIX_.'package_listings', true );
	$pack_featured_listings   =   get_post_meta( $package_id, OPALMEMBERSHIP_USER_PREFIX_.'package_featured_listings', true );
	$is_unlimited             =   get_post_meta( $package_id, OPALMEMBERSHIP_USER_PREFIX_.'unlimited_listings', true );
    $pack_unlimited_listings  =   $is_unlimited == 'on' ? 0 : 1;

    $user_current_listings          = opaljob_get_user_current_listings( $user_id );
    $user_current_featured_listings = opaljob_get_user_current_featured_listings( $user_id );

    $current_listings               =  get_user_meta( $user_id, OPALMEMBERSHIP_USER_PREFIX_.'package_listings',true);

    if( $pack_unlimited_listings == 1 ) {
        return false;
    }

    // if is unlimited and go to non unlimited pack
    if ( $current_listings == -1 && $pack_unlimited_listings != 1 ) {
        return true;
    }

    return ( $user_current_listings > $pack_listings ) || ( $user_current_featured_listings > $pack_featured_listings ) ;
}

/**
 * Check Current User having permission to add new job or not?
 */
function opaljob_check_has_add_listing( $user_id, $package_id=null ){

    if( !$package_id ){
        $package_id = (int)get_user_meta( $user_id, OPALMEMBERSHIP_USER_PREFIX_.'package_id', true );
    }

    $package_listings            = (int) get_user_meta( $user_id, OPALMEMBERSHIP_USER_PREFIX_.'package_listings', true );
    $unlimited_listings          = get_post_meta( $package_id, OPALMEMBERSHIP_USER_PREFIX_.'unlimited_listings', true );
    $unlimited_listings          = !empty( $unlimited_listings ) && $unlimited_listings == 'on' ? 0 : 1;

    if( $package_id > 0 && $unlimited_listings ){ 
        return true; 
    }

    if( $package_listings  > 0 ){
        return true; 
    }
    return false;
}

/**
 * Check current package is downgrade package or not via current number of featured, listing lesser
 */
function opaljob_get_user_featured_remaining_listing( $user_id ){

    $count = get_the_author_meta( OPALMEMBERSHIP_USER_PREFIX_.'package_featured_listings' , $user_id );

    return $count;
}

/**


function opaljob_reset_user_free_package( $user_id ){ 
 
    $duration = opaljob_options('free_expired_month', 12);
    update_user_meta( $user_id, OPALMEMBERSHIP_USER_PREFIX_.'package_id', -1 );  
    update_user_meta( $user_id, OPALMEMBERSHIP_USER_PREFIX_.'package_listings', opaljob_options('free_number_listing', 3) );
    update_user_meta( $user_id, OPALMEMBERSHIP_USER_PREFIX_.'package_featured_listings', opaljob_options('free_number_featured', 3) );

    update_user_meta( $user_id, OPALMEMBERSHIP_USER_PREFIX_.'package_activation', time() );
    update_user_meta( $user_id, OPALMEMBERSHIP_USER_PREFIX_.'package_expired', time() +  ($duration*60*60*24*30)  );
 
    return true; 
}

/**
 * Update remaining featured listings
 */
function opaljob_update_package_number_featured_listings( $user_id ) {

    $current = get_the_author_meta( OPALMEMBERSHIP_USER_PREFIX_.'package_featured_listings' , $user_id );

    if( $current-1 >= 0 ) {
        update_user_meta( $user_id, OPALMEMBERSHIP_USER_PREFIX_.'package_featured_listings', $current-1 ) ;
    } else {
        update_user_meta( $user_id, OPALMEMBERSHIP_USER_PREFIX_.'package_featured_listings', 0 );
    }
}

/**
 * Update remaining featured listings
 */
function opaljob_update_package_number_listings( $user_id ) {

    $current = get_user_meta(  $user_id, OPALMEMBERSHIP_USER_PREFIX_.'package_listings', true );
   
    if( $current-1 >= 0 ) {
        update_user_meta( $user_id, OPALMEMBERSHIP_USER_PREFIX_.'package_listings', $current-1 ) ;
    } else {
        update_user_meta( $user_id, OPALMEMBERSHIP_USER_PREFIX_.'package_listings', 0 );
    }
}


/**
 * Render Sidebar
 *
 *  Display Sidebar on left side and next is main content 
 *
 * @since 1.0
 *
 * @return string
 */ 
function opaljob_is_membership_valid( $user_id = null ){
  //   $package_id = (int)get_user_meta( $user_id, OPALMEMBERSHIP_USER_PREFIX_.'package_id', true );
   return Opalmembership_User::is_membership_valid( $user_id );
}
 
    
/**
 * Render Sidebar
 *
 *  Display Sidebar on left side and next is main content 
 *
 * @since 1.0
 *
 * @return string
 */ 
function opaljob_listing_set_to_expire( $post_id ){

    $prop = array(

        'ID'            => $post_id,
        'post_type'     => 'opaljob_job',
        'post_status'   => 'expired'
    
    );

    wp_update_post($prop );

    $post = get_post( $post_id );
    $user_id = $post->post_author;

    $user       =   get_user_by('id', $user_id);
    $user_email =   $user->user_email;

    $args = array(
        'expired_listing_url'  => get_permalink($post_id),
        'expired_listing_name' => get_the_title($post_id)
    );
    
   //  opaljob_email_type( $user_email, 'listing_expired', $args );
}
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
namespace Opal_Job\Common\Model;

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
class Message { 

	/**
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function get_equiry_form_fields( $msg='' ) {  

		$prefix = '';

		$id 		  = '';
		$sender_id 	  = '';
		$post_id  = get_the_ID();
		$email 		  = '';
		$current_user = wp_get_current_user();
		$name = '';

		if ( 0 != $current_user->ID ) { 
			$email = $current_user->user_email;
			$name = $current_user->user_firstname .' ' . $current_user->user_lastname; 
			$sender_id 	  = $current_user->ID;
		}

		$fields =  array(

			array(
				'id'   		   => "type",
				'name' 		   => esc_html__( 'Type', 'opaljob' ),
				'type' 		   => 'hidden',		
				'default'	   => 'send_equiry',		 
				'description'  => "",
			),
			array(
				'id'   		   => "post_id",
				'name' 		   => esc_html__( 'Property ID', 'opaljob' ),
				'type' 		   => 'hidden',		
				'default'	   => $post_id,		 
				'description'  => "",
			),

			array(
				'id'   		   => "sender_id",
				'name' 		   => esc_html__( 'Sender ID', 'opaljob' ),
				'type' 		   => 'hidden',		
				'default'	   => $sender_id,		 
				'description'  => "",
			),

			array(
				'id'   		   => "{$prefix}name",
				'name' 		   => esc_html__( 'Name', 'opaljob' ),
				'type' 		   => 'text',
				'before_row'   =>  '',
				'required' 	   => 'required',
				'default'	   => $name,
				'description'  => "",
			),
			array(
				'id'   => "{$prefix}email",
				'name' => esc_html__( 'Email', 'opaljob' ),
				'type' => 'text',
				'default'	=> $email,
				'description'  => "",
				'required' => 'required',
			),

			array(
				'id'  		   => "{$prefix}phone",
				'name' 		   => esc_html__( 'Phone', 'opaljob' ),
				'type' 		   => 'text',
				'description'  => "",
				'required' 	   => 'required',
			),

			array(
				'id'   => "{$prefix}message",
				'name' => esc_html__( 'Message', 'opaljob' ),
				'type' => 'textarea',
				'description'  => "",
				'default'	=> $msg,
				'required' => 'required',
			),

		);

		return $fields;
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
	public function get_contact_form_fields () {

		$author 	  = get_queried_object();
    	$receiver_id  = $author->ID;

		$prefix 	  = '';
		$id 		  = '';
		$sender_id 	  = '';
		$author_id 	  = get_the_ID();
		$email 		  = '';
		$current_user = wp_get_current_user();
		$name 		  = '';
		$msg 		  = '';
		
		if ( 0 != $current_user->ID ) { 
			$email = $current_user->user_email;
			$name = $current_user->user_firstname .' ' . $current_user->user_lastname; 
			$sender_id 	  = $current_user->ID;
		}	

		$fields =  array(
			array(
				'id'   		   => "type",
			//	'name' 		   => esc_html__( 'Type', 'opaljob' ),
				'type' 		   => 'hidden',		
				'default'	   => 'send_contact',		 
				'description'  => "",
			),
			array(
				'id'   		   => "receiver_id",
		//		'name' 		   => esc_html__( 'Receiver ID', 'opaljob' ),
				'type' 		   => 'hidden',		
				'default'	   => $receiver_id,		 
				'description'  => "",
			),
			array(
				'id'   		   => "sender_id",
				'name' 		   => esc_html__( 'Sender ID', 'opaljob' ),
				'type' 		   => 'hidden',		
				'default'	   => $sender_id,		 
				'description'  => "",
			),
			array(
				'id'   		   => "{$prefix}name",
				'name' 		   => esc_html__( 'Name', 'opaljob' ),
				'type' 		   => 'text',
				'default'	   => $name,		 
				'required' 	   => 'required',
				'description'  => "",
			),
			array(
				'id'   => "{$prefix}email",
				'name' => esc_html__( 'Email', 'opaljob' ),
				'type' => 'text',
				'default'	   => $email,		 
				'description'  => "",
				'required' => 'required',
			),

			array(
				'id'  		   => "{$prefix}phone",
				'name' 		   => esc_html__( 'Phone', 'opaljob' ),
				'type' 		   => 'text',
				'description'  => "",
				'required' 	   => 'required',
			),

			array(
				'id'   		   => "{$prefix}message",
				'name' 		   => esc_html__( 'Message', 'opaljob' ),
				'type' 		   => 'textarea',
				'description'  => "",
				'default'	   => $msg,
				'required' 	   => 'required',
			),

		);

		return $fields;
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
	public function get_reply_form_fields () {
		$prefix = '';
		$fields =  array(
			array(
				'id'   		   => "type",
				'name' 		   => esc_html__( 'Type', 'opaljob' ),
				'type' 		   => 'hidden',		
				'default'	   => 'send_contact',		 
				'description'  => "",
			),
			array(
				'id'   => "{$prefix}message",
				'name' => esc_html__( 'Message', 'opaljob' ),
				'type' => 'textarea',
				'description'  => "",
				'required' => 'required',
			)
		);
		return $fields;
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
	public function insert( $data ){

		global $wpdb;

		$args = array(
            'subject' 	   => '' ,
            'message'  	   => '' ,
            'sender_email' => '', 
            'phone' 	   => '',
            'sender_id'    => '',
            'created' 	   => current_time('mysql', 1),
            'receiver_id'  => '',
            'post_id'	   => '',
            'type'	  	   => '',
        );
        
        foreach( $args as $key => $value ) {
        	if( isset($data[$key]) ){
        		$args[$key] = $data[$key];
        	}
        }
        
        $id = $wpdb->insert( $wpdb->prefix.'opaljob_message', $args );

        return $wpdb->insert_id; 
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
	public function insert_reply( $data ){
		
		global $wpdb;

		$args = array(
			'message_id'  => '',
            'message'  	   => '' ,
            'sender_id'    => '',
            'created' 	   => current_time('mysql', 1),
            'receiver_id'  => '',
        );
        
        foreach( $args as $key => $value ) {
        	if( isset($data[$key]) ){
        		$args[$key] = $data[$key];
        	}
        }
        
        $id = $wpdb->insert( $wpdb->prefix.'opaljob_message_reply', $args );

        return $wpdb->insert_id;
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
	public function get_reply( $id ) {
		global $wpdb;
 		
        $query = " SELECT * FROM ".$wpdb->prefix."opaljob_message_reply where id=".(int) $id ;
        $reply = $wpdb->get_row(  $query );

        return $reply;
	}

	public function get_total(){

		global $wpdb;
        $query = " SELECT count(1) as total FROM ".$wpdb->prefix."opaljob_message where receiver_id=".$this->user_id .' OR sender_id='.$this->user_id;
        return $wpdb->get_var(  $query );
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
	public function get_message( $id ){

		global $wpdb;
 		
        $query = " SELECT * FROM ".$wpdb->prefix."opaljob_message where ( sender_id=".$this->user_id." OR receiver_id=".$this->user_id .') and id='.(int) $id  ;
        $message = $wpdb->get_results(  $query );
 
		if( isset($message[0]) ) {
			return $message[0];
		}
		
		return array();
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
	public function get_replies ( $id ) {
		
		global $wpdb;
 		
        $query = " SELECT * FROM ".$wpdb->prefix."opaljob_message_reply where message_id=".(int) $id .' ORDER BY created ' ;
        $messages = $wpdb->get_results(  $query );

        return $messages;
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
	public function get_list( $args=array() ){

		global $wpdb;

		$default = array(
			'cpage' =>  1,
			'items_per_page' => 3
		);

		$args = array_merge( $default, $args ); 
		$items_per_page = $args['items_per_page'];
		$offset = ( $args['cpage'] * $items_per_page ) - $items_per_page;

        $query = " SELECT * FROM ".$wpdb->prefix."opaljob_message where receiver_id=".$this->user_id .' OR sender_id='.$this->user_id;
        $query .= ' ORDER BY id DESC LIMIT '. $offset.', '. $items_per_page ;

        return $wpdb->get_results(  $query );
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
	public static function install(){
	    try {
	        if ( ! function_exists('dbDelta') ) {
	            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	        }

	        global $wpdb;

	        $charset_collate = $wpdb->get_charset_collate();

	        $sql = 'CREATE TABLE IF NOT EXISTS ' . $wpdb->prefix . 'opaljob_message' . ' (
									  `id` int(11) UNSIGNED NOT NULL,
									  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
									  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
									  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
									  `sender_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
									  `sender_id` int(11) DEFAULT NULL,
									  `created` datetime NOT NULL,
									  `receiver_id` int(11) NOT NULL,
									  `post_id` int(11) NOT NULL,
									  `type` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
									  `isread` tinyint(1) NOT NULL
					) ' . $charset_collate;
	        dbDelta( $sql );

	        ///

	         $sql = 'CREATE TABLE IF NOT EXISTS ' . $wpdb->prefix . 'opaljob_message_reply' . ' (
									      `id` int(11) NOT NULL,
										  `message_id` int(11) NOT NULL,
										  `sender_id` int(11) NOT NULL,
										  `message` text NOT NULL,
										  `created` datetime NOT NULL,
										  `receiver_id` int(11) NOT NULL
					) ' . $charset_collate;
	        dbDelta( $sql );


	    }catch ( Exception $e ) {
	    
	    }
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
	public function do_delete( $id ){
		
		global $wpdb;
		if(  $this->user_id ){
			$wpdb->delete( $wpdb->prefix."opaljob_message", array("id" => $id ,'user_id' => $this->user_id ), array( '%d' ) ) ;
		}
	}

	
}
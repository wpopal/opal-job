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
namespace Opal_Job\Common\Model\Entity;

use WP_Post;
use Opal_Job\Core\URI; 
use Opal_Job\Common\Model\Entity\User_Entity;

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
class Employer_Entity extends User_Entity{
	
	/**
	 * Render Sidebar
	 *
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function get_company(){
		return $this->get_meta( 'company' );
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
	public function get_gallery() {
		$gallery = $this->get_meta( 'gallery' );
		return $gallery;
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
	public function get_count_followers() {
		$count = $this->get_meta( 'count_followers' );
		return ( $count > 0 ? $count : 0 );
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
	public function update_count_followers( $status ){

		$count = $this->get_count_followers(); 
		if( $status == true ){
			$count = $count+1; 
		} else {
			$count = ( $count > 0 ? $count-1 : 0 );
		}

		update_user_meta( $this->ID, OPAL_JOB_METABOX_PREFIX.'count_followers', $count );
	}
}
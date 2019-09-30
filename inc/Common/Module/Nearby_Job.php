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
namespace Opal_Job\Common\Module;

/**
 * Taxonomies Class
 *
 *  This Class Register all needed taxonomies for project.
 *
 * @link       http://wpopal.com
 * @since      1.0.0
 *
 * @author     WpOpal
 **/
class Nearby_Job {

	public function get_name () {
		return esc_html__( 'Related Jobs', 'opaljob' );
	}

	public function get_key () {
		return 'related_job'
	}
	
	public function get_settings () {

	}

	public function render () {
		
	}
}
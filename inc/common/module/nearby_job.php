<?php

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
class Related_Job {

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
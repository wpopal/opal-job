<?php

namespace Opal_Job\Common\Model;

use Opal_Job\Common\Model\Query\Job_Query; 
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
class Job { 
	
	public $data ; 
	public function get_list_by_employer( $id ) {
		
		$query = new Job_Query(
			array(
				'post_type' => 'opaljob_job',
				'post_author' => $id
			)
		); 
		$query->post_author = $id;
		
		return $query->get_list();
	}

	public function save ( $data ) {
		
		$default = array(
			'post_type' => 'opaljob_job'
		);	

		$data = array_merge( $default, $data );
	
		$post_id = wp_insert_post( $data, true );
	
		return $post_id; 
	}

	public function process_upload_files () {

	}
}
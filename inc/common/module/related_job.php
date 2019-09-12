<?php

namespace Opal_Job\Common\Module;

use  Opal_Job\Common\Model\Query\Job_Query;
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
class Related_Job {

 	/**
	 * Render Sidebar
	 *
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function get_data() {

		$num  = 6;
		$args = [
			'post_type'      => 'opaljob_job',
			'posts_per_page' => $num,
			'post__not_in'   => [ get_the_ID() ],
		];

		$terms = wp_get_post_terms( get_the_ID(), 'opaljob_types' );

		$tax_query = [];
		if ( $terms ) {
			$tax_query[] = [
				[
					'taxonomy' => 'opaljob_types',
					'field'    => 'slug',
					'terms'    => $terms[0]->slug,
				],
			];
		}

		$status = wp_get_post_terms( get_the_ID(), 'opaljob_status' );
		if ( ! is_wp_error( $status ) && $status ) {
			$tax_query[] =
				[
					'taxonomy' => 'opaljob_status',
					'field'    => 'slug',
					'terms'    => $status[0]->slug,

				];
		}


		if ( $tax_query ) {
			$args['tax_query'] = [ 'relation' => 'AND' ];
			$args['tax_query'] = array_merge( $args['tax_query'], $tax_query );
		}

		$query = Job_Query::get_job_query( $args );

		$args = [
			'query'  => $query,
			'column' => 3,
			'style'  => '',
		];

		return $args;
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
	public function render () {

		$data = $this->get_data();
		opaljob_render_template( 'common/module/related_job', $data );
	}
}
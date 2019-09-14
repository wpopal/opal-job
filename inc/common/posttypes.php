<?php

namespace Opal_Job\Common;

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
class Posttypes {

	/**
	 * Register all post types using for this project
	 *
	 * @since    1.0.0
	 */
	public function definition() {
		
		if ( ! is_blog_installed() || post_type_exists( 'opaljob_job' ) ) {
			return;
		}

		$this->register_job(); 
		$this->register_post_status();

		foreach ( array( 'post', 'post-new' ) as $hook ) {
			add_action( "admin_footer-{$hook}.php", [$this, 'register_post_status_script'] );
		}
	}

	public function register_post_status_script() {  
		global $post, $post_type;
		if ( $post_type === 'opaljob_job' ) {
			$html = $selected_label = '';
			foreach (  opaljob_get_job_statuses() as $status => $label ) {
				$seleced = selected( $post->post_status, esc_attr( $status ), false );
				if ( $seleced ) {
					$selected_label = $label;
				}
				$html .= "<option " . $seleced . " value='" . esc_attr( $status ) . "'>" . $label . "</option>";
			}
			?>
            <script type="text/javascript">
                jQuery(document).ready(function ($) {
					<?php if ( ! empty( $selected_label ) ) : ?>
                    jQuery('#post-status-display').html('<?php echo esc_js( $selected_label ); ?>');
					<?php endif; ?>
                    var select = jQuery('#post-status-select').find('select');
                    jQuery(select).html("<?php echo( $html ); ?>");
                });
            </script>
			<?php
		}
 
	}	
	

	/**
	 * Register the Employer Post Type
	 *
	 * @since    1.0.0
	 */
	public function register_post_status(){
		register_post_status( 'unpublish', array(
			'label'                     => _x( 'UnPublish', 'post' ),
			'public'                    => true,
			'exclude_from_search'       => false,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'post_type'                 => array( 'opaljob_job'  ),
			'label_count'               => _n_noop( 'Expired <span class="count">(%s)</span>', 'Expired <span class="count">(%s)</span>' ),
		) );
		register_post_status( 'expired', array(
			'label'                     => _x( 'Expired', 'post' ),
			'public'                    => true,
			'exclude_from_search'       => false,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'post_type'                 => array( 'opaljob_job'  ),
			'label_count'               => _n_noop( 'Expired <span class="count">(%s)</span>', 'Expired <span class="count">(%s)</span>' ),
		) );
		register_post_status( 'pending-payment', array(
			'label'                     => _x( 'Pending Payment', 'post' ),
			'public'                    => true,
			'exclude_from_search'       => false,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'post_type'                 => array( 'opaljob_job'  ),
			'label_count'               => _n_noop( 'Expired <span class="count">(%s)</span>', 'Expired <span class="count">(%s)</span>' ),
		) );
	}

	/**
	 * Register the Employer Post Type
	 *
	 * @since    1.0.0
	 */
	private function register_job() {
		$labels = [
			'name'               => esc_html__( 'Jobs', 'opaljob' ),
			'singular_name'      => esc_html__( 'Job', 'opaljob' ),
			'add_new'            => esc_html__( 'Add New Job', 'opaljob' ),
			'add_new_item'       => esc_html__( 'Add New Job', 'opaljob' ),
			'edit_item'          => esc_html__( 'Edit Job', 'opaljob' ),
			'new_item'           => esc_html__( 'New Job', 'opaljob' ),
			'all_items'          => esc_html__( 'All Jobs', 'opaljob' ),
			'view_item'          => esc_html__( 'View Job', 'opaljob' ),
			'search_items'       => esc_html__( 'Search Job', 'opaljob' ),
			'not_found'          => esc_html__( 'No Jobs found', 'opaljob' ),
			'not_found_in_trash' => esc_html__( 'No Jobs found in Trash', 'opaljob' ),
			'parent_item_colon'  => '',
			'menu_name'          => esc_html__( 'Jobs', 'opaljob' ),
		];

		$labels = apply_filters( 'opaljob_postype_job_labels', $labels );

		register_post_type( 'opaljob_job',
			apply_filters( 'opaljob_job_post_type_parameters', [
				'labels'              => $labels,
				'supports'            => [ 'title', 'editor', 'thumbnail', 'comments', 'author' ],
				'public'              => true,
				'has_archive'         => true,
				'menu_position'       => 51,
				'categories'          => [],
				'menu_icon'           => 'dashicons-admin-home',
				'map_meta_cap'        => true,
				'publicly_queryable'  => true,
				'exclude_from_search' => false,
				'query_var'           => true,
				'hierarchical'        => false, // Hierarchical causes memory issues - WP loads all records!
				'show_in_nav_menus'   => true,
				'rewrite'             => [ 'slug' => esc_html_x( 'job', 'job slug', 'opaljob' ) ],
			] )
		);
	}

	/**
	 * Register the Employer Post Type
	 *
	 * @since    1.0.0
	 */
	private function register_employer() {

		$labels = [
			'name'               => esc_html__( 'Employers', 'opaljob' ),
			'singular_name'      => esc_html__( 'Employer', 'opaljob' ),
			'add_new'            => esc_html__( 'Add New Employer', 'opaljob' ),
			'add_new_item'       => esc_html__( 'Add New Employer', 'opaljob' ),
			'edit_item'          => esc_html__( 'Edit Employer', 'opaljob' ),
			'new_item'           => esc_html__( 'New Employer', 'opaljob' ),
			'all_items'          => esc_html__( 'All Employers', 'opaljob' ),
			'view_item'          => esc_html__( 'View Employer', 'opaljob' ),
			'search_items'       => esc_html__( 'Search Employer', 'opaljob' ),
			'not_found'          => esc_html__( 'No Employers found', 'opaljob' ),
			'not_found_in_trash' => esc_html__( 'No Employers found in Trash', 'opaljob' ),
			'parent_item_colon'  => '',
			'menu_name'          => esc_html__( 'Employers', 'opaljob' ),
		];

		$labels = apply_filters( 'opaljob_postype_employer_labels', $labels );

		register_post_type( 'opaljob_employer',
			apply_filters( 'opaljob_employer_post_type_parameters', [
				'labels'        => $labels,
				'supports'      => [ 'title', 'editor', 'thumbnail', 'comments', 'author', 'excerpt' ],
				'public'        => true,
				'has_archive'   => false,
				'menu_position' => 51,
				'categories'    => [],
				'menu_icon'     => 'dashicons-groups',
				'rewrite'       => [ 'slug' => esc_html_x( 'employer', 'employer slug', 'opaljob' ) ],
			] )
		);
	}

	/**
	 * Register the Candidate Post Type
	 *
	 * @since    1.0.0
	 */
	private function register_candidate() {
		
		$labels = [
			'name'               => esc_html__( 'Candidates', 'opaljob' ),
			'singular_name'      => esc_html__( 'Candidate', 'opaljob' ),
			'add_new'            => esc_html__( 'Add New Candidate', 'opaljob' ),
			'add_new_item'       => esc_html__( 'Add New Candidate', 'opaljob' ),
			'edit_item'          => esc_html__( 'Edit Candidate', 'opaljob' ),
			'new_item'           => esc_html__( 'New Candidate', 'opaljob' ),
			'all_items'          => esc_html__( 'All Candidates', 'opaljob' ),
			'view_item'          => esc_html__( 'View Candidate', 'opaljob' ),
			'search_items'       => esc_html__( 'Search Candidate', 'opaljob' ),
			'not_found'          => esc_html__( 'No Candidates found', 'opaljob' ),
			'not_found_in_trash' => esc_html__( 'No Candidates found in Trash', 'opaljob' ),
			'parent_item_colon'  => '',
			'menu_name'          => esc_html__( 'Candidates', 'opaljob' ),
		];

		$labels = apply_filters( 'opaljob_postype_candidate_labels', $labels );

		register_post_type( 'opaljob_candidate',
			apply_filters( 'opaljob_candidate_post_type_parameters', [
				'labels'        => $labels,
				'supports'      => [ 'title', 'editor', 'thumbnail', 'comments', 'author', 'excerpt' ],
				'public'        => true,
				'has_archive'   => false,
				'menu_position' => 51,
				'categories'    => [],
				'menu_icon'     => 'dashicons-groups',
				'rewrite'       => [ 'slug' => esc_html_x( 'candidate', 'candidate slug', 'opaljob' ) ],
			] )
		);
	}
}

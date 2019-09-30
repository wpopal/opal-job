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
namespace Opal_Job\Common;

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
class Taxonomies {

	/**
	 * Definition
	 *
	 *	Register all Taxonomy related to Job post type as location, category, Specialism, Types
	 *
	 * @since 1.0
	 *
	 * @return avoid
	 */
	public function definition() {
		
		$this->location_taxonomy();
		$this->category_taxonomy();
		$this->types_taxonomy();
		$this->specialism_taxonomy();

		$this->tags_taxonomy();
	}

	/**
	 * Category Taxonomy
	 *
	 *	Register Category Taxonomy related to Job post type.
	 *
	 * @since 1.0
	 *
	 * @return avoid
	 */
	public function category_taxonomy() {

		//// Job By Category //// 
		register_taxonomy( 'opaljob_category', 'opaljob_job', apply_filters( 'opaljob_taxonomy_args_job_category', [
			'labels'       => [
				'name'          => esc_html__( 'Categories', 'opaljob' ),
				'add_new_item'  => esc_html__( 'Add New Category', 'opaljob' ),
				'new_item_name' => esc_html__( 'New Category', 'opaljob' ),
			],
			'public'       => true,
			'hierarchical' => true,
			'show_ui'      => true,
			'query_var'    => true,
			'rewrite'      => [ 'slug' => _x( 'category', 'slug', 'opaljob' ), 'with_front' => false, 'hierarchical' => true ],
		] ) );

		

	}	

	/**
	 * Category Taxonomy
	 *
	 *	Register Category Taxonomy related to Job post type.
	 *
	 * @since 1.0
	 *
	 * @return avoid
	 */
	public function specialism_taxonomy() {
		//// Job By Specialism //// 
		register_taxonomy( 'opaljob_specialism', 'opaljob_job', apply_filters( 'opaljob_taxonomy_args_job_specialism', [
			'labels'       => [
				'name'          => esc_html__( 'Specialisms', 'opaljob' ),
				'add_new_item'  => esc_html__( 'Add specialism', 'opaljob' ),
				'new_item_name' => esc_html__( 'specialism', 'opaljob' ),
			],
			'public'       => true,
			'hierarchical' => true,
			'show_ui'      => true,
			'query_var'    => true,
			'rewrite'      => [ 'slug' => _x( 'specialism', 'slug', 'opaljob' ), 'with_front' => false, 'hierarchical' => true ],
		] ) );
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
	public function types_taxonomy () {
		//// Job By Type///
		$labels = [
			'name'              => esc_html__( 'Types', 'opaljob' ),
			'singular_name'     => esc_html__( 'Jobs By Type', 'opaljob' ),
			'search_items'      => esc_html__( 'Search Types', 'opaljob' ),
			'all_items'         => esc_html__( 'All Types', 'opaljob' ),
			'parent_item'       => esc_html__( 'Parent Type', 'opaljob' ),
			'parent_item_colon' => esc_html__( 'Parent Type:', 'opaljob' ),
			'edit_item'         => esc_html__( 'Edit Type', 'opaljob' ),
			'update_item'       => esc_html__( 'Update Type', 'opaljob' ),
			'add_new_item'      => esc_html__( 'Add New Type', 'opaljob' ),
			'new_item_name'     => esc_html__( 'New Type', 'opaljob' ),
			'menu_name'         => esc_html__( 'Types', 'opaljob' ),
		];

		register_taxonomy( 'opaljob_types', [ 'opaljob_job' ], [
			'labels'       => apply_filters( 'opaljob_taxomony_types_labels', $labels ),
			'public'       => true,
			'hierarchical' => true,
			'show_ui'      => true,
			'query_var'    => true,
			'rewrite'      => [ 'slug' => _x( 'types', 'slug', 'opaljob' ), 'with_front' => false, 'hierarchical' => true ],
		] );
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
	public function location_taxonomy () {

		
		/// register Location /////
		$labels = [
			'name'              => esc_html__( 'Location', 'opaljob' ),
			'singular_name'     => esc_html__( 'Jobs By Location', 'opaljob' ),
			'search_items'      => esc_html__( 'Search Location', 'opaljob' ),
			'all_items'         => esc_html__( 'All Location', 'opaljob' ),
			'parent_item'       => esc_html__( 'Parent Location', 'opaljob' ),
			'parent_item_colon' => esc_html__( 'Parent Location:', 'opaljob' ),
			'edit_item'         => esc_html__( 'Edit Location', 'opaljob' ),
			'update_item'       => esc_html__( 'Update Location', 'opaljob' ),
			'add_new_item'      => esc_html__( 'Add New Location', 'opaljob' ),
			'new_item_name'     => esc_html__( 'New Location', 'opaljob' ),
			'menu_name'         => esc_html__( 'Location', 'opaljob' ),
		];

		register_taxonomy( 'opaljob_location', 'opaljob_job', [
			'labels'       => apply_filters( 'opaljob_taxomony_location_labels', $labels ),
			'public'       => true,
			'hierarchical' => true,
			'show_ui'      => true,
			'query_var'    => true,
			'rewrite'      => [ 'slug' => _x( 'location', 'slug', 'opaljob' ), 'with_front' => false, 'hierarchical' => true ],
		] );

		// 
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
	public function tags_taxonomy () {

		
		/// register Location /////
		$labels = [
			'name'              => esc_html__( 'Skill Tag', 'opaljob' ),
			'singular_name'     => esc_html__( 'Jobs By Tags', 'opaljob' ),
			'search_items'      => esc_html__( 'Search Tags', 'opaljob' ),
			'all_items'         => esc_html__( 'All Tags', 'opaljob' ),
			'parent_item'       => esc_html__( 'Parent Tags', 'opaljob' ),
			'parent_item_colon' => esc_html__( 'Parent Tags:', 'opaljob' ),
			'edit_item'         => esc_html__( 'Edit Tags', 'opaljob' ),
			'update_item'       => esc_html__( 'Update Tags', 'opaljob' ),
			'add_new_item'      => esc_html__( 'Add New Tags', 'opaljob' ),
			'new_item_name'     => esc_html__( 'New Tags', 'opaljob' ),
			'menu_name'         => esc_html__( 'Skill Tags', 'opaljob' ),
		];

		register_taxonomy( 'opaljob_tag', 'opaljob_job', [
			'labels'       => apply_filters( 'opaljob_taxomony_tag_labels', $labels ),
			'public'       => true,
			'hierarchical' => true,
			'show_ui'      => true,
			'query_var'    => true,
			'rewrite'      => [ 'slug' => _x( 'skill-tag', 'slug', 'opaljob' ), 'with_front' => false, 'hierarchical' => true ],
		] );

		// 
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
	public static function get_category_list( $args = [] ) {
		
		$default = [
			'taxonomy'   => 'opaljob_category',
			'hide_empty' => true,
		];

		if ( $args ) {
			$default = array_merge( $default, $args );
		}

		return get_terms( $default );
	}
}

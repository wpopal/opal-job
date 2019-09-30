<?php
namespace Opal_Job\Libraries\User_Rating;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @link       http://wpopal.com
 * @since      1.0.0
 *
 * @author    WpOpal
 */
class Post_Type {
	/**
	 * Post_Type constructor.
	 */
	public function __construct() {
		add_action( 'init', [ __CLASS__, 'definition' ] );
	}

	/**
	 * Definition.
	 */
	public static function definition() {
		if ( ! is_blog_installed() || post_type_exists( 'user_rating' ) ) {
			return;
		}

		$labels = [
			'name'               => esc_html__( 'User Rating', 'opaljob' ),
			'singular_name'      => esc_html__( 'User Rating', 'opaljob' ),
			'add_new'            => esc_html__( 'Add New User Rating', 'opaljob' ),
			'add_new_item'       => esc_html__( 'Add New User Rating', 'opaljob' ),
			'edit_item'          => esc_html__( 'Edit User Rating', 'opaljob' ),
			'new_item'           => esc_html__( 'New User Rating', 'opaljob' ),
			'all_items'          => esc_html__( 'All User Ratings', 'opaljob' ),
			'view_item'          => esc_html__( 'View User Rating', 'opaljob' ),
			'search_items'       => esc_html__( 'Search User Rating', 'opaljob' ),
			'not_found'          => esc_html__( 'No User Ratings found', 'opaljob' ),
			'not_found_in_trash' => esc_html__( 'No User Ratings found in Trash', 'opaljob' ),
			'parent_item_colon'  => '',
			'menu_name'          => esc_html__( 'User Ratings', 'opaljob' ),
		];

		$labels = apply_filters( 'opaljob_postype_user_rating_labels', $labels );

		register_post_type( 'user_rating',
			apply_filters( 'user_rating_post_type_parameters', [
				'labels'              => $labels,
				'supports'            => [ 'title','editor' ],
				'public'              => true,
				'has_archive'         => true,
				'menu_position'       => 51,
				'categories'          => [],
				'menu_icon'           => 'dashicons-star-filled',
				'map_meta_cap'        => true,
				'publicly_queryable'  => true,
				'exclude_from_search' => false,
				'query_var'           => true,
				'hierarchical'        => false, // Hierarchical causes memory issues - WP loads all records!
				'show_in_nav_menus'   => true,
				'rewrite'             => false,
			] )
		);
	}
}

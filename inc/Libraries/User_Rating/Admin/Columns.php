<?php
namespace Opal_Job\Libraries\User_Rating\Admin;

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
 * @author     WpOpal
 */
class Columns {
	/**
	 * @var string
	 */
	public $prefix = 'user_rating';

	/**
	 * Post_Type constructor.
	 */
	public function __construct() {
		add_filter( 'manage_edit-' . $this->prefix . '_columns', [ $this, 'define_columns' ] );
		add_action( 'manage_' . $this->prefix . '_posts_custom_column', [ $this, 'custom_column_content' ], 10, 2 );
	}

	/**
	 * Define columns.
	 *
	 * @param $columns
	 * @return array
	 */
	public function define_columns( $columns ) {
		if ( empty( $columns ) && ! is_array( $columns ) ) {
			$columns = [];
		}

		// Temp remove columns, we will rebuild late.
		unset( $columns['title'], $columns['date'] );

		$show_columns          = [];
		$show_columns['title'] = esc_html__( 'Title', 'awebooking' );

		$show_columns['comment']  = esc_html__( 'Comment', 'opaljob' );
		$show_columns['response'] = esc_html__( 'In Response To', 'opaljob' );
		$show_columns['author']   = esc_html__( 'Reviewed by', 'opaljob' );
		$show_columns['rating']   = esc_html__( 'Rating', 'opaljob' );
		$show_columns['date']     = esc_html__( 'Date', 'opaljob' );

		return array_merge( $columns, $show_columns );
	}

	/**
	 * Custom review columns.
	 *
	 * @param $column
	 * @param $post_id
	 */
	public function custom_column_content( $column, $post_id ) {
		switch ( $column ) {
			case 'comment':
				echo 'the comment';
				break;
			case 'response':
				echo 'user 1';
				break;
			case 'author':
				echo 'admin';
				break;
			case 'rating':
				echo '5 stars';
				break;
		}
	}
}

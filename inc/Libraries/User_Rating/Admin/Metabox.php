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
class Metabox {
	/**
	 * Post_Type constructor.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', [ $this, 'add_meta_box' ], 30 );
	}

	/**
	 * Add WC Meta boxes.
	 */
	public function add_meta_box() {
		$screen    = get_current_screen();
		$screen_id = $screen ? $screen->id : '';

		// Comment rating.
		// if ( 'comment' === $screen_id && isset( $_GET['c'] ) && metadata_exists( 'comment', wc_clean( wp_unslash( $_GET['c'] ) ), 'rating' ) ) { // phpcs:ignore WordPress.Security.NonceVerification.NoNonceVerification
		add_meta_box( 'opaljob-rating', esc_html__( 'Rating', 'opaljob' ), [ $this, 'output' ], 'user_rating', 'normal', 'high' );
		// }
	}

	/**
	 * Output the metabox.
	 *
	 * @param \WP_Post $post Post object.
	 */
	public static function output( $post ) {
		wp_nonce_field( 'opaljob_save_data', 'opaljob_meta_nonce' );

		?>
		<select name="rating" id="rating">
			<?php
			for ( $rating = 1; $rating <= 5; $rating++ ) {
				printf( '<option value="%1$s"%2$s>%1$s</option>', $rating, 1 ); // WPCS: XSS ok.
			}
			?>
		</select>
		<?php
	}

	/**
	 * Save meta box data.
	 *
	 * @param int      $post_id WP post id.
	 * @param \WP_Post $post    Post object.
	 */
	public static function save( $post_id, $post ) {

	}
}

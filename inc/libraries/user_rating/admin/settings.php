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
class Settings {
	/**
	 * The ID.
	 *
	 * @var string
	 */
	public $id = 'user-rating';

	/**
	 * Settings constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'admin_menu' ], 8 );
		add_action( 'wp_ajax_render_new_feature_item', [ $this, 'render_new_feature_item' ] );
		add_action( 'wp_ajax_nopriv_render_new_feature_item', [ $this, 'render_new_feature_item' ] );
		add_action( 'admin_init', [ $this, 'save_options' ] );
	}

	/**
	 * Register admin sub-menu page.
	 *
	 * @since 1.0
	 *
	 */
	public function admin_menu() {
		add_submenu_page(
			'edit.php?post_type=user_rating',
			apply_filters( $this->id . '-settings-page-title', esc_html__( 'Settings', 'opaljob' ) ),
			apply_filters( $this->id . '-settings-menu-title', esc_html__( 'Settings', 'opaljob' ) ),
			'manage_options',
			$this->id . '-settings',
			[ $this, 'render_page' ]
		);
	}

	/**
	 * Register property types.
	 *
	 * @return array
	 */
	public function get_tabs() {
		return apply_filters( 'opaljob_get_user_rating_tabs', [
			'general'   => esc_html__( 'General', 'opaljob' ),
			'employer'  => esc_html__( 'Employer', 'opaljob' ),
			'candidate' => esc_html__( 'Candidate', 'opaljob' ),
		] );
	}

	/**
	 * Render page.
	 *
	 * Display page with tabs.
	 *
	 * @since 1.0
	 *
	 */
	public function render_page() {
		$matching = $this->get_tabs();

		$tab_active = isset( $_GET['tab'] ) ? trim( $_GET['tab'] ) : 'general';

		if ( ! array_key_exists( $tab_active, $matching ) ) {
			return;
		}

		echo '<div class="opaljob-settings-page">';
		echo '<div class="setting-tab-head"><ul class="inline-list">';

		foreach ( $matching as $match => $tab ) {
			$tab_url = esc_url( add_query_arg( [
				'settings-updated' => false,
				'tab'              => $match,
				'subtab'           => false,
			] ) );

			$class = $match == $tab_active ? ' class="active"' : "";

			echo '<li' . $class . '><a href="' . $tab_url . '" >' . $tab . '</a></li>';
		}
		echo '</ul></div>';
		echo '<form class="opaljob-user-rating-options" name="opaljob-user-rating-options" action="" method="post">';

		wp_nonce_field( 'action_save_user_rating', 'nonce_field_save_user_rating_options' );

		if ( 'general' === $tab_active ) {
			$this->render_general_tab();
		} else {
			$this->render_user_tab( $tab_active );
		}

		echo '<button class="save-button btn btn-submit button button-primary" name="save_page_options" value="savedata" type="submit">' . esc_html__( 'Save', 'opaljob' ) . '</button>';

		echo '</form>';

		echo '</div>';
	}

	/**
	 * Render general tab.
	 */
	public function render_general_tab() {
		$option_key = 'opaljob_user_rating_general';

		$option       = get_option( $option_key );
		$auto_approve = isset( $option['auto_approve'] ) ? $option['auto_approve'] : 'off';
		?>
        <div class="opaljob-field-wrap opaljob-switch-field-wrap form-group" id="auto_approve-wrap">
            <label class="opaljob-label" for="auto_approve"><?php esc_html_e( 'Auto approve', 'opaljob' ); ?></label>
            <label class="opaljob-switch-input">
                <input type="checkbox" name="auto_approve" id="auto_approve" value="on" class="opaljob-switch form-control" <?php checked( 'on', $auto_approve, true ); ?>>
                <span class="slider round"></span>
            </label>
            <p class="opaljob-description"></p>
        </div>
		<?php
	}

	/**
	 * Render user tabs.
	 */
	public function render_user_tab( $tab ) {
		wp_enqueue_script( 'opaljob-admin-user-rating', plugin_dir_url( __FILE__ ) . '../assets/js/admin/user-rating.js', [ 'jquery' ], '1.0', false );

		$option_key = 'opaljob_user_rating_' . $tab;

		$option = get_option( $option_key );
		var_dump($option);
		$enable = isset( $option['enable'] ) ? $option['enable'] : 'off';
		?>
        <div class="opaljob-field-wrap opaljob-switch-field-wrap form-group" id="enable-wrap">
            <label class="opaljob-label" for="enable"><?php esc_html_e( 'Enable review and rating', 'opaljob' ); ?></label>
            <label class="opaljob-switch-input">
                <input type="checkbox" name="enable" id="enable" value="on" class="opaljob-switch form-control" <?php checked( 'on', $enable, true ); ?>>
                <span class="slider round"></span>
            </label>
            <p class="opaljob-description"></p>
        </div>

        <div class="opaljob-field-wrap opaljob-switch-field-wrap form-group features-wrap" id="features-wrap">
            <label class="opaljob-label" for="features"><?php esc_html_e( 'Features rating', 'opaljob' ); ?></label>
            <ul class="opaljob-features-rating-list">
				<?php if ( isset( $option['features'] ) && $features = $option['features'] ) : ?>
					<?php foreach ( $features as $feature ) : ?>
						<?php
						$default = [
							'name' => '',
							'key'  => '',
						];
						$feature = wp_parse_args( $feature, $default );
						?>
                        <li class="opaljob-features-rating-item">
                            <span class="sort-label dashicons dashicons-menu"></span>
                            <input type="text" name="features[name][]" value="<?php echo esc_attr( $feature['name'] ); ?>" placeholder="<?php esc_attr_e( 'name', 'opaljob' ); ?>"/>
                            <input type="text" name="features[key][]" value="<?php echo esc_attr( $feature['key'] ); ?>" placeholder="<?php esc_attr_e( 'key', 'opaljob' ); ?>"/>
                            <a href="#" class="feature-rating-remove"><i class="dashicons dashicons-no"></i></a>
                        </li>
					<?php endforeach; ?>
				<?php endif; ?>
            </ul>
            <a href="#" class="btn button button-secondary add-new-feature"><?php esc_html_e( 'Add new feature', 'opaljob' ); ?></a>
            <p class="opaljob-description"><?php esc_html_e( 'Key: Please enter word not contain blank, special characters. This field is used for saving, it should be lowercase or _ for example: your_key_here.',
					'opaljob' ); ?></p>
            <p class="opaljob-description"><?php esc_html_e( 'Warning: If you change the field names, it will also change them on past reviews.', 'opaljob' ); ?></p>
        </div>
		<?php
	}

	/**
	 * Render new feature item via AJAX.
	 */
	public function render_new_feature_item() {
		ob_start();
		?>
        <li class="opaljob-features-rating-item">
            <span class="sort-label dashicons dashicons-menu"></span>
            <input type="text" name="features[name][]" value="" placeholder="<?php esc_attr_e( 'name', 'opaljob' ); ?>"/>
            <input type="text" name="features[key][]" value="" placeholder="<?php esc_attr_e( 'key', 'opaljob' ); ?>"/>
            <a href="#" class="feature-rating-remove"><i class="dashicons dashicons-no"></i></a>
        </li>
		<?php
		$html = ob_get_contents();
		ob_end_clean();

		$result = [ 'type' => 'success', 'html' => $html ];

		echo json_encode( $result );
		exit;
	}

	/**
	 * Save options.
	 *
	 * Handler options and save them.
	 *
	 * @since 1.0
	 *
	 */
	public function save_options() {
		$matching = $this->get_tabs();

		$tab_active = isset( $_GET['tab'] ) ? trim( $_GET['tab'] ) : 'general';

		if ( ! array_key_exists( $tab_active, $matching ) ) {
			return;
		}

		$option_key = 'opaljob_user_rating_' . $tab_active;

		if ( ! isset( $_POST['nonce_field_save_user_rating_options'] ) ) {
			return;
		}

		if ( ! wp_verify_nonce( $_POST['nonce_field_save_user_rating_options'], 'action_save_user_rating' ) ) {
			return;
		}

		$features = [];
		if ( isset( $_POST['features'] ) && is_array( $_POST['features'] ) && $_POST['features'] && isset( $_POST['features']['name'] ) && $names = $_POST['features']['name'] ) {
			foreach ( $names as $std => $name ) {
				if ( ! $name ) {
					continue;
				}

				if ( isset( $_POST['features']['key'][ $std ] ) && $_POST['features']['key'][ $std ] ) {
					$key = sanitize_title( $_POST['features']['key'][ $std ] );
				} else {
					$key = sanitize_title( $name );
				}

				$features[] = [
					'name' => sanitize_text_field( $name ),
					'key'  => $key,
				];
			}

			if ( ! $features ) {
				$features[] = [
					'name' => esc_html__( 'Rating', 'opaljob' ),
					'key'  => 'rating',
				];
			}
		} else {
			$features[] = [
				'name' => esc_html__( 'Rating', 'opaljob' ),
				'key'  => 'rating',
			];
        }

		$_POST['features'] = $features;

		do_action( 'opaljob_user_rating_before_update_options', $option_key, $_POST );

		update_option( $option_key, $_POST );

		do_action( 'opaljob_user_rating_after_update_options', $option_key, $_POST );
	}
}

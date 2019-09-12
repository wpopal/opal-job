<?php
namespace Opal_Job\Libraries\Form;

use Opal_Job\Libraries\Form\Field\File;
use Opal_Job\Libraries\Form\Field\Iconpicker;
use Opal_Job\Libraries\Form\Field\Map;
use Opal_Job\Libraries\Form\Field\Uploader;
use Opal_Job\Libraries\Form\Field\Taxonomy;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * HTML Form
 *
 * A helper class for outputting common HTML elements, such as product drop downs
 *
 * @package     OpalJob
 * @subpackage  Opal_Job\Libraries
 */
class Form {

	/**
	 * Store the class instance.
	 *
	 * @var static
	 */
	protected static $instance;

	/**
	 * Store the collection of field settings.
	 *
	 * @var array $settings
	 */
	protected $settings;

	/**
	 * Store Type of form as post or page_option, option
	 *
	 * @var string $type
	 */
	protected $type = 'post';

	/**
	 * Store identity of form
	 *
	 * @var static
	 */
	public $form_id = '';

	/**
	 * Datas.
	 *
	 * @var array
	 */
	public $data = [];

	/**
	 * @var int
	 */
	public $object_id;

	/**
	 * Get the class instance.
	 *
	 * @return static
	 */
	public static function get_instance() {
		if ( ! static::$instance ) {
			static::$instance = new static;
		}

		return self::$instance;
	}

	/**
	 * Init Constructor of this
	 *
	 * @return string
	 *
	 */
	public function __construct() {

	}

	/**
	 * Setup.
	 *
	 * @param $type string Type.
	 * @param $key  string Key.
	 */
	public function setup( $type, $key ) {
		if ( $type == 'page_options' ) {
			$this->data = get_option( $key );
		}

		$this->type = $type;

	}

	public function set_object_id( $id ) {  
		$this->object_id = $id;
	}

	/**
	 * Set type.
	 *
	 * @param $type string Type.
	 */
	public function set_type( $type ) {
		$this->type = $type;
	}

	/**
	 * Render HTML Code by Setting Of Field
	 *
	 * @return string
	 */
	public function render_field( $field ) {
		if ( ! isset( $field['id'] ) || ! isset( $field['type'] ) ) {
			return sprintf( esc_html__( 'The field ID or field type is required.', 'opaljob' ), $field ['type'] );
		}

		switch ( $field['type'] ) {
			case 'text':
			case 'text_small':
			case 'text_medium':
			case 'text_number' :
			case 'text_url' :
			case 'text_email':
			case 'text_tel':
			case 'password':
			case 'hidden':
				return $this->text_field( $field );
				break;
			case 'wysiwyg' :
				return $this->editor_field( $field );
				break;
			case 'textarea':
			case 'textarea_small':
				return $this->textarea_field( $field );
				break;
			case 'user':
				return $this->ajax_user_search( $field );
				break;
			case 'select':
				return $this->select_field( $field );
				break;
			case 'radio_inline':
			case 'radio':
				return $this->radio_field( $field );
				break;
			case 'checkbox':
				return $this->checkbox_field( $field );
				break;
			case 'switch':
				return $this->switch_field( $field );
				break;
			case 'group':
				return $this->group_field( $field );
				break;
			case 'date':
				return $this->date_field( $field );
				break;
			case 'colorpicker':
				return $this->colorpicker_field( $field );
				break;
			case 'file':
			case 'file_list':
				return new File( $field, $this, $field ['type'] );
				break;
			case 'taxonomy_select':
			case 'taxonomy_multicheck':
				return new Taxonomy( $field, $this, $field ['type'] );
				break;
			case 'map':
				return new Map( $field, $this );
				break;
			case 'uploader':
				return new Uploader( $field, $this );
				break;	
			case 'iconpicker':
				return new Iconpicker( $field, $this );
				break;
			default:
				return sprintf( esc_html__( 'The field type: %s does not exist!', 'opaljob' ), $field ['type'] );
				break;
		}
	}

	/**
	 * Renders an ajax user search field
	 *
	 * @param array $args
	 * @return string text field with ajax search
	 */
	public function ajax_user_search( $args = [] ) {

		$defaults = [
			'name'         => 'user_id',
			'value'        => isset( $args['default'] ) ? $args['default'] : null,
			'placeholder'  => esc_html__( 'Enter username', 'opaljob' ),
			'label'        => null,
			'desc'         => null,
			'class'        => '',
			'disabled'     => false,
			'autocomplete' => 'off',
			'data'         => false,
		];

		$args = wp_parse_args( $args, $defaults );

		$args['class'] = 'opaljob-ajax-user-search ' . $args['class'];

		$output = '<span class="opaljob_user_search_wrap">';
		$output .= $this->text_field( $args );
		$output .= '<span class="opaljob_user_search_results hidden"><a class="opaljob-ajax-user-cancel" aria-label="' . esc_html__( 'Cancel',
				'opaljob' ) . '" href="#">x</a><span></span></span>';
		$output .= '</span>';

		return $output;
	}

	/**
	 * Get Template path of element form getting by field type
	 *
	 * @param string $field Arguments for the text field.
	 *
	 * @return string      The text field.
	 * @access public
	 */
	public function get_field_path( $field ) {
		return plugin_dir_path( __FILE__ ) . 'field/views/input-' . $field . '.php';
	}

	/**
	 * Text Field
	 *
	 * Renders an HTML Text field.
	 *
	 * @param array $args Arguments for the text field.
	 *
	 * @return string      The text field.
	 * @access public
	 */
	public function text_field( $args ) {
		switch ( $args['type'] ) {
			case 'text_small' :
				$class        = 'opaljob-text-small';
				$args['type'] = 'text';
				break;
			case 'text_medium' :
				$class        = 'opaljob-text-medium';
				$args['type'] = 'text';
				break;
			case 'text_number' :
				$class        = 'opaljob-text-small opaljob-text-number';
				$args['type'] = 'number';
				break;
			case 'text_url' :
				$class        = 'opaljob-text-url';
				$args['type'] = 'url';
				break;
			case 'text_email' :
				$class        = 'opaljob-text-email';
				$args['type'] = 'email';
				break;
			case 'text_tel' :
				$class        = 'opaljob-text-tel';
				$args['type'] = 'tel';
				break;
			case 'password' :
				$class        = 'opaljob-text-password';
				$args['type'] = 'password';
				break;
			case 'hidden' :
				$class        = 'opaljob-text-hidden';
				$args['type'] = 'hidden';
				break;
			default :
				$class        = '';
				$args['type'] = 'text';
		}

		if ( empty( $args['class'] ) ) {
			$args['class'] = 'opaljob-text ' . $class . ' regular-text form-control';
		} elseif ( ! strpos( $args['class'], 'opaljob-text' ) ) {
			$args['class'] .= ' opaljob-text ' . $class . ' regular-text form-control';
		}

		include( $this->get_field_path( 'text' ) );
	}

	/**
	 * Date Picker
	 *
	 * Renders a date picker field.
	 *
	 * @param array $args Arguments for the date picker.
	 *
	 * @return string      The date picker.
	 * @access public
	 */
	public function date_field( $args = [] ) {
		include( $this->get_field_path( 'date' ) );
	}

	/**
	 * Color Picker
	 *
	 * Renders a color picker field.
	 *
	 * @param array $args Arguments for the date picker.
	 *
	 * @return string      The color picker.
	 * @access public
	 */
	public function colorpicker_field( $args ) {
		if ( empty( $args['class'] ) ) {
			$args['class'] = 'opaljob-colorpicker form-control';
		} elseif ( ! strpos( $args['class'], 'opaljob-colorpicker' ) ) {
			$args['class'] .= ' opaljob-colorpicker form-control';
		}

		wp_enqueue_style( 'wp-color-picker' );

		return $this->text_field( $args );
	}

	/**
	 * File field.
	 *
	 * Renders a file field.
	 *
	 * @param array $args Arguments for the file field.
	 *
	 * @return string      The file field.
	 * @access public
	 */
	public function file_field( $args = [] ) {
		include( $this->get_field_path( 'file' ) );
	}

	/**
	 * File list field.
	 *
	 * Renders a file field.
	 *
	 * @param array $args Arguments for the file list field.
	 *
	 * @return string      The file field.
	 * @access public
	 */
	public function file_list_field( $args = [] ) {
		include( $this->get_field_path( 'file-list' ) );
	}

	/**
	 * Taxonomy multicheck field.
	 *
	 * Renders a file field.
	 *
	 * @param array $args Arguments for the date picker.
	 *
	 * @return string      The Taxonomy multicheck field.
	 * @access public
	 */
	public function taxonomy_multicheck_field( $args = [] ) {
		include( $this->get_field_path( 'taxonomy-multicheck' ) );
	}

	/**
	 * Textarea
	 *
	 * Renders an HTML textarea.
	 *
	 * @param array $args Arguments for the textarea.
	 *
	 * @return string      The textarea.
	 * @access public
	 *
	 */
	public function textarea_field( $args = [] ) {
		include( $this->get_field_path( 'textarea' ) );
	}

	/**
	 * Dropdown
	 *
	 * Renders an HTML Dropdown.
	 *
	 * @param array $args Arguments for the dropdown.
	 *
	 * @return string      The dropdown.
	 * @access public
	 */
	public function select_field( $args = [] ) {
		include( $this->get_field_path( 'select' ) );
	}

	/**
	 * Render radio field.
	 *
	 * @return string
	 */
	public function radio_field( $args ) {
		include( $this->get_field_path( 'radio' ) );
	}

	/**
	 * Render radio field.
	 *
	 * @return string
	 */
	public function checkbox_field( $args ) {
		include( $this->get_field_path( 'checkbox' ) );
	}

	/**
	 * Render radio field.
	 *
	 * @return string
	 */
	public function switch_field( $args ) {
		include( $this->get_field_path( 'switch' ) );
	}

	/**
	 * Render editor field.
	 *
	 * @return string
	 */
	public function editor_field( $args ) {
		include( $this->get_field_path( 'editor' ) );
	}

	/**
	 * Render HTML Code by Setting Of Field
	 *
	 * @return string
	 */
	public function group_field( $args ) {
		include( $this->get_field_path( 'group' ) );
	}

	/**
	 * Check if setting field has sub tabs/fields
	 *
	 * @param array $field_setting Field Settings.
	 *
	 * @return bool
	 */
	private function has_sub_tab( $field_setting ) {
		$has_sub_tab = false;
		if ( array_key_exists( 'sub-fields', $field_setting ) ) {
			$has_sub_tab = true;
		}

		return $has_sub_tab;
	}

	/**
	 * Get Navigation Tabs
	 *
	 * @return array
	 */
	public function get_tabs( $settings ) {
		$tabs = [];

		$this->settings = $settings;

		if ( ! empty( $settings ) ) {
			foreach ( $settings as $setting ) {
				if ( ! isset( $setting['id'] ) || ! isset( $setting['title'] ) ) {
					continue;
				}
				$tab = [
					'id'        => $setting['id'],
					'label'     => $setting['title'],
					'icon-html' => ( ! empty( $setting['icon-html'] ) ? $setting['icon-html'] : '' ),
				];

				if ( $this->has_sub_tab( $setting ) ) {
					if ( empty( $setting['sub-fields'] ) ) {
						$tab = [];
					} else {
						foreach ( $setting['sub-fields'] as $sub_fields ) {
							$tab['sub-fields'][] = [
								'id'        => $sub_fields['id'],
								'label'     => $sub_fields['title'],
								'icon-html' => ( ! empty( $sub_fields['icon-html'] ) ? $sub_fields['icon-html'] : '' ),
							];
						}
					}
				}

				if ( ! empty( $tab ) ) {
					$tabs[] = $tab;
				}
			}
		}

		return $tabs;
	}

	/**
	 * Render Form having tabs navigation or not
	 *
	 * @param array $args     Arguments for the text field.
	 * @param array $settings Array for fields and form.
	 * @return string
	 */
	public function render( $args, $settings ) {

		 
		if ( $form_data_tabs = $this->get_tabs( $settings ) ) {
			$this->output_tabs( $form_data_tabs );
		} else {
			$this->output_normal( $settings );
		}
	}

	/**
	 * Render Tabs Navigation
	 *
	 * @param $form_data_tabs
	 */
	public function output_tabs( $form_data_tabs ) {

		$active_tab = ! empty( $_GET['opaljob_tab'] ) ? opaljob_clean( $_GET['opaljob_tab'] ) : 'form_field_options';
		wp_nonce_field( 'opaljob_save_form_meta', 'opaljob_meta_nonce' );
		?>
        <input id="opaljob_active_tab" type="hidden" name="opaljob_active_tab">
        <div class="js-opaljob-metabox-wrap opaljob-metabox-panel-wrap">
            <ul class="opaljob-form-data-tabs opaljob-metabox-tabs">
				<?php foreach ( $form_data_tabs as $index => $form_data_tab ) : ?>
					<?php
					// Determine if current tab is active.
					$is_active = $active_tab === $form_data_tab['id'] ? true : false;
					?>
                    <li class="<?php echo "{$form_data_tab['id']}_tab" . ( $is_active ? ' active' : '' ) . ( $this->has_sub_tab( $form_data_tab ) ? ' has-sub-fields' : '' ); ?>"
                        data-tab="<?php echo $form_data_tab['id']; ?>">
                        <a href="#<?php echo $form_data_tab['id']; ?>"
                           data-tab-id="<?php echo $form_data_tab['id']; ?>">
							<?php if ( ! empty( $form_data_tab['icon-html'] ) ) : ?>
								<?php echo $form_data_tab['icon-html']; ?>
							<?php else : ?>
                                <span class="opaljob-icon opaljob-icon-default"></span>
							<?php endif; ?>
                            <span class="opaljob-label"><?php echo $form_data_tab['label']; ?></span>
                        </a>
						<?php if ( $this->has_sub_tab( $form_data_tab ) ) : ?>
                            <ul class="opaljob-metabox-sub-tabs opaljob-hidden">
								<?php foreach ( $form_data_tab['sub-fields'] as $sub_tab ) : ?>
                                    <li class="<?php echo "{$sub_tab['id']}_tab"; ?>">
                                        <a href="#<?php echo $sub_tab['id']; ?>"
                                           data-tab-id="<?php echo $sub_tab['id']; ?>">
											<?php if ( ! empty( $sub_tab['icon-html'] ) ) : ?>
												<?php echo $sub_tab['icon-html']; ?>
											<?php else : ?>
                                                <span class="opaljob-icon opaljob-icon-default"></span>
											<?php endif; ?>
                                            <span class="opaljob-label"><?php echo $sub_tab['label']; ?></span>
                                        </a>
                                    </li>
								<?php endforeach; ?>
                            </ul>
						<?php endif; ?>
                    </li>
				<?php endforeach; ?>
            </ul>

			<?php foreach ( $this->settings as $setting ) : ?>
				<?php do_action( "opaljob_before_{$setting['id']}_settings" ); ?>
				<?php
				// Determine if current panel is active.
				$is_active = $active_tab === $setting['id'] ? true : false;
				?>
                <div id="<?php echo $setting['id']; ?>"
                     class="panel opaljob_options_panel<?php echo( $is_active ? ' active' : '' ); ?>">
					<?php if ( ! empty( $setting['fields'] ) ) : ?>
						<?php foreach ( $setting['fields'] as $field ) : ?>
							<?php $this->render_field( $field ); ?>
						<?php endforeach; ?>
					<?php endif; ?>
                </div>
				<?php do_action( "opaljob_after_{$setting['id']}_settings" ); ?>

				<?php if ( $this->has_sub_tab( $setting ) ) : ?>
					<?php if ( ! empty( $setting['sub-fields'] ) ) : ?>
						<?php foreach ( $setting['sub-fields'] as $index => $sub_fields ) : ?>
                            <div id="<?php echo $sub_fields['id']; ?>" class="panel opaljob_options_panel opaljob-hidden">
								<?php if ( ! empty( $sub_fields['fields'] ) ) : ?>
									<?php foreach ( $sub_fields['fields'] as $sub_field ) : ?>
										<?php $this->render_field( $sub_field ); ?>
									<?php endforeach; ?>
								<?php endif; ?>
                            </div>
						<?php endforeach; ?>
					<?php endif; ?>
				<?php endif; ?>
			<?php endforeach; ?>
        </div>
		<?php
	}

	/**
	 * Render Form without Tabs Navigation
	 *
	 * @param array $fields Collection Of Setting Of Fields.
	 * @return string
	 */
	public function output_normal( $fields ) {

		static $id_counter = 0;
		if ( function_exists( 'wp_unique_id' ) ) {
			$form_id = wp_unique_id( 'opaljob-form-' );
		} else {
			$form_id = 'opaljob-form-' . (string) ++$id_counter;
		}

		echo '<div class="js-opaljob-metabox-wrap">';

		$this->form_id = $form_id;

		foreach ( $fields as $field ) {
			if ( isset( $field['before_row'] ) ) {
				echo $field['before_row'];
			}

			$this->render_field( $field );

			if ( isset( $field['after_row'] ) ) {
				echo $field['after_row'];
			}
		}

		echo '</div>';
	}

	/**
	 * Gets field data.
	 *
	 * @param $postid
	 * @param $key
	 * @param $isco
	 * @return mixed
	 */
	public function get_field_data( $postid, $key, $isco ) {
		return get_post_meta( $postid, $key, $isco );
	}

	/**
	 * Gets field value.
	 *
	 * @param $field
	 * @return mixed|string|void|null
	 */
	public function get_field_value( $field ) {
		if ( $this->type == 'page_options' ) {
			if ( ! isset( $this->data[ $field['id'] ] ) ) {
				return null;
			} else {
				return $this->data[ $field['id'] ];
			}
		} elseif ( $this->type == 'taxonomy' ) {
			global $taxnow;

			if ( ! $taxnow || empty( $_GET['tag_ID'] ) ) {
				return null;
			}
			$term_id     = absint( $_GET['tag_ID'] );
			$field_value = get_term_meta( $term_id, $field['id'], true );

			return $field_value;
		} elseif ( $this->type == 'custom' ) {
			if ( isset( $this->data[ $field['id'] ] ) ) {
				return $this->data[ $field['id'] ];
			}

			$field_value = ( ! isset( $field_value ) && isset( $field['default'] ) ) ? $field['default'] : '';

			return $field_value;
		} elseif ( $this->type == 'user' ) {
			
			$object_id   = isset( $_REQUEST['user_id'] ) ? absint( $_REQUEST['user_id'] ) : $this->object_id;
			$field_value = get_user_meta( $object_id, $field['id'], true );
			return $field_value;

		} else {
			global $thepostid, $post;
			$thepostid = empty( $thepostid ) ? $post->ID : $thepostid;

			if(  $this->object_id ) {
				 $thepostid = $this->object_id;
			}

			if ( isset( $field['attributes']['value'] ) ) {
				return $field['attributes']['value'];
			}

			$field_value = $this->get_field_data( $thepostid, $field['id'], true );

			/**
			 * Filter the field value before apply default value.
			 */
			$field_value = apply_filters( "{$field['id']}_field_value", $field_value, $field, $thepostid );

			// Set default value if no any data saved to db.
			if ( ! $field_value && isset( $field['default'] ) ) {
				$field_value = $field['default'];
			}

			return $field_value;
		}
	}

	/**
	 * Get repeater field value.
	 *
	 * Note: Use only for single post, page or custom post type.
	 *
	 * @param array $field
	 * @param array $field_group
	 * @param array $fields
	 *
	 * @return string
	 */
	public function get_repeater_field_value( $field, $field_group, $fields ) {
		$field_value = ( isset( $field_group[ $field['id'] ] ) ? $field_group[ $field['id'] ] : '' );

		/**
		 * Filter the specific repeater field value
		 *
		 * @param string $field_id
		 */
		$field_value = apply_filters( "opaljob_get_repeater_field_{$field['id']}_value", $field_value, $field, $field_group, $fields );

		/**
		 * Filter the repeater field value
		 *
		 * @param string $field_id
		 */
		$field_value = apply_filters( 'opaljob_get_repeater_field_value', $field_value, $field, $field_group, $fields );

		return $field_value;
	}

	public function get_repeater_field_id( $field, $fields, $default = false ) {
		$row_placeholder = false !== $default ? $default : '{{row-count-placeholder}}';

		// Get field id.
		$field_id = "{$fields['id']}[{$row_placeholder}][{$field['id']}]";

		/**
		 * Filter the specific repeater field id
		 *
		 * @param string $field_id
		 */
		$field_id = apply_filters( "opaljob_get_repeater_field_{$field['id']}_id", $field_id, $field, $fields, $default );

		/**
		 * Filter the repeater field id
		 *
		 * @param string $field_id
		 */
		$field_id = apply_filters( 'opaljob_get_repeater_field_id', $field_id, $field, $fields, $default );

		return $field_id;
	}
}

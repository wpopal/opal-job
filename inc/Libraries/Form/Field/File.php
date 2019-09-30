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
namespace Opal_Job\Libraries\Form\Field;

use Opal_Job\Libraries\Form\Form;

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
class File {
	/**
	 * @var array
	 */
	public $args;

	/**
	 * @var \Opal_Job\Libraries\Form\Form
	 */
	public $form;

	/**
	 * @var
	 */
	public $type;

	/**
	 * Init Constructor of this
	 *
	 * @return string
	 *
	 */
	public function __construct( $args, Form $form, $type = 'file' ) {
		$classes = [
			'opaljob-upload-file',
			( 'file_list' === $type ) ? 'opaljob-upload-list' : '',
			'regular-text',
			'form-control',
		];

		$defaults = [
			'id'              => '',
			'value'           => isset( $args['default'] ) ? $args['default'] : null,
			'name'            => '',
			'button_text'     => isset( $args['button_text'] ) ? esc_html( $args['button_text'] ) : esc_html__( 'Add or Upload File', 'opaljob' ),
			'description'     => null,
			'class'           => esc_attr( implode( ' ', array_map( 'sanitize_html_class', $classes ) ) ),
			'data'            => false,
			'required'        => false,
			'id_value'        => null,
			'size'            => 50,
			'js_dependencies' => 'media-editor',
			'preview_size'    => 'thumbnail',
			'query_args'      => '',
		];

		wp_enqueue_script( 'media-editor' );

		$args = wp_parse_args( $args, $defaults );

		$args['value'] = $form->get_field_value( $args );

		$id_value         = $form->get_field_value( [ 'id' => $args['id'] . '_id' ] );
		$id_value         = $id_value ? absint( $id_value ) : '';
		$args['id_value'] = $id_value;

		$this->args = $args;
		$this->form = $form;
		$this->type = $type;

		$this->render();
	}

	/**
	 * Render.
	 */
	public function render() {
		if ( 'file_list' === $this->type ) {
			$this->render_file_list();
		} else {
			$this->render_file();
		}
	}

	/**
	 * Render file.
	 */
	public function render_file() {
		$data = '';
		if ( ! empty( $this->args['data'] ) ) {
			foreach ( $this->args['data'] as $key => $value ) {
				$data .= 'data-' . $key . '="' . $value . '" ';
			}
		}

		if ( $this->args['required'] ) {
			$data .= ' required="required" ';
		}

		$output = '<div class="opaljob-field-wrap opaljob-file-field-wrap form-group" id="' . sanitize_key( $this->form->form_id . $this->args['id'] ) . '-wrap" >';

		$output .= '<label class="opaljob-label" for="' . sanitize_key( $this->form->form_id . $this->args['id'] ) . '">' . esc_html( $this->args['name'] ) . '</label>';

		$output .= '<input type="hidden" name="' . esc_attr( $this->args['id'] ) . '" id="' . esc_attr( $this->form->form_id . $this->args['id'] ) . '" value="' . esc_attr( $this->args['value'] ) . '" class="' .
		           $this->args['class'] . '" ' . $data . ' size="' . esc_attr( $this->args['size'] ) . '" data-previewsize="[150,150]" data-sizename="' . esc_attr( $this->args['preview_size'] ) . '"/>';
		$output .= '<input class="opaljob-upload-button button-secondary" type="button" value="' . $this->args['button_text'] . '">';
		$output .= '<input type="hidden" class="opaljob-upload-file-id" name="' . esc_attr( $this->args['id'] ) . '_id' . '" id="' . esc_attr( $this->args['id'] ) . '_id' . '" value="' . esc_attr(
				$this->args['id_value']
			) . '">';

		if ( ! empty( $this->args['description'] ) ) {
			$output .= '<p class="opaljob-description">' . esc_html( $this->args['description'] ) . '</p>';
		}

		$output .= '<div id="' . esc_attr( $this->args['id'] ) . '-status" class="opaljob-media-status">';

		if ( ! empty( $this->args['value'] ) ) {
			$output .= $this->get_file_preview_output();
		}

		$output .= '</div>';

		$output .= '</div>';

		echo $output;
	}

	/**
	 * Render file list.
	 */
	public function render_file_list() {
		$data = '';
		if ( ! empty( $this->args['data'] ) ) {
			foreach ( $this->args['data'] as $key => $value ) {
				$data .= 'data-' . $key . '="' . $value . '" ';
			}
		}

		if ( $this->args['required'] ) {
			$data .= ' required="required" ';
		}

		$output = '<div class="opaljob-field-wrap opaljob-file-list-field-wrap form-group" id="' . sanitize_key( $this->form->form_id . $this->args['id'] ) . '-wrap" >';

		$output .= '<label class="opaljob-label" for="' . sanitize_key( $this->form->form_id . $this->args['id'] ) . '">' . esc_html( $this->args['name'] ) . '</label>';

		$output .= '<input type="hidden" name="' . esc_attr( $this->args['id'] ) . '" id="' . esc_attr( $this->form->form_id . $this->args['id'] ) . '" value="" class="' .
		           $this->args['class'] . '" ' . $data . ' size="' . esc_attr( $this->args['preview_size'] ) . '" data-previewsize="[150,150]" data-sizename="' . esc_attr( $this->args['preview_size']
		           ) . '"/>';
		$output .= '<input class="opaljob-upload-button opaljob-upload-list button-secondary" type="button" value="' . $this->args['button_text'] . '">';
		$output .= '<input type="hidden" class="opaljob-upload-file-id" name="' . esc_attr( $this->args['id'] ) . '_id' . '" id="' . esc_attr( $this->args['id'] ) . '_id' . '" value="' . esc_attr(
				$this->args['id_value']
			) . '">';

		if ( ! empty( $this->args['description'] ) ) {
			$output .= '<p class="opaljob-description">' . esc_html( $this->args['description'] ) . '</p>';
		}

		$output .= '<ul id="' . esc_attr( $this->args['id'] ) . '-status" class="opaljob-media-status opaljob-attach-list">';

		$meta_value = $this->args['value'];

		if ( $meta_value && is_array( $meta_value ) ) {

			foreach ( $meta_value as $id => $fullurl ) {
				$id_input = sprintf( '<input type="hidden" id="filelist-%1$s" data-id="%1$s" name="%2$s" value="%3$s">',
					$id,
					esc_attr( $this->args['id'] ) . '[' . $id . ']',
					$fullurl
				);

				if ( $this->is_valid_img_ext( $fullurl ) ) {
					$output .= $this->img_status_output( [
						'image'    => wp_get_attachment_image( $id, esc_attr( $this->args['preview_size'] ) ),
						'tag'      => 'li',
						'id_input' => $id_input,
					] );
				} else {
					$output .= $this->file_status_output( [
						'value'    => $fullurl,
						'tag'      => 'li',
						'id_input' => $id_input,
					] );
				}
			}
		}

		$output .= '</ul>';

		$output .= '</div>';

		echo $output;
	}

	public function get_file_preview_output() {
		if ( ! $this->is_valid_img_ext( $this->args['value'] ) ) {
			return $this->file_status_output( [
				'value'     => $this->args['value'],
				'tag'       => 'div',
				'cached_id' => $this->args['id'],
			] );
		}

		if ( $this->args['id_value'] ) {
			$image = wp_get_attachment_image( $this->args['id_value'], $this->args['preview_size'], null, [
				'class' => 'opaljob-file-field-image',
			] );
		} else {
			$image = '<img style="max-width: 50px; width: 100%;" src="' . $this->args['value'] . '" class="opaljob-file-field-image" alt="" />';
		}

		return $this->img_status_output( [
			'image'     => $image,
			'tag'       => 'div',
			'cached_id' => $this->args['id'],
		] );
	}

	/**
	 * file/file_list image wrap
	 *
	 * @param array $args Array of arguments for output
	 * @return string       Image wrap output
	 */
	public function img_status_output( $args ) {
		return sprintf( '<%1$s class="img-status opaljob-media-item">%2$s<p class="opaljob-remove-wrapper"><a href="#" class="opaljob-remove-file-button"%3$s>%4$s</a></p>%5$s</%1$s>',
			$args['tag'],
			$args['image'],
			isset( $args['cached_id'] ) ? ' rel="' . $args['cached_id'] . '"' : '',
			esc_html__( 'Remove Image', 'opaljob' ),
			isset( $args['id_input'] ) ? $args['id_input'] : ''
		);
	}

	/**
	 * file/file_list file wrap
	 *
	 * @param array $args Array of arguments for output
	 * @return string       File wrap output
	 */
	public function file_status_output( $args ) {
		return sprintf( '<%1$s class="file-status opaljob-media-item"><span>%2$s <strong>%3$s</strong></span>&nbsp;&nbsp; (<a href="%4$s" target="_blank" rel="external">%5$s</a> / <a href="#" class="opaljob-remove-file-button"%6$s>%7$s</a>)%8$s</%1$s>',
			$args['tag'],
			esc_html__( 'File:', 'opaljob' ),
			$this->get_file_name_from_path( $args['value'] ),
			$args['value'],
			esc_html__( 'Download', 'opaljob' ),
			isset( $args['cached_id'] ) ? ' rel="' . $args['cached_id'] . '"' : '',
			esc_html__( 'Remove', 'opaljob' ),
			isset( $args['id_input'] ) ? $args['id_input'] : ''
		);
	}

	/**
	 * Determines if a file has a valid image extension
	 *
	 * @param string $file File url
	 * @return bool         Whether file has a valid image extension
	 */
	public function is_valid_img_ext( $file, $blah = false ) {
		$file_ext = $this->get_file_ext( $file );

		$valid_types    = [ 'jpg', 'jpeg', 'png', 'gif', 'ico', 'icon' ];
		$is_valid_types = apply_filters( 'opaljob_valid_img_types', $valid_types );
		$is_valid       = $file_ext && in_array( $file_ext, (array) $is_valid_types );

		return (bool) $is_valid;
	}

	/**
	 * Determine a file's extension
	 *
	 * @param string $file File url.
	 * @return string|false       File extension or false
	 */
	public function get_file_ext( $file ) {
		$parsed = parse_url( $file, PHP_URL_PATH );

		return $parsed ? strtolower( pathinfo( $parsed, PATHINFO_EXTENSION ) ) : false;
	}

	/**
	 * Get the file name from a url
	 *
	 * @param string $value File url or path.
	 * @return string        File name
	 */
	public function get_file_name_from_path( $value ) {
		$parts = explode( '/', $value );

		return is_array( $parts ) ? end( $parts ) : $value;
	}

	/**
	 * Outputs the file/file_list underscore Javascript templates in the footer.
	 *
	 * @return void
	 */
	public static function output_js_underscore_templates() {
		?>
        <script type="text/html" id="tmpl-opaljob-single-image">
            <div class="img-status opaljob-media-item">
                <img width="{{ data.sizeWidth }}" height="{{ data.sizeHeight }}" src="{{ data.sizeUrl }}" class="opaljob-file-field-image" alt="{{ data.filename }}" title="{{ data.filename }}"/>
                <p><a href="#" class="opaljob-remove-file-button" rel="{{ data.mediaField }}">{{ data.stringRemoveImage }}</a></p>
            </div>
        </script>
        <script type="text/html" id="tmpl-opaljob-single-file">
            <div class="file-status opaljob-media-item">
                <span>{{ data.stringFile }} <strong>{{ data.filename }}</strong></span>&nbsp;&nbsp; (<a href="{{ data.url }}" target="_blank" rel="external">{{ data.stringDownload }}</a> / <a
                        href="#" class="opaljob-remove-file-button" rel="{{ data.mediaField }}">{{ data.stringRemoveFile }}</a>)
            </div>
        </script>
        <script type="text/html" id="tmpl-opaljob-list-image">
            <li class="img-status opaljob-media-item">
                <img width="{{ data.sizeWidth }}" height="{{ data.sizeHeight }}" src="{{ data.sizeUrl }}" class="opaljob-file_list-field-image" alt="{{ data.filename }}">
                <p><a href="#" class="opaljob-remove-file-button" rel="{{ data.mediaField }}[{{ data.id }}]">{{ data.stringRemoveImage }}</a></p>
                <input type="hidden" id="filelist-{{ data.id }}" data-id="{{ data.id }}" name="{{ data.mediaFieldName }}[{{ data.id }}]" value="{{ data.url }}">
            </li>
        </script>
        <script type="text/html" id="tmpl-opaljob-list-file">
            <li class="file-status opaljob-media-item">
                <span>{{ data.stringFile }} <strong>{{ data.filename }}</strong></span>&nbsp;&nbsp; (<a href="{{ data.url }}" target="_blank" rel="external">{{ data.stringDownload }}</a> / <a
                        href="#" class="opaljob-remove-file-button" rel="{{ data.mediaField }}[{{ data.id }}]">{{ data.stringRemoveFile }}</a>)
                <input type="hidden" id="filelist-{{ data.id }}" data-id="{{ data.id }}" name="{{ data.mediaFieldName }}[{{ data.id }}]" value="{{ data.url }}">
            </li>
        </script>
		<?php
	}
}

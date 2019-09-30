<?php
namespace Opal_Job\Core;

/**
 * Class Responsible for Loading Templates
 *
 * @since      1.0.0
 * @package    Opal_Job
 * @subpackage Opal_Job/views
 */
class View {
	/**
	 * Render Templates
	 *
	 * @access public
	 * @param mixed  $template_name Template file to render.
	 * @param array  $args Variables to make available inside template file.
	 * @param string $template_path Directory to search for template.
	 * @param string $default_path Fallback directory to search for template if not found at $template_path.
	 * @return void
	 */
	public static function render_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
		if ( $args && is_array( $args ) ) {
			extract( $args ); // @codingStandardsIgnoreLine.
		}

		$template_name = $template_name.'.php'; 


		$located = static::locate_template( $template_name, $template_path, $default_path );
		if ( false == $located ) {
			return;
		}

		
		ob_start();
		do_action( 'opal_job_before_template_render', $template_name, $template_path, $located, $args );
		include( $located  );
		do_action( 'opal_job_after_template_render', $template_name, $template_path, $located, $args );

		return ob_get_clean(); // @codingStandardsIgnoreLine.
	}

	/**
	 * Locate a template and return the path for inclusion.
	 *
	 * This is the load order:
	 *
	 *      yourtheme       /   $template_path  /   $template_name
	 *      yourtheme       /   $template_name
	 *      $default_path   /   $template_name
	 *
	 * @access public
	 * @param mixed  $template_name Template file to locate.
	 * @param string $template_path $template_path Directory to search for template.
	 * @param string $default_path Fallback directory to search for template if not found at $template_path.
	 * @return string
	 */
	public static function locate_template( $template_name, $template_path = '', $default_path = '' ) {
		if ( ! $template_path ) {
			$template_path = 'templates/';
		}
		if ( ! $default_path ) {
			$default_path = OPAL_JOB_DIR  . '/templates/';
		}

		// Look within passed path within the theme - this is priority.
		$template = locate_template(
			array(
				trailingslashit( $template_path ) . $template_name,
				$template_name,
			)
		);

		// Get default template.
		if ( ! $template ) {
			$template = $default_path . $template_name;
		}

		if ( file_exists( $template ) ) {
			// Return what we found.
			return apply_filters( 'opal_job_locate_template', $template, $template_name, $template_path );
		} else {
			return false;
		}
	}
}

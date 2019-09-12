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
namespace Opal_Job\Core;
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Responsible for Loading Templates
 *
 * @since      1.0.0
 * @package    Opal_Job
 * @subpackage Opal_Job/views
 * @author    WpOpal <https://www.wpopal.com>
 */
class Template_Loader {

	/**
	 * Templates
	 *
	 * Check and support loading templates in the plugin for post types: job, employer, candidate
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function template(  $template ) {
 
		$find = array( 'opaljob.php' );
		$file = '';
		$posttypes = array(
			'opaljob_job',
			'opaljob_employer',
			'opaljob_candidate'
		);
		if ( is_single() && in_array( get_post_type(), $posttypes ) ) {  
			$sub 	= str_replace('_','-',get_post_type() );
			$file   = 'single-'.$sub.'.php';
			$find[] = $file;
			$find[] = apply_filters( 'opaljob_template_path', 'opaljob/' ) . $file;
		}

		if ( $file ) {
			$template = locate_template( array_unique( $find ) );
			if ( ! $template ) {
				$template = OPAL_JOB_DIR . '/templates/' . $file;
			}
		}

		return $template;
	}

	/**
	 * Register custom pages options
	 *
	 * Show list of custom page options in select "Choose Template" in edit/new a page.
	 *
	 * @since 1.0
	 *
	 * @return Arrray $post_templates
	 */
	public function register_custom_pages ( $post_templates, $wp_theme, $post, $post_type ) {
 		   // Add custom template named template-custom.php to select dropdown 
		 
		$post_templates['fullwidth-page.php'] = esc_html__('OpalJob Fullwidth', 'opaljob');

		return $post_templates;
	}

	/**
	 * load custom pages
	 *
	 *	Check current page using custom page or not, and set its path in the plugin as default.
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function load_custom_pages( $template ) {
	  	
	  	if(  get_page_template_slug() === 'fullwidth-page.php' ) {  

	        if ( $theme_file = locate_template( array( 'page-templates/fullwidth-page.php', 'fullwidth-page.php' ) ) ) {
	            $template = $theme_file;
	        } else {
	            $template = OPAL_JOB_DIR. '/templates/pages/fullwidth-page.php';
	        }
	    }

	    if($template == '') {
	        throw new \Exception('No template found');
	    }

	    return $template;
	}

}
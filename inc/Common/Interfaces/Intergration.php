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
namespace Opal_Job\Common\interfaces;


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
interface Intergration {
	
	/**
	 * Category Taxonomy
	 *
	 *	Register Category Taxonomy related to Job post type.
	 *
	 * @since 1.0
	 *
	 * @return avoid
	 */
	public function register_admin_actions();

	/**
	 * Category Taxonomy
	 *
	 *	Register Category Taxonomy related to Job post type.
	 *
	 * @since 1.0
	 *
	 * @return avoid
	 */
	public function register_frontend_actions ();
}
?>
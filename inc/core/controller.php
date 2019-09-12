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

use Opal_Job\Core\Controller_Registry; 

/**
 * Abstract class to define/implement base methods for all controller classes
 *
 * @since      1.0.0
 * @package    Opal_Job
 * @subpackage Opal_Job/controllers
 */
abstract class Controller {

 
	protected $model;

	 
	protected $view;


	public static function get_instance( $model_class_name = false, $view_class_name = false ) {

		$classname = get_called_class();
		$key_in_registry = Controller_Registry::get_key( $classname, $model_class_name, $view_class_name );

		$instance = Controller_Registry::get( $key_in_registry );

		// Create a object if no object is found.
		if ( null === $instance ) {

			 $model = null; 
			 $view = null;

			$instance = new $classname( $model, $view );

			Controller_Registry::set( $key_in_registry, $instance );
		}

		return $instance;
	}


	protected function get_model() {
		return $this->model;
	}
}



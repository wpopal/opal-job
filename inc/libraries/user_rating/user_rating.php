<?php
namespace Opal_Job\Libraries\User_Rating;

use Opal_Job\Libraries\User_Rating\Admin\Columns;
use Opal_Job\Libraries\User_Rating\Admin\Metabox;
use Opal_Job\Libraries\User_Rating\Admin\Settings;

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
class User_Rating {
	/**
	 * Post_Type constructor.
	 */
	public function __construct() {
		new Post_Type();
		new Metabox();
		new Settings();
		new Columns();
	}
}

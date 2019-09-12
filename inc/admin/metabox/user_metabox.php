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
namespace Opal_Job\Admin\Metabox;

use Opal_Job\Core as Core;

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @author OPALWP
 */
class User_Metabox extends Core\Metabox {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param Avoid
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->mode = 'user';

		$this->metabox_id    = 'opaljob-metabox-form-data';
		$this->metabox_label = esc_html__( 'Options', 'opaljob' );
		$this->object_id = isset( $_REQUEST['user_id'] ) ? absint($_REQUEST['user_id']) : get_current_user_id();

	}

	/**
	 * Callback function save
	 *
	 * All data of post parameters will be updated for each metadat of the post and stored in post_meta table
	 *
	 * @since    1.0.0
	 * @param string $post_id The id of current post.
	 * @param string $post The instance of Post having post typo opaljob
	 */
	public function save( $user_id, $post=null ) {

		// $post_id and $post are required.
		if ( empty( $user_id ) ) {
			return;
		}

		// Don't save meta boxes for revisions or autosaves.
		if ( defined( 'DOING_AUTOSAVE' )  ) {
			return;
		}

		// Check user has permission to edit.
		if ( ! current_user_can( 'edit_user', $user_id ) ) {
			return;
		}

		if ( isset( $_POST['opaljob_meta_nonce'] ) ) {
			$this->save_user_options( $user_id );
		}
	}

	/**
	 * Callback function save
	 *
	 * All data of post parameters will be updated for each metadat of the post and stored in post_meta table
	 *
	 * @since    1.0.0
	 * @param string $plugin_text_domain The text domain of this plugin.
	 */
	private function has_roles ( $user_id, $role ) {

		$user_meta = get_userdata($user_id);
		$user_roles = $user_meta->roles;
		return in_array(  $role, $user_roles );
	}

	/**
	 * Callback function save
	 *
	 * All data of post parameters will be updated for each metadat of the post and stored in post_meta table
	 *
	 * @since    1.0.0
	 * @param string $plugin_text_domain The text domain of this plugin.
	 */
	public function get_settings() {

 		if( $this->has_roles($this->object_id, 'opaljob_employer') ){
 			$object  = new \Opal_Job\Admin\Metabox\Fields\Employer_Fields();
 			return $object->get_fields();
 		}

 		if( $this->has_roles($this->object_id, 'opaljob_candidate') ){
 			$object  = new \Opal_Job\Admin\Metabox\Fields\Candidate_Fields();
 			return $object->get_fields();
 		}

		$object  = new \Opal_Job\Admin\Metabox\Fields\User_Fields();
		return $object->get_fields();
	}	
}

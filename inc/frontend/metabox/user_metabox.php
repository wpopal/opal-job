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
namespace Opal_Job\Frontend\Metabox;
 
use Opal_Job\Core;

/**
 * User Metabox Class
 *
 * This class to define fields form which will render while editing profile
 * fields will be showed by user roles
 *
 * @version  1.0 
 * @author OPALWP
 */
class User_Metabox extends Core\Metabox {
	
	/**
	 * Store Tyle of field form such as forgot password, profile...
	 *
	 * @var String $type
	 */
	public $type = '';

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
		$this->object_id = get_current_user_id();
	}

	/**
	 * Callback function save
	 *
	 * All data of user parameters will be updated for each metadat of the post and stored in user_meta table
	 *
	 * @since    1.0.0
	 * @param string $user_id The id of current user.
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
	 * Has Role Function
	 *
	 * Check user having role or not.
	 *
	 * @since    1.0.0
	 * @param Integer $user_id ID of user 
	 * @param String $role User role
	 *
	 * @return  Boolean true if have this role.
	 */
	private function has_roles ( $user_id, $role ) {

		$user_meta = get_userdata( $user_id );
		$user_roles = $user_meta->roles;
		return in_array(  $role, $user_roles );
	}

	/**
	 * Get Setting fields
	 *
	 * Check current user id is login user or editing user by id. Base on the use's role and typ
	 * to show following fields. 
	 * 
	 * @since    1.0.0
	 * @param Array $fields 
	 */
	public function get_settings() {

 		$object_id = isset( $_REQUEST['user_id'] ) ? absint($_REQUEST['user_id']) : get_current_user_id();

 		if( $this->has_roles($object_id, 'opaljob_employer') ){
 			$object  = new \Opal_Job\Frontend\Metabox\Fields\Employer_Fields();
 			return $object->get_fields( $this->type );
 		}

 		if( $this->has_roles($object_id, 'opaljob_candidate') ){
 			$object  = new \Opal_Job\Frontend\Metabox\Fields\Candidate_Fields();
 			
 			return $object->get_fields( $this->type );
 		}

		$object  = new \Opal_Job\Frontend\Metabox\Fields\User_Fields();
		return $object->get_fields( $this->type );
	}	
}
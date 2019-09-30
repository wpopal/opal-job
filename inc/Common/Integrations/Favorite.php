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
namespace Opal_Job\Common\Integrations;

use WP_Query; 
use Opal_Job\Common\Interfaces\Intergration; 
/**
 * Fired during plugin deactivation
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @link       http://wpopal.com
 * @since      1.0.0
 *
 * @author     WpOpal
 *
 */

class Favorite implements Intergration {

	/**
	 * @var integer $userId
	 */
	protected $userId ; 

	/**
	 * Get instance of this object
	 */
	public static function get_instance(){
		static $_instance;
		if( !$_instance ){
			$_instance = new Favorite();
		}
		return $_instance;
	}

	/**
	 * Render Sidebar
	 *
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */	
	public function register_admin_actions() {  
	 
	}

	/**
	 * Render Sidebar
	 *
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function register_frontend_actions() {

		add_shortcode( 'opaljob_favorite_button' ,   array( $this,  'favorite_button' ) );
 		add_shortcode( 'opaljob_user_favious_jobs' , array( $this,  'favorite_jobs' ) );
 		add_action( 'opaljob_job_loop_content_before', array( $this,  'render_favorite_button' ) );
		/**
	 	 * Ajax action
	 	 */
		add_action( 'wp_ajax_opaljob_toggle_status', array($this,'toggle_status') );
		add_action( 'wp_ajax_nopriv_opaljob_toggle_status', array($this,'toggle_status') );
		add_action( 'init',  array($this,'init') );

		// show content page in user dashboard
		add_filter( 'opaljob/dashboard/tab_content/favorite' , array( $this,  'favorite_jobs' ) );

		$this->userId = get_current_user_id(); 
	}

	/**
	 * Constructor 
	 */
	public function setup(){
 
	}

	public function init () {
		
	}
 

	/**
	 * Allow set or remove favorite
	 */
	public function toggle_status(){

		if( isset($_POST['job_id']) && $this->userId > 0 ){
			
			$job_id = absint( $_POST['job_id'] ); 

			$msg = esc_html__( 'Added this to your favorite.', 'opaljob' );
			$items = get_user_meta( $this->userId,  'opaljob_user_favorite', true );
			if( !is_array($items) ){
				$items = array();
			}

			$items = array_unique( $items );	
			
 	    	


 	    	if( in_array( $job_id, $items ) ){  
 	    		$key = array_search( $job_id, $items);
 	    		unset($items[$key]);
 	    		$msg = esc_html__( 'Removed this to your favorite.', 'opaljob' );
 	    	}else { 
 	    		$items[] = $job_id;
 	    	}
 	    	// remove items emty 
 	    	foreach( $items as $key => $value ) {
 	    		if( empty($value) ) {
 	    			unset( $items[$key] );
 	    		}
 	    	}

 	    	update_user_meta( $this->userId,  'opaljob_user_favorite', $items );

		}

		$html = $this->favorite_button( array('job_id' => $job_id ) );

		return opaljob_output_msg_json(
			true,
			$msg,
			array( 'html' => $html )
		);

		exit;
	}

	/**
	 * favorite button
	 *
	 * render favorite button in loop
	 *
	 * @since    1.0.0
	 * @param Array $atts Parameter as setting for display in many styles.
	 * @return String Html of favorite button.
	 */
	
	public function render_favorite_button () {
		echo $this->favorite_button( );
	}

	/**
	 * favorite button
	 *
	 * render favorite button in loop
	 *
	 * @since    1.0.0
	 * @param Array $atts Parameter as setting for display in many styles.
	 * @return String Html of favorite button.
	 */
	public function favorite_button( $atts=array() ){ 

		$atts['userId'] = $this->userId;   
		if( !isset($atts['job_id']) ){
			$atts['job_id'] = get_the_ID();
		}

		$items = get_user_meta( $this->userId,  'opaljob_user_favorite', true );


		if( is_array($items) && in_array( $atts['job_id'] , $items ) ){
			$atts['existed'] = 1;
		} else {
			$atts['existed'] = 0;
		}
 	    
		ob_start();
		echo opaljob_render_template( 'common/favorite-button' , $atts );
		$ouput = ob_get_contents();
		ob_end_clean();

		return $ouput;
	}

	/**
	 * favorite button
	 *
	 * show all favorited jobs with pagination.
	 *
	 * @since    1.0.0
	 * @param  Avoid. 
	 * @return String grid of favorite collection from sigined user.
	 */
	public function favorite_jobs(){

		$paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
		$per_page = 9;
		$items = (array)get_user_meta( $this->userId,  'opaljob_user_favorite', true );
		
		$args = array(
			'post_type'         => 'opaljob_job',
			'paged'				=> $paged,
			'posts_per_page'	=> $per_page,
			'post__in'			=> !empty($items) ? $items : array( 9999999 )
		);
 
		$loop = new WP_Query( $args );
	
		return opaljob_render_template( 'dashboard/candidate/favorite-jobs' ,  array('loop' => $loop) );
	}
}
?>
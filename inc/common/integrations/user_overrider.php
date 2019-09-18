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
use Opal_Job\Common\interfaces\Intergration;  
use Opal_Job\Core\URI;
/**
 * Class Responsible for Loading Templates
 *
 * @since      1.0.0
 * @package    Opal_Job
 * @subpackage Opal_Job/views
 */
class User_Overrider implements Intergration {

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

 		add_filter( 'author_link', 			 [$this, 'author_link'], 10, 3 );
		add_filter( 'query_vars',  			 [$this, 'users_query_vars'], 3 );
		add_filter( 'author_rewrite_rules',  [$this, 'author_rewrite_rules'], 3 );
		add_action( 'init',  		 		 [$this, 'change_author_permalinks'] );
		add_filter( 'author_template',  	 [$this, 'override_template'], 3 );

		 
		////
		/// Check Media show for current user and process pending 
		///
		// hacongtien-fix
		/// add_filter( 'pre_get_posts', 			   [ $this, 'show_current_user_attachments' ] );
		add_filter( 'ajax_query_attachments_args', [$this, 'ajx_show_current_user_attachments']);	
		// add_filter( 'wp_handle_upload', 		   [$this, 'handle_upload'], 10, 2 );

		///
		///
		add_action( 'init', array( $this, 'disable' ), 100000 );
	}

	/**
	 * Process Save Data Post Profile
	 *
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function disable(){
		if ( ! current_user_can( 'manage_options' ) ) {
			add_action( 'wp_before_admin_bar_render', array( $this, 'disable_profile_page' )  );
			add_action( 'admin_init', array( $this, 'disable_profile_page' )  );
			add_filter('show_admin_bar', '__return_false');
		}
	}

	/**
	 * Process Save Data Post Profile
	 *
	 *	Display Sidebar on left side and next is main content 
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function disable_profile_page(){

		// Remove AdminBar Link
	    if ( 
	        'wp_before_admin_bar_render' === current_filter()
	        && ! current_user_can( 'manage_options' )
	    )
	        return $GLOBALS['wp_admin_bar']->remove_menu( 'edit-profile', 'user-actions' );

	    // Remove (sub)menu items
	  //  remove_menu_page( 'profile.php' );
		if( function_exists("remove_submenu_page") ){ 
		  	remove_submenu_page( 'users.php', 'profile.php' );
		}  
	    // Deny access to the profile page and redirect upon try
	    if ( 
	        defined( 'IS_PROFILE_PAGE' )
	        && IS_PROFILE_PAGE
	        && ! current_user_can( 'manage_options' )
	        )
	    {
	       wp_redirect( URI::get_dashboard_url( 'profile' ) );
	        exit;
	    }
	}

	/**
	 * Define Taxonomies and Postypes Using for global
	 *
	 * Uses the Internationalization_I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @access    private
	 */
	public function show_current_user_attachments( $wp_query_obj ) {
	 
		global $current_user, $pagenow;

		if ( ! is_a( $current_user, 'WP_User' ) ) {
			return;
		}

		if ( ! in_array( $pagenow, [ 'upload.php', 'admin-ajax.php' ] ) ) {
			return;
		}
		 
		$wp_query_obj->set( 'author', $current_user->ID );
		
		return $wp_query_obj;
	}

	public function ajx_show_current_user_attachments( $args ) {
 
		return $args;
	}

	public function handle_upload( $upload, $context  ) {
		// echo '<pre>ha congtien' . print_r( $context ,1 ) ;die;
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
	public function author_link( $link, $author_id, $author_nicename ) {

		$user = get_user_by( 'ID', $author_id );
		if( !$user->roles ){
			$author_level = 'user';
		} else {
			if( in_array( "opaljob_candidate", $user->roles )) {
				$author_level = 'candidate';
			} else if( in_array( "opaljob_employer", $user->roles )) {
				$author_level = 'employer';
			} else {
				$author_level = 'user';
			}
		}

	 	$link = str_replace('%author_custom_slug%', $author_level, $link );
    	$link = apply_filters('opaljob_override_author_link', $link, $author_id, $author_nicename);

		return $link;
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
	public function users_query_vars( $vars ) {

		$new_vars = array( 'author', 'candidate', 'employer' );
    	
    	$vars = $new_vars + $vars;

		return $vars;
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
	public function change_author_permalinks() {
		global $wp_rewrite;

		$cs_author_levels = array(
			'author', 
			'employer',
			'candidate'
		);
	
	    add_rewrite_tag('%author_custom_slug%', '(' . implode('|', $cs_author_levels) . ')');
	    $wp_rewrite->author_base = '%author_custom_slug%';
	    $wp_rewrite->flush_rules();
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
	public function author_rewrite_rules( $author_rewrite_rules ) {

		foreach ($author_rewrite_rules as $pattern => $substitution) {

	        if ( FALSE === strpos($substitution, 'author_name') ) {
	            unset( $author_rewrite_rules[$pattern] );
	        }
	    }
	    $author_rewrite_rules = apply_filters('jopaljob_override_author_rule', $author_rewrite_rules);
	    return $author_rewrite_rules;
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
	public function override_template ( $template ) {
		$author = get_queried_object();
		if( $author->roles ) {

			if ( in_array( "opaljob_employer", $author->roles ) ) {
				$template = OPAL_JOB_DIR . 'templates/single-opaljob-employer.php';
			} else if ( in_array( "opaljob_candidate", $author->roles ) ) {
				$template = OPAL_JOB_DIR . 'templates/single-opaljob-candidate.php';
			}
		}
		return $template;
	}
}

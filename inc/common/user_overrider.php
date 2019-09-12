<?php
namespace Opal_Job\Common;
/**
 * Class Responsible for Loading Templates
 *
 * @since      1.0.0
 * @package    Opal_Job
 * @subpackage Opal_Job/views
 * @author     Sumit P <sumit.pore@gmail.com>
 */
class User_Overrider {

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

	        if (FALSE === strpos($substitution, 'author_name') ) {
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
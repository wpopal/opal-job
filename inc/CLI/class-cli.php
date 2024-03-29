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
namespace Opal_Job\CLI;

class  Job {

    public function __construct() {
        WP_CLI::add_command( 'pn_commandname', array( $this, 'command_example' ) );
    }

    /**
     * Example command
	 * API reference: https://wp-cli.org/docs/internal-api/
	 *
	 * @param array $args The attributes.
	 *
	 * @return void
	 */
	public function command_example( $args ) {
		// Message prefixed with "Success: ".
		WP_CLI::success( $args[0] );
		// Message prefixed with "Warning: ".
		WP_CLI::warning( $args[0] );
		// Message prefixed with "Debug: ". when '--debug' is used
		WP_CLI::debug( $args[0] );
		// Message prefixed with "Error: ".
		WP_CLI::error( $args[0] );
		// Message with no prefix
		WP_CLI::log( $args[0] );
		// Colorize a string for output
		WP_CLI::colorize( $args[0] );
		// Halt script execution with a specific return code
		WP_CLI::halt( $args[0] );
	}
}

?>
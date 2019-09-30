<?php
/**
 * $Desc$
 *
 * @version    $Id$
 * @package    $package$
 * @author     Opal  Team <info@wpopal.com >
 * @copyright  Copyright (C) 2019 wpopal.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.wpopal.com
 * @support  http://www.wpopal.com/support/forum.html
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

opaljob_print_notices();

if ( is_user_logged_in() ) {
	_e( 'You are currently logged in.', 'opaljob' );

	return;
}

$types =  array();
?>
<div class="opaljob-form">
	<?php if ( $hide_title === false ) : ?>
        <h3><?php esc_html_e( 'Register', 'opaljob' ); ?></h3>
	<?php endif; ?>

	<?php if ( $message ) : ?>
        <p><?php printf( '%s', $message ) ?></p>
	<?php endif; ?>

    <form method="POST" class="opaljob-register-form opaljob-member-form">

		<?php do_action( 'opaljob_member_before_register_form' ); ?>

        <p class="opaljob-form-field username validate-required">
            <label for="reg_username"><?php esc_html_e( 'Username', 'opaljob' ); ?> <span class="required">*</span></label>
            <input type="text" class="opaljob-input input-text" name="username" id="reg_username" required="required" value="<?php if ( ! empty( $_POST['username'] ) ) {
				echo esc_attr( $_POST['username'] );
			} ?>"/>
        </p>

        <p class="opaljob-form-field email validate-required">
            <label for="reg_email"><?php esc_html_e( 'Email address', 'opaljob' ); ?> <span class="required">*</span></label>
            <input type="email" class="opaljob-input input-text" name="email" id="reg_email" required="required" value="<?php if ( ! empty( $_POST['email'] ) ) {
				echo esc_attr( $_POST['email'] );
			} ?>"/>
        </p>

        <p class="opaljob-form-field password validate-required">
            <label for="reg_password"><?php esc_html_e( 'Password', 'opaljob' ); ?> <span class="required">*</span></label>
            <input type="password" class="opaljob-input input-text" name="password" required="required" id="reg_password"/>
        </p>

        <p class="opaljob-form-field password confirm-password validate-required">
            <label for="reg_password1"><?php esc_html_e( 'Repeat-Password', 'opaljob' ); ?> <span class="required">*</span></label>
            <input type="password" class="opaljob-input input-text" name="password1" required="required" id="reg_password1"/>
        </p>

		<?php if ( $types ): ?>

            <p class="opaljob-form-field usertype validate-required">
                <label for="userrole"><?php esc_html_e( 'Type', 'opaljob' ); ?> <span class="required">*</span></label>
                <select name="role" id="userrole" class="form-control">
					<?php foreach ( $types as $type => $label ): ?>
                        <option value="<?php echo $type; ?>"><?php echo $label; ?></option>
					<?php endforeach; ?>
                </select>
            </p>
		<?php endif; ?>


        <p class="opaljob-form-field i-agree validate-required">
            <label><?php esc_html_e( 'I agree with', 'opaljob' ); ?> <span class="required">*</span></label>
            <a href="#"><?php esc_html_e( 'terms & conditions', 'opaljob' ); ?></a>
            <input type="checkbox" name="confirmed_register" id="confirmed_register" required="required" class="comfirmed-box"/>
        </p>

		<?php do_action( 'opaljob_register_form' ); ?>
		<?php do_action( 'register_form' ); ?>

        <p class="opaljob-form-field submit">
			<?php wp_nonce_field( 'opaljob-register', 'opaljob-register-nonce' ); ?>
			<?php if ( $redirect ) : ?>
                <input type="hidden" name="redirect" value="<?php echo esc_url( $redirect ); ?>">
			<?php endif; ?>
            <input type="submit" class="opaljob-button button btn btn-primary" name="register" value="<?php esc_attr_e( 'Register', 'opaljob' ); ?>"/>
        </p>

		<?php do_action( 'opaljob_member_after_register_form' ); ?>
    </form>
</div>

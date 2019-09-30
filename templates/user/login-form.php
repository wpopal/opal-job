<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

if ( is_user_logged_in() ) {
	esc_html_e( 'You are currently logged in.', 'opaljob' );

	return;
}

?>

<div class="opaljob-form">
	<?php if ( $hide_title === false ) : ?>
        <h3><?php esc_html_e( 'Login', 'opaljob' ); ?></h3>
	<?php endif; ?>

	<?php if ( $message ) : ?>
        <p><?php printf( '%s', $message ) ?></p>
	<?php endif; ?>

    <form method="POST" class="opaljob-login-form opaljob-member-form">
		<?php do_action( 'opaljob_member_before_login_form' ); ?>

        <p class="opaljob-form-field username validate-required">
            <label for="username"><?php esc_html_e( 'Username or email address', 'opaljob' ); ?> <span class="required">*</span></label>
            <input type="text" class="opaljob-input text input-text" name="username" id="username" required="required" value="<?php if ( ! empty( $_POST['username'] ) ) {
				echo esc_attr( $_POST['username'] );
			} ?>"/>
        </p>

        <p class="opaljob-form-field password validate-required">
            <label for="password"><?php esc_html_e( 'Password', 'opaljob' ); ?> <span class="required">*</span></label>
            <input class="opaljob-input text input-text" type="password" name="password" required="required" id="password"/>
        </p>

		<?php do_action( 'opaljob_member_login_form' ); ?>

        <p class="opaljob-form-field remberme">
            <label>
                <input class="opaljob-input checkbox" name="rememberme" type="checkbox" value="forever"/> <?php esc_html_e( 'Remember me', 'opaljob' ); ?>
            </label>
        </p>

        <p class="opaljob-form-field submit">
			<?php wp_nonce_field( 'opaljob-login', 'opaljob-login-nonce' ); ?>
			<?php if ( $redirect ) : ?>
                <input type="hidden" name="redirect" value="<?php echo esc_url( $redirect ); ?>">
			<?php endif; ?>
            <input type="submit" class="opaljob-button button btn btn-primary" name="login" value="<?php esc_attr_e( 'Login', 'opaljob' ); ?>"/>
            <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'opaljob' ); ?></a>
        </p>

         <p class="opaljob-form-field register">
            <a href="<?php echo esc_url( opaljob_get_register_page_uri() ); ?>"><?php esc_html_e( 'Register now!', 'opaljob' ); ?></a>
        </p>  

		<?php do_action( 'login_form' ); ?>

		<?php do_action( 'opaljob_member_after_login_form' ); ?>
    </form>
</div>

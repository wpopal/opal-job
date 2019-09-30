<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

 
 
if( !isset($type) ){
    $type = 'job';
} 
if( !isset($heading) ){

    $heading =  esc_html__( 'Contact Me', 'opaljob' ); 
}

$id = 'send-contact-form';

$popup = isset( $popup ) ? $popup : false; 

?>
<?php if ( ! empty( $email ) ) : ?>

    <?php if( $popup ): ?>
    <div id="opaljob-contact-form-popup" class="white-popup popup-width-80  mfp-hide opaljob-mfp-popup">
        <div class="opaljob-popup-content">
    <?php endif; ?>

        <div class="contact-form-container">
            <div class="opaljob-panel panel-contact-form">
                <div class="panel-heading">
                    <h4 class="contact-form-title"><?php echo $heading; ?></h4>
                </div>
                <div class="panel-body">
                    <div class="property-equire-form-container">
                        <div class="box-content">
                            <form method="post" action="" class="opaljob-message-form">
                                <?php do_action('opaljob_message_form_before'); ?>

                                <?php  echo apply_filters( 'opaljob_email_contact_form', "" ); ?>

                                <?php do_action( 'opaljob_message_form_after' ); ?>
                                <?php  wp_nonce_field( $id, 'message_action' ); ?>
                                <button class="button w-100 btn btn-primary btn-3d" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> <?php esc_html_e( ' Processing', 'opaljob' ); ?>" type="submit" name="contact-form"><?php echo esc_html__( 'Send message', 'opaljob' ); ?></button>
                            </form>
                        </div><!-- /.agent-contact-form -->
                    </div><!-- /.agent-contact-->
                </div><!-- /.agent-contact-->
            </div><!-- /.panel-body-->
        </div><!-- /.contact-form-container-->
    <?php if( $popup ): ?>
        </div>
    </div>
    <?php endif; ?>
<?php endif; ?>
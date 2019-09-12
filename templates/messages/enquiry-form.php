<?php 
global $post;

$message 	 =  sprintf(__('Hi, I am interested in %s (Property ID: %s)', 'opaljob'), get_the_title() , get_the_ID() );
 
$job_id    = get_the_ID();
$heading 	    = esc_html__( 'Enquire about job', 'opaljob' ); 
 
$id             = 'send-enquiry-form';
?>

<?php if( isset($nowrap) && $nowrap==1 ) : ?>
 <form method="post" action="" class="opaljob-message-form">
    <?php do_action('opaljob_message_form_before'); ?>
    
    <?php  echo apply_filters( 'opaljob_email_enquiry_form', "" ); ?>   

    <?php do_action( 'opaljob_message_form_after' ); ?> 
    <?php  wp_nonce_field( $id, 'message_action' ); ?>
    <button class="button btn btn-primary btn-3d" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> <?php esc_html_e( ' Processing', 'opaljob' ); ?>" type="submit" name="contact-form"><?php echo esc_html__( 'Send message', 'opaljob' ); ?></button>
</form>
<?php else : ?>    
<div class="opaljob-box-content job-equire-form">
    <div class="opaljob-box">
        <div class="job-equire-form-container">
            <h5 class="contact-form-title"><?php echo $heading; ?></h5>
            <div class="box-content">
                <form method="post" action="" class="opaljob-message-form">
                    <?php do_action('opaljob_message_form_before'); ?>
                    
                    <?php  echo apply_filters( 'opaljob_email_enquiry_form', "" ); ?>   

                    <?php do_action( 'opaljob_message_form_after' ); ?> 
                    <?php  wp_nonce_field( $id, 'message_action' ); ?>
                    <button class="button btn btn-primary btn-3d" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> <?php esc_html_e( ' Processing', 'opaljob' ); ?>" type="submit" name="contact-form"><?php echo esc_html__( 'Send message', 'opaljob' ); ?></button>
                </form>
            </div><!-- /.agent-contact-form -->
        </div><!-- /.agent-contact-->
    
    </div>	
</div>
<?php endif; ?>
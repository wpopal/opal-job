<div id="<?php echo $id; ?>-popup" class="white-popup mfp-hide opaljob-mfp-popup">
    <h4><?php echo $heading; ?></h4>
    <p class="opaljob-note"><?php echo $description; ?></p>
    <?php echo '<form action="//' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '" class="opaljob-message-form" method="post" id="'.$id.'" enctype="multipart/form-data" data-action="send_email_request_reviewing">'; ?>
	<?php do_action( 'opaljob_message_form_before' ); ?>
	<?php  echo $form; ?>
	 <?php  wp_nonce_field( $id, 'message_action' ); ?>

	<?php do_action( 'opaljob_message_form_after' ); ?>
	<button type="submit" name="submit" value="<?php _e( 'Send now', 'opaljob' ); ?>" class="btn btn-primary">
		<?php _e( 'Send now', 'opaljob' ); ?>
	</button>
	<?php echo '</form>'; ?>
</div>

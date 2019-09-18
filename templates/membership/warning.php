 <?php if( !opaljob_check_has_add_listing( $user_id ) ): ?>
<div class="alert alert-warning">
	<p><?php esc_html_e( 'Your package has 0 left listing, you could not add any more. Please upgrade now', 'opaljob' );?></p>
	<p><a href="<?php echo opalmembership_get_membership_page_uri();?>" class="btn btn-primary"><?php esc_html_e( 'Click to this link to see plans', 'opaljob' );?></a></p>
</div>
<?php endif; ?>

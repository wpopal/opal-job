<div class="opaljob-dashboard-profile">
	<h2><?php esc_html_e( 'Edit Job', 'opaljob' ); ?></h2>
	<div class="dashboard-content">	
		<?php do_action( "opaljob/submision/render_edit_form/before"); ?>
		<?php if( $allow ): ?>
		<form class="opaljob-submited-form" action="" method="post">
			<?php $metabox->output(); ?>
			<?php wp_nonce_field( 'save-submission-data', 'submission_action' ); ?>
			<button type="submit" name="submit" value="submit">
				<?php esc_html_e( 'Save', 'opaljob' ); ?>		
			</button>
		</form>
		<?php else : ?>
		<div class="alert alert-warning">
			<?php esc_html_e( 'You have not permission to post and edit job. Please keep contact us to resolve this issue.', 'opaljob' ); ?>
		</div>	
		<?php endif; ?>	
		<?php do_action( "opaljob/submision/render_edit_form/after"); ?>
	</div>	
</div>
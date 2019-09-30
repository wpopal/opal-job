<?php 
$form_id = isset( $form_id ) ? $form_id : "opaljob-metabox-form";
do_action( 'opaljob/metabox_form/before' ); ?>
<div class="opaljob-dashboard-profile">
	<h2><?php esc_html_e( 'Resume', 'opaljob' ); ?></h2>
	<div class="dashboard-content">	
		<form class="opaljob-metabox-form" id="<?php echo $form_id; ?>" action="" method="post">
			 <?php $metabox->output(); ?>
			<?php wp_nonce_field( $action, 'save_front_user_data' ); ?>
			<input type="hidden" name="target" value="<?php echo $type; ?>">
			<div class="metabox-form-footer">
				<button type="submit" name="submit" value="<?php echo $type; ?>">
					<?php esc_html_e( 'Save', 'opaljob' ); ?>		
				</button>
			</div>
		</form>
	</div>	
</div>
<?php do_action( 'opaljob/metabox_form/after' ); ?>
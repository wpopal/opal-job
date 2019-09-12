<div class="opaljob-dashboard-profile">
	<h2><?php esc_html_e( 'Profile', 'opaljob' ); ?></h2>
	<div class="dashboard-content">	
		<form class="profile-form" action="" method="post">
			<?php $metabox->output(); ?>
			<?php wp_nonce_field( 'save-profile-data', 'save_profile' ); ?>
			<button type="submit" name="submit" value="submit">
				<?php esc_html_e( 'Save', 'opaljob' ); ?>		
			</button>
		</form>
	</div>	
</div>
<?php $model = opaljob_get_user_model(); ?> 
<?php if( $model->user_id ): ?>
<?php if( !$model->has_user_applied( $job->ID ) ): ?>
	<a href="#" data-employer-id="<?php echo $member->ID; ?>" data-job-id="<?php echo $job->ID; ?>" class="btn btn-primary job-apply-now">
		<span><?php esc_html_e( 'Apply Now', 'opaljob' ); ?></span>	
	</a>	
	<?php else : ?>
	<a href="#" data-employer-id="<?php echo $member->ID; ?>" data-job-id="<?php echo $job->ID; ?>" class="btn btn-secondary">
		<i class="fa fa-check"></i><span><?php esc_html_e( 'Applied', 'opaljob' ); ?></span>	
	</a>	
	<?php endif; ?>
<?php else : ?>
<a href="#" data-employer-id="<?php echo $member->ID; ?>" data-job-id="<?php echo $job->ID; ?>" class="btn btn-primary opaljob-need-login">
	<span><?php esc_html_e( 'Apply Now', 'opaljob' ); ?></span>	
</a>	
<?php endif; ?>
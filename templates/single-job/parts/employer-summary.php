<?php global $job; ?>
<?php if( $job->has_employer() ): $member = $job->get_employer(); ?>
<div class="opaljob-member-summary employer-summary">
 	<div class="opal-row">
 		<div class="col-lg-3">
 			<a href="<?php echo $member->get_link(); ?>" class="member-avatar">
 				<img src="<?php echo $member->get_avatar(); ?>">
 			</a>
 		</div>
 		<div class="col-lg-7">
 			<h2><?php echo $job->post_title; ?></h2>
 			<h5><a href="<?php echo $member->get_link(); ?>"><?php echo $member->get_company(); ?></a></h5>
 			<div class="job-address"><?php echo $member->get_address(); ?></div>
 			
			<?php if( $job->islogin_to_view() ): ?>
			<div class="job-salary required-login">
				<span><?php esc_html_e( 'Offerd Salary', 'opaljob' ); ?></span>
				<span class="salary-detail"><?php esc_html_e( 'Login to View Salary', 'opaljob' ); ?></span>
			</div>	
			<?php else : ?>	
			<div class="job-salary">
				<span class="salary-label"><?php esc_html_e( 'Offerd Salary', 'opaljob' ); ?></span>
				<span class="salary-number">
					<span><?php echo $job->get_salary(); ?></span>
					<span><?php echo $job->get_salary_label(); ?></span>
				</span>	
			</div>	
			<?php endif ; ?>	
			<div class="job-meta">
				<span class="job-view"><?php echo $job->get_views(); ?> <?php esc_html_e( 'Views', 'opaljob' ); ?></span> -
				<span class="job-view"><?php echo sprintf( esc_html__( 'Sumission expired Date in %s days', 'opaljob' ) , 4 ); ?></span>
			</div>
 
 		</div>

 		<div class="col-lg-2">
 			<?php opaljob_render_template( 'single-job/parts/apply-button', array('member' => $member, 'job' => $job) ); ?>
 			<?php opaljob_job_render_favorite_button(); ?>
 		</div>
 	</div>	
</div>
<?php endif; ?>
<?php // opaljob_render_template( 'messages/enquiry-form' ); ?>

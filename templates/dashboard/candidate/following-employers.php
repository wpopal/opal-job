<div class="opaljob-dashboard-following">
	<h2><?php esc_html_e( 'Following Employers', 'opaljob' ); ?></h2>
	<div class="dashboard-content">	
		<?php if( $members ): ?>
			<?php foreach( $members as $key => $user_id ): ?>
				<?php $member = opaljob_new_employer_object( $user_id ); ?>
				<div class="member-item">
					 <div class="opal-row has-toggle-remove">
				 		<div class="col-lg-2">
				 			<div class="member-avatar">
					 			<a href="<?php echo $member->get_link(); ?>" class="member-thumb">
					 				<img src="<?php echo $member->get_avatar(); ?>">
					 			</a>
					 			<?php if( $member->is_featured() ): ?>
			                        <div class="member-avatar-label">
			                            <span class="label label-featured" aria-label="<?php esc_html_e('Featured Employer', 'opaljob'); ?>"  title="<?php esc_html_e('Featured Employer', 'opaljob'); ?>">
			                                <samp class="screen-reader-text"><?php esc_html_e( 'Featured', 'opaljob' ); ?></samp>
                                            <i class="fa fa-bolt" aria-hidden="true"></i>
			                            </span>
			                        </div>
			                    <?php endif; ?>


					 		</div>
				 		</div>
				 		<div class="col-lg-7">
				 			<h2>
                                <?php echo $member->get_company(); ?>
                                <?php if( $member->is_trusted() ): ?>
                                    <sup class="trusted-label hint--top" aria-label="<?php esc_html_e('Trusted Employer', 'opaljob'); ?>" title="<?php esc_html_e('Trusted Employer', 'opaljob'); ?>">
                                        <i class="text-primary fa fa-check-circle " aria-hidden="true"></i>
                                    </sup>
                                <?php endif; ?>
                            </h2>
				 			<div class="member-address"><?php echo $member->get_address(); ?></div>
				 		</div>

				 		<div class="col-lg-3">
				 			
				 			<a href="#" class="btn btn-primary job-contact-button"><?php esc_html_e( 'Contact', 'opaljob' ); ?></a>
				 			
				 			<?php opaljob_render_template( 'single-employer/parts/following-button', array('member' => $member) ); ?>

				 		</div>

				 	</div>	
				</div>
			<?php endforeach; ?>	
		<?php else : ?>	

		<?php endif; ?>	
	</div>	
</div>
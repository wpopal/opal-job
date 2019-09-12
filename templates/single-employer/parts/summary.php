<?php global $member;  ?>
<div class="opaljob-member-summary">
	<div class="member-banner">
		<img src="<?php echo $member->get_banner(); ?>">
		<div class="overlay-gray"></div>
	</div>
	<div class="container">
	 	<div class="opal-row">
	 		<div class="col-lg-2">
	 			<div class="member-avatar">
		 			<a href="<?php echo $member->get_link(); ?>" class="member-thumb">
		 				<img src="<?php echo $member->get_avatar(); ?>">
		 			</a>
		 			<?php if( $member->is_featured() ): ?>
                        <div class="member-avatar-label">
                            <span class="label label-featured" aria-label="<?php esc_html_e('Featured Employer', 'opaljob'); ?>"  title="<?php esc_html_e('Featured Employer', 'opaljob'); ?>">
                                <?php echo esc_html_e('Featured','opaljob'); ?>
                            </span>
                        </div>
                    <?php endif; ?>

                    <?php if( $member->is_trusted() ): ?>
                    <span class="trusted-label hint--top" aria-label="<?php esc_html_e('Trusted Employer', 'opaljob'); ?>" title="<?php esc_html_e('Trusted Employer', 'opaljob'); ?>">
                        <i class="fa fa-star"></i>
                    </span>
                    <?php endif; ?> 
		 		</div>	
	 		</div>
	 		<div class="col-lg-7">
	 			<h2><?php echo $member->get_company(); ?></h2>
	 			<div class="member-address"><?php echo $member->get_address(); ?></div>
	 		</div>

	 		<div class="col-lg-3">
	 			
	 			<a href="#" data-target="#opaljob-contact-form-popup" class="opaljob-popup-button btn btn-primary job-contact-button">
	 				<?php esc_html_e( 'Contact', 'opaljob' ); ?>		
	 			</a>
	 			
	 			<?php opaljob_render_template( 'single-employer/parts/following-button', array('member' => $member) ); ?>

	 		</div>

	 	</div>	
	 </div>	
</div>
<?php opaljob_display_employer_contact_form(); ?>

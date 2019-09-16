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
                        <div class="agency-label">
                            <span class="label label-featured" aria-label="<?php esc_html_e('Featured Agency', 'opaljob'); ?>"  title="<?php esc_html_e('Featured Agency', 'opaljob'); ?>">
                                <?php echo esc_html_e('Featured','opaljob'); ?>
                            </span>
                        </div>
                    <?php endif; ?>

                    <?php if( $member->is_trusted() ): ?>
                    <span class="trusted-label hint--top" aria-label="<?php esc_html_e('Trusted Member', 'opaljob'); ?>" title="<?php esc_html_e('Trusted Member', 'opaljob'); ?>">
                        <i class="fa fa-star"></i>
                    </span>
                    <?php endif; ?> 
		 		</div>	
	 		</div>
	 		<div class="col-lg-7">
	 			<h2><?php echo $member->get_name(); ?></h2>
	 			<div class="member-title"><?php echo $member->get_meta( 'job_title' ); ?></div>
	 			<div class="member-address"><?php echo $member->get_address(); ?></div>
	 			<?php opaljob_display_member_social_icons(); ?>
	 		</div>

	 		<div class="col-lg-3">
	 			<a href="#" class="btn btn-primary"><?php esc_html_e( 'Download CV', 'opaljob' ); ?></a>
	 		</div>

	 	</div>	
	 </div>	
</div>


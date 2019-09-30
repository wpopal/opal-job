<?php global $member;  ?>
<div class="opaljob-member-summary">
	<div class="member-banner">
		<img src="<?php echo $member->get_banner(); ?>">
		<div class="overlay-gray"></div>
	</div>
	<div class="container">
	 	<div class="member-summary-inner card-wrap">
	 			<div class="member-avatar">
                <a href="<?php echo $member->get_link(); ?>" class="member-thumb">
                    <img src="<?php echo $member->get_avatar(); ?>">
                </a>
                <?php if( $member->is_featured() ): ?>
                    <div class="agency-label">
                        <span class="label label-featured" aria-label="<?php esc_html_e('Featured Agency', 'opaljob'); ?>"  title="<?php esc_html_e('Featured Agency', 'opaljob'); ?>">
                            <samp class="screen-reader-text"><?php esc_html_e( 'Featured', 'opaljob' ); ?></samp>
                            <i class="fa fa-bolt" aria-hidden="true"></i>
                        </span>
                    </div>
                <?php endif; ?>
	 		</div>
	 		<div class="member-content-wrap card-body">
	 			<h2 class="opaljob-title">
                    <?php echo $member->get_name(); ?>
                    <?php if( $member->is_trusted() ): ?>
                        <sup class="trusted-label hint--top" aria-label="<?php esc_html_e('Trusted Member', 'opaljob'); ?>" title="<?php esc_html_e('Trusted Member', 'opaljob'); ?>">
                            <i class="text-primary fa fa-check-circle " aria-hidden="true"></i>
                        </sup>
                    </span>
                    <?php endif; ?>
                </h2>
                <ul class="list-inline">
                    <li class="member-title list-inline-item"><?php echo $member->get_meta( 'job_title' ); ?></li>
                    <li class="member-address list-inline-item"><?php echo $member->get_address(); ?></li>
                </ul>
	 			<?php opaljob_display_member_social_icons(); ?>

	 		</div>

	 		<div class="member-apply-wrap member-button">
	 			<a href="#" class="btn btn-lg btn-primary"><?php esc_html_e( 'Download CV', 'opaljob' ); ?></a>
	 		</div>

	 	</div>	
	 </div>	
</div>


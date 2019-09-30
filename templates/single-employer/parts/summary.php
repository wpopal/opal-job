<?php 
    global $member;  
    $category = $member->get_category(); 
    $location = $member->get_location();  
?>
<div class="opaljob-member-summary employer-member">
	<div class="member-banner">
		<img class="d-block" src="<?php echo $member->get_banner(); ?>">
		<div class="overlay-gray"></div>
	</div>

 	<div class="member-summary-inner card-wrap">
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

 		<div class="member-content-wrap card-body">
 			<h3 class="opaljob-title">
                <?php echo $member->get_company(); ?>
                <?php if( $member->is_trusted() ): ?>
                    <sup class="trusted-label hint--top" aria-label="<?php esc_html_e('Trusted Member', 'opaljob'); ?>" title="<?php esc_html_e('Trusted Member', 'opaljob'); ?>">
                        <i class="text-primary fa fa-check-circle " aria-hidden="true"></i>
                    </sup>
                <?php endif; ?>
            </h3>
            <ul class="member-content-info list-inline">
                <li class="member-address list-inline-item"><i class="fa fa-map-marker"></i> <?php echo $member->get_address(); ?></li>
                <li class="member-website list-inline-item"><a href="<?php echo $member->web; ?>" rel="nofollow" target="_blank"><?php echo $member->web; ?></a></li>
                <?php if( $category ): ?>
                <li class="member-category list-inline-item"><i class="fa fa-pencil"></i> <?php foreach( $category as $tax ): ?><a href="<?php echo $tax['link']; ?>"><span><?php echo $tax['name']; ?></span></a><?php endforeach; ?></li>
                <?php endif; ?>
                <?php if( $location ): ?>
                <li class="member-location list-inline-item"><i class="fa fa-location-arrow"></i> <span><?php echo $location; ?></span></li>
                <?php endif; ?>
            </ul>
 		</div>

 		<div class="member-apply-wrap member-button">
 			<?php opaljob_render_template( 'single-employer/parts/following-button', array('member' => $member) ); ?>
 		</div>

 	</div>	
 
</div>

<?php global $job; ?>
<?php if( $job->has_employer() ):
    
    $member     = $job->get_employer(); 
    $location   = $job->get_location_tax();
?>

<div class="opaljob-member-summary employer-summary">
 	<div class="member-summary-inner card-wrap">
 		<div class="member-avatar">
 			<a href="<?php echo $member->get_link(); ?>">
 				<img src="<?php echo $member->get_avatar(); ?>">
 			</a>
            <?php opaljob_render_template( 'common/job/featured-label', array('job' => $job) ); ?>
 		</div>
 		<div class="member-content-wrap card-body">
            <?php opaljob_render_template( 'common/job/type-label' ); ?>
 			<h2 class="opaljob-title"><?php echo $job->post_title; ?> <?php esc_html_e( 'At', 'opaljob' ); ?> <a href="<?php echo $member->get_link(); ?>"><?php echo $member->get_company(); ?></a></h2>
            <ul class="member-content-info list-style list-inline">

                <?php if(!empty($job->get_address())) : ?>
                    <li class="job-address"><?php echo $member->get_address(); ?></li>
                <?php endif;?>

                <?php if( $location ): ?>
                <li class="job-location list-inline-item">
                   <i class="fa  fa-map-marker"></i>
                    <?php foreach( $location as $tax ): ?><a href="<?php echo get_term_link( $tax->term_id); ?>">
                        <span><?php echo $tax->name; ?></span>
                    </a><?php endforeach; ?>
                </li>
                <?php endif; ?>

                <?php if( $job->islogin_to_view() ): ?>
                <li class="job-salary required-login list-inline-item">
                    <span><?php esc_html_e( 'Offerd Salary', 'opaljob' ); ?></span>
                    <span class="salary-detail"><?php esc_html_e( 'Login to View Salary', 'opaljob' ); ?></span>
                </li>
                <?php else : ?>
                <li class="job-salary list-inline-item">
                    <span class="salary-label"><?php esc_html_e( 'Offerd Salary:', 'opaljob' ); ?></span>
                    <span class="salary-number">
                        <span><?php echo $job->get_salary(); ?></span>
                        <span><?php echo $job->get_salary_label(); ?></span>
                    </span>
                </li>
                <?php endif ; ?>
                <li class="job-meta list-inline-item">
                    <span class="job-view"><?php echo $job->get_views(); ?> <?php esc_html_e( 'Views', 'opaljob' ); ?></span> -
                    <span class="job-view"><?php echo sprintf( esc_html__( 'Sumission expired Date in %s days', 'opaljob' ) , 4 ); ?></span>
                </li>
            </ul>

 		</div>

 		<div class="member-apply-wrap member-button">
 			<?php opaljob_render_template( 'single-job/parts/apply-button', array('member' => $member, 'job' => $job) ); ?>
 			<?php opaljob_job_render_favorite_button(); ?>
            <?php opaljob_render_share_socials_block(); ?>
 		</div>
 	</div>
</div>
<?php endif; ?>
<?php // opaljob_render_template( 'messages/enquiry-form' ); ?>

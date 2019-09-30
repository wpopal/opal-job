<?php global $job; ?>
<?php do_action( 'opaljob_single_job_content_before' ); ?>
<div class="opaljob-single-content">
	<article id="post-<?php echo $job->ID; ?>" <?php post_class( '', $job->ID ); ?>>
		<div class="opal-row">
			<div class="job-content-main col-lg-8">
				<div class="job-content-sections">
					<?php do_action( 'opaljob_single_job_content_sections' ); ?>
				</div>
			</div>

	 		<div class="job-content-sidebar col-lg-4">
                <div class="sidebar-wrap">
                    <?php do_action( 'opaljob_single_job_content_sidebar' ); ?>
                </div>
			</div>
	 	</div>
	 	<?php do_action( 'opaljob_single_job_inner_content_after' ); ?>
	</article><!-- #post-<?php echo $job->ID; ?> -->
</div>
<?php do_action( 'opaljob_single_job_content_after' ); ?>
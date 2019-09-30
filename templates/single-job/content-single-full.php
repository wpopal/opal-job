<?php global $job; ?>
<?php do_action( 'opaljob_single_job_content_before' ); ?>
<div class="opaljob-single-content">
	<article id="post-<?php echo $job->ID; ?>" <?php post_class( '', $job->ID ); ?>>
		<div class="opal-row">
			<div class="job-content-main col-lg-12"> 
				<header class="entry-header">
					<?php  get_template_part( 'template-parts/header/entry', 'header' ); ?>
				</header>
				
				<div class="job-content-sections">
					<?php do_action( 'opaljob_single_job_content_sections' ); ?>
				</div>
			</div>
	 	</div>
	 	<?php do_action( 'opaljob_single_job_inner_content_after' ); ?>
	</article><!-- #post-<?php echo $job->ID; ?> -->
</div>
<?php do_action( 'opaljob_single_job_content_after' ); ?>
<?php do_action( 'opaljob_single_job_content_before' ); ?>
<div class="opaljob-single-content">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="opal-row">
			<div class="job-content-main col-lg-9"> 
				<header class="entry-header">
					<?php  get_template_part( 'template-parts/header/entry', 'header' ); ?>
				</header>
				
				<div class="job-content-sections">
					<?php do_action( 'opaljob_single_job_content_sections' ); ?>
				</div>
			</div>
			
	 		<div class="job-content-sidebar col-lg-3">
				<?php do_action( 'opaljob_single_job_content_sidebar' ); ?>
			</div>	
	 	</div>

	</article><!-- #post-<?php the_ID(); ?> -->
</div>
<?php do_action( 'opaljob_single_job_content_after' ); ?>
<?php global $member; ?>
 <?php do_action( 'opaljob_single_employer_content_before' ); ?>
<div class="opaljob-single-employer-content container">
	<article id="post-author-<?php echo $employer->ID; ?>" <?php post_class(); ?>>
		<div class="opal-row">
			<div class="job-content-main col-md-8"> 
				<div class="job-content-sections">
					<?php do_action( 'opaljob_single_employer_content_sections' ); ?>
				</div>
			</div>
			
	 		<div class="job-content-sidebar col-md-4">
				<?php do_action( 'opaljob_single_employer_content_sidebar' ); ?>
			</div>	
	 	</div>

	</article>
</div>
<?php do_action( 'opaljob_single_employer_content_after' ); ?>
<?php do_action( 'opaljob_single_comment_employer_form'  ); ?>

 <?php comments_template(); ?>
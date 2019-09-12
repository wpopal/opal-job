<?php global $member; ?>
 <?php do_action( 'opaljob_single_employer_content_before' ); ?>
<div class="opaljob-single-employer-content container">
	<article id="post-author-<?php echo $employer->ID; ?>" <?php post_class(); ?>>
		
		<div class="job-content-main"> 
			<div class="job-content-sections">
				<?php do_action( 'opaljob_single_employer_content_sections' ); ?>
			</div>
		</div>
		
 		<div class="job-content-sidebar">
			<?php do_action( 'opaljob_single_employer_content_sidebar' ); ?>
		</div>	
 	

	</article>
</div>
<?php do_action( 'opaljob_single_employer_content_after' ); ?>
<?php global $member;  ?>
 <?php do_action( 'opaljob_single_candidate_content_before' ); ?>
<div class="opaljob-single-candidate-content">
	<article id="post-author-<?php echo $candidate->ID; ?>" <?php post_class(); ?>>
		<div class="opal-row">
			<div class="job-content-main col-lg-9"> 
				<header class="entry-header">
					<?php echo $member->display_name; ?>
				</header>
				
				<div class="job-content-sections">
					
					<?php do_action( 'opaljob_single_candidate_content_sections' ); ?>
				</div>
			</div>
			
	 		<div class="job-content-sidebar col-lg-3">
				<?php do_action( 'opaljob_single_candidate_content_sidebar' ); ?>
			</div>	
	 	
		</div>	
	</article><!-- #post-<?php the_ID(); ?> -->
</div>
<?php do_action( 'opaljob_single_candidate_content_after' ); ?>
<?php 
	$_layout = $layout;
	$style = $items_per_grid; 
	$items_per_grid = 1;
?>
<div id="opaljob-job-search-view-jobs">
	<div class="job-search-wrapper opal-row">
		<div class="job-search-jobs col-md-4">
			 <div class="opaljob-collection-results">
					 <div class="opaljob-job-listing">
				        <div class="job-listing-wrapper">
					            <?php if( $query->found_posts > 0 ) : ?>
					                <div class="job-listing opal-row-list">
					                    <?php while ( $query->have_posts() ) : $query->the_post(); ?>
					                    <?php  global $job; $job = opaljob_new_job_object ( get_the_ID() ); ?>
					                        <div class="job-items job-quick-view" data-job-id="<?php echo get_the_ID(); ?>">
					                            <?php opaljob_render_template( 'loop/content-job-related'  ); ?>
					                        </div>
					                    <?php endwhile; ?>    
					                </div>  
					            <?php else : ?>
					            <div class="job-no-results">
					                <?php esc_html_e( "Sorry, we have not found any result to show.", "opaljob" ) ; ?>
					            </div>  
					            <?php endif; ?> 
				        </div>
				    </div>  
				</div>	
		</div>	
		<div class="job-search-view-single opaljob-sticky-column col-md-8">
	 	    <?php if( $job_post ): ?>
	 	    <?php global $job; $job = opaljob_new_job_object( $job_post->ID ); opaljob_render_template( 'single-job/content-single-full' ); ?>
	 	    <?php else: ?>
	 	     <?php esc_html_e( "Sorry, we have not found any result to show.", "opaljob" ) ; ?>	
	 	    <?php endif; ?>	
	    </div>    
	</div>
</div>	

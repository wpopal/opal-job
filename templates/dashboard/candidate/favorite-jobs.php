<div class="opaljob-dashboard-mylisting">
	<h2><?php esc_html_e( 'Favorited Job', 'opaljob' ); ?></h2>
	<div class="dashboard-content">	
		<?php if( $loop->have_posts() ): ?>
		<div class="job-listing my-favorite">
		 		<div class="box-content">
					
					<div class="opaljob-rows-group">	
						 
						<?php $cnt=0; while ( $loop->have_posts() ) : $loop->the_post(); global $post; 
							global $job; 

							$job = opaljob_new_job_object ( get_the_ID() );
							$member = $job->get_employer(); 
						?>
							<div class="opal-row job-item">
				 				<div class="col-lg-1 col-md-1">
			                    	<a href="<?php echo $member->get_link(); ?>" class="member-avatar">
						 				<img src="<?php echo $member->get_avatar(); ?>">
						 			</a>
			                	</div>
			                	<div class="col-lg-6 col-md-6 job-info">
			                    	<h5><a href="<?php echo $job->get_link(); ?>"><?php echo $job->post_title; ?></a></h5>
			                    	<div class="job-summary">
			                    		<div><?php echo $member->get_company(); ?></div>
				                    	<div class="job-salary">
											<span class="salary-label"><?php esc_html_e( 'Offerd Salary', 'opaljob' ); ?></span>
											<span class="salary-number">
												<span><?php echo $job->get_salary(); ?></span>
												<span><?php echo $job->get_salary_label(); ?></span>
											</span>	
										</div>
									</div>	
			                	</div>
			                	<div class="col-lg-2 col-md-2 job-expired">
			                    	<p class="job-sub-title"><?php echo esc_html_e( 'Job Expired', 'opaljob' ); ?></p>
			                    	<p></p>
			                	</div>
			                	<div class="col-lg-2 col-md-2 job-apply">
			                    	<?php opaljob_render_template( 'single-job/parts/apply-button', array('member' => $member, 'job' => $job) ); ?>
			                	</div>
			                	<div class="col-lg-1 col-md-1 job-action">
			                    	<a href="" class="job-remove-favorite" data-job-id="<?php echo $job->ID; ?>">
			                    		<?php echo esc_html_e( 'Remove', 'opaljob' ); ?>		
			                    	</a>
			                	</div>
							</div>
						<?php endwhile; ?>
						 
					</div>	
					<?php // opaljob_pagination( $loop->max_num_pages ); ?>
				</div>	
		</div>
		<?php else : ?>
			<div class="opaljob-box">	
			 	<div class="box-content">
				 	<div class="opaljob-message">
				 		<h3>No Item In Favorite</h3>
						<p><?php _e( 'You have not added any job as favorite.', 'opaljob' ) ;?></p>
					</div>
				</div>	
			</div>	
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
	</div>
</div>		
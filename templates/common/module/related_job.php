<?php if( $query->found_posts > 0 ) : ?>
<div class="opaljob-panel panel-related-job">
	<div class="panel-heading"><h4><?php esc_html_e( 'Related Jobs', 'opaljob' ); ?></h4></div>
	<div class="panel-body">
		<div class="opal-row">
		    <?php while ( $query->have_posts() ) : $query->the_post(); ?>
	        <?php  global $job; $job = opaljob_new_job_object ( get_the_ID() ); ?>
	            <div class="job-item col-md-6" data-job-id="<?php echo get_the_ID(); ?>">
	                <?php opaljob_render_template( 'loop/content-job-related' ); ?>
	            </div>
	        <?php endwhile; ?>    
	    </div>    
	</div>
</div>
<?php endif; ?>
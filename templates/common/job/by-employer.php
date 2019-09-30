<?php 
	global $member;	
?>
<div class="opaljob-panel-wrap">
	<div class="panel-heading"><h4><?php echo sprintf( esc_html__( '%s Jobs are opening', 'opaljob' ), $founds ); ?></h4></div>
	<div class="panel-body">
		<?php 
			foreach( $jobs as $job ): 
			$location   = $job->get_location_tax();
		?>
			<div class="job-short-listing">
				<h5><a href="<?php echo $job->get_link(); ?>"><?php echo $job->post_title; ?></a></h5>
				<div class="job-meta">
					<ul class="list-style list-inline">
						<li class="job-salary"><?php echo $job->get_salary(); ?></li>
						<?php if( $location ): ?>
		                <li class="job-location">
		                   <i class="fa  fa-map-marker"></i>
		                    <?php foreach( $location as $tax ): ?><a href="<?php echo get_term_link( $tax->term_id); ?>">
		                        <span><?php echo $tax->name; ?></span>
		                    </a><?php endforeach; ?>
		                </li>
		                <?php endif; ?>
						<li><?php echo $job->get_posted_ago(); ?></li>
					</ul>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>
 
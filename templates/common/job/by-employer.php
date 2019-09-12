<?php 
	global $member;	
	$map    = $member->get_map();
	
?>
 
<div class="opaljob-panel panel-section-gallery">
	<div class="panel-heading"><h4><?php echo sprintf( esc_html__( '%s Jobs are opening', 'opaljob' ), $founds ); ?></h4></div>
	<div class="panel-body">
		<?php foreach( $jobs as $job ): ?>
			<div class="job-item">
				<h5><a href="<?php echo $job->get_link(); ?>"><?php echo $job->post_title; ?></a></h5>
				<div class="job-meta">
					<ul class="list-inline">
						<li><?php echo $job->get_updated_date(); ?></li>
					</ul>
				</div>	
			</div>	
		<?php endforeach; ?> 
	</div>
</div>
 
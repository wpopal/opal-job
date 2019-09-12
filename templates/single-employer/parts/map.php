<?php 
	global $member;	
	$map    = $member->get_map();
	
?>
<?php  if ( $map ): ?>
<div class="opaljob-panel panel-section-map"  id="employer-map">
	<div class="panel-heading"><h4><?php esc_html_e( 'Address', 'opaljob' ); ?></h4></div>
	<div class="panel-body">
		   
	</div>
</div>
<?php endif; ?>
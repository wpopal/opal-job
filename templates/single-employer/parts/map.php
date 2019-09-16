<?php 
	global $member;	
	$maps    = $member->get_map();
	$id 	 = time();
?>
<?php  if ( $maps ): ?>
<div class="opaljob-panel panel-section-map"  id="employer-map">
	<div class="panel-heading"><h4><?php esc_html_e( 'Address', 'opaljob' ); ?></h4></div>
	<div class="panel-body">
	    <div  id="job-map<?php echo esc_attr($id); ?>" class="job-preview-map"  style="height:500px" 
	    	data-latitude="<?php echo( isset( $maps['latitude'] ) ? $maps['latitude'] : '' ); ?>"
            data-longitude="<?php echo( isset( $maps['longitude'] ) ? $maps['longitude'] : '' ); ?>" 
            data-icon="<?php echo esc_url( OPALJOB_CLUSTER_ICON_URL ); ?>"></div>

	</div>
</div>
<?php endif; ?>
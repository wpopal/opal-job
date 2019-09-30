<?php
global $job;  
$maps = $job->get_map();


if ( !empty($maps) ):
$id = time();
?>
<div class="opaljob-panel panel-section-tags"  id="job-map-location">
	<div class="panel-heading"><h4><?php esc_html_e( 'Map Location', 'opaljob' ); ?></h4></div>
	<div class="panel-body">
	 	<div class="job-preview job-preview-custom-size">

		    <div  id="job-map<?php echo esc_attr($id); ?>" class="job-preview-map" style="height:300px;"  data-latitude="<?php echo (isset($maps['latitude']) ? $maps['latitude'] : ''); ?>" data-longitude="<?php echo (isset($maps['longitude']) ? $maps['longitude'] : ''); ?>" data-icon="<?php echo esc_url(OPALJOB_CLUSTER_ICON_URL);?>"></div> 
		     
		</div> 
	</div>
</div>
<?php endif;?>
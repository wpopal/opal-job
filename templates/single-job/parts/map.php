<?php
global $job;
$maps = $job->get_map();

if ( !empty($maps) ):
$id = time();
?>
<div class="job-preview job-preview-custom-size">
 
    <div  id="job-map<?php echo esc_attr($id); ?>" class="job-preview-map"  data-latitude="<?php echo (isset($maps['latitude']) ? $maps['latitude'] : ''); ?>" data-longitude="<?php echo (isset($maps['longitude']) ? $maps['longitude'] : ''); ?>" data-icon="<?php echo esc_url(OPALJOB_CLUSTER_ICON_URL);?>"></div> 
     
 </div> 
<?php endif;?>

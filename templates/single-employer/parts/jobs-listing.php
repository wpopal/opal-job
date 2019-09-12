<?php 
	global $member;	
	$gallery    = $member->get_gallery();	
?>
<div class="opaljob-panel panel-section-gallery"  id="employer-jobs">
<?php do_action( "opaljob/job/listing/employer", $member->ID ); ?>
</div>
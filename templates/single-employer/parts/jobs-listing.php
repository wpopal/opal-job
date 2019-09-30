<?php 
	global $member;	
?>
<div class="panel-section-employer"  id="employer-jobs">
<?php do_action( "opaljob/job/listing/employer", $member->ID ); ?>

</div>
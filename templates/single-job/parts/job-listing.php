<?php global $job;  if( $job->has_employer() ):  
$member     = $job->get_employer();  ?>
<div class="panel-section-jobs"  id="employer-jobs">
<?php do_action( "opaljob/job/listing/employer", $member->ID ); ?>
</div>
<?php endif;  ?>
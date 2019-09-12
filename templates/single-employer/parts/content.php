<?php global $member;	 ?>
<div class="opaljob-panel panel-section-video" id="employer-information">
	<div class="panel-heading"><h4><?php echo sprintf( esc_html__( 'About %s', 'opaljob' ), $member->get_company() ); ?></h4></div>
	<div class="panel-body">
		<?php echo $member->description; ?>
	</div>
</div>
 
<?php global $member; ?>
<div class="opaljob-panel panel-section-gallery"  id="employer-gallery">
	<div class="panel-heading"><h4><?php echo sprintf( esc_html__( 'About %s', 'opaljob' ) , $member->display_name ); ?></h4></div>
	<div class="panel-body">
		<div class="entry-content">
			<?php echo $member->description; ?>
		</div>
	</div>
</div>
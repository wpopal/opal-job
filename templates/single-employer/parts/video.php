<?php 
	global $member;	
	$video    = $member->get_video_url();
	
?>
<?php  if ( $video ): ?>
<div class="opaljob-panel panel-section-video">
	<div class="panel-heading"><h4><?php esc_html_e( 'Video', 'opaljob' ); ?></h4></div>
	<div class="panel-body">
		<?php echo wp_oembed_get( $video ); ?>
	</div>
</div>
<?php endif; ?>
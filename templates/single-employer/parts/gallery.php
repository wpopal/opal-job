<?php 
	global $member;	
	$gallery    = $member->get_gallery();
?>
<?php  if ( $gallery ): ?>
<div class="opaljob-panel panel-section-gallery"  id="employer-gallery">
	<div class="panel-heading"><h4><?php esc_html_e( 'Gallery', 'opaljob' ); ?></h4></div>
	<div class="panel-body">
		 <div class="member-gallery-grid opal-row">
			<?php foreach ( $gallery as $key => $src ): ?>
	            <div class="col-lg-4 gallery-item"><a href="<?php echo $src; ?>" style="background-image:url('<?php echo $src; ?>')"></a></div>
	        <?php endforeach; ?>
	     </div>   
	</div>
</div>
<?php endif; ?>
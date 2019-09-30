<?php 
	$_layout = $layout;
	$style = $items_per_grid; 
	 
?>
<div class="opaljob-member-listing employer-listing">
	<div class="member-listing-wrapper">
		<?php if( $count > 0 ) : ?>
 
			<div class="member-listing opal-row">
				<?php foreach( $members as $_member ): global $member; $member = $_member  ?>
					<div class="member-item col-md-12">
						<?php opaljob_render_template( 'loop/'.$_layout  ); ?>
					</div>
				<?php endforeach; ?>	
			</div>	
		<?php else : ?>	 
		<div class="member-no-results">
			<?php esc_html_e( "Sorry, we have not found any result to show.", "opaljob" ) ; ?>
		</div>	
		<?php endif; ?>	
	</div>
</div>	

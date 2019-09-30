<?php 
	$_layout = $layout;
	$style = $items_per_grid; 
	if( $items_per_grid > 1 ) {

	}
?>
<div class="opaljob-job-listing">
	<div class="job-listing-wrapper">
		<?php if( $count > 0 ) : ?>
			<?php if( $items_per_grid > 1 ): ?>
			<div class="job-listing opal-row">
				<?php foreach( $jobs as $_job ): global $job; $job = $_job; ?>
					<div class="job-items col-md-12">
						<?php opaljob_render_template( 'loop/'.$_layout  ); ?>
					</div>
				<?php endforeach; ?>	
			</div>	
			<?php else : ?>
				<div class="job-listing opal-row-list">
				<?php foreach( $jobs as $_job ): global $job; $job = $_job; ?>
					<div class="job-items">
						<?php opaljob_render_template( 'loop/'.$_layout  ); ?>
					</div>
				<?php endforeach; ?>	
			</div>	
			<?php endif; ?>	
		<?php else : ?>
		<div class="job-no-results">
			<?php esc_html_e( "Sorry, we have not found any result to show.", "opaljob" ) ; ?>
		</div>	
		<?php endif; ?>	
	</div>
</div>	

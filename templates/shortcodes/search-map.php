<?php 
	$_layout = $layout;
	$style = $items_per_grid; 
	$items_per_grid = 1;
?>
<div id="opaljob-job-search-map">
	<div class="job-search-map-wrapper opal-row">
		<div class="job-search-sidebar col-md-4">
			<div class="opaljob-tab">
				<div class="job-tab-head">
					<a href="#"><?php esc_html_e( 'Filters', 'opaljob' ); ?></a>
				</div>
				<?php echo opaljob_render_template( 'search-form/horizontal-v1' ); ?>	 
			</div>	

			<div class="opaljob-collection-results">
				<?php oplajob_render_search_map_jobs( $query, $_layout ); ?>
			</div>	
		</div>	
		<div class="col-md-8">
	 	    <div class="job-search-map-preview" id="opaljob-search-map-preview" style="height:800px;">
	                <div class="mapPlaceholder">
	                	<span class="fa fa-spin fa-spinner"></span> <?php esc_html_e( 'Loading map...', 'opaljob' ); ?>
	                    <div class="sk-folding-cube">
	                        <div class="sk-cube1 sk-cube"></div>
	                        <div class="sk-cube2 sk-cube"></div>
	                        <div class="sk-cube4 sk-cube"></div>
	                        <div class="sk-cube3 sk-cube"></div>
	                    </div>
	                </div>
	        </div> 
	    </div>    
	</div>
</div>	

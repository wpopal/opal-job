<div class="opaljob-horizontal-form v1">
	<div class="inner">
		<form action="<?php echo opaljob_get_search_page_uri();  ?>" class="opaljob-form-search-jobs form-hide-label" method="get">
			<div class="opal-row">
				<div class="form-group col-md-6">
					<?php opaljob_render_template( 'search-form/fields/search-text' ); ?>
					<div><?php opaljob_get_search_keyword_suggestion(); ?></div>	
				</div>
				<div class="form-group col-md-4">		
					<?php opaljob_render_template( 'search-form/fields/location' ); ?>
				</div>	
				<div class="form-group col-md-2">		
					<?php opaljob_render_template( 'search-form/fields/button-submit' ); ?>
				</div>		
			</div>	 
		</form>		
	</div>
</div>	
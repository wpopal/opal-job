<div class="opaljob-panel panel-job-meta">
	<div class="panel-heading"><h4><?php esc_html_e( 'Job Detail', 'opaljob' ); ?></h4></div>
	<div class="panel-body"><ul class="meta-list-inner">
		<?php foreach( $metas as $meta ): ?>
			<li class="meta-item d-flex">
				<div class="meta-icon icon-md">
					<i class="<?php echo $meta['icon'];?>"></i>
				</div>	
				<div class="meta-content ml-3">
					<h6 class="meta-label"><?php echo $meta['label']; ?></h6>
					<p class="meta-text"><?php echo $meta['content']; ?></p>
				</div>
			</li>
		<?php endforeach; ?>	
	</ul></div>	
</div>
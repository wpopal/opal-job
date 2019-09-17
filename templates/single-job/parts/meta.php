<div class="job-meta-list"><ul class="meta-list-inner">
	<?php foreach( $metas as $meta ): ?>
		<li class="meta-item">
			<div class="meta-icon">
				<i class="<?php echo $meta['icon'];?>"></i>
			</div>	
			<div class="meta-content">
				<span class="meta-label"><?php echo $meta['label']; ?></span>
				<span class="meta-text"><?php echo $meta['content']; ?></span>
			</div>
		</li>
	<?php endforeach; ?>	
</ul></div>	
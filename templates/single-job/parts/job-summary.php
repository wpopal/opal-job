<div class="job-summary">
	<?php foreach( $summaries as $summary ): ?>
	<div class="summary-item">
		<div class="summary-icon"><i class="<?php echo  $summary['icon']; ?>"></i></div>
		<div class="summary-content">
			<div><?php echo  $summary['label']; ?></div>
			<strong><?php echo  $summary['value']; ?></strong>
		</div>
	</div>
	<?php endforeach; ?>
</div>	
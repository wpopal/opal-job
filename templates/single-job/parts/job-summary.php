<?php 
	
	$summaries = array();
    $summaries[] =  array(
                'icon'   => 'fa fa-gear',
                'label'  => esc_html__( "Date Posted", "opaljob" ),
                'value'  => '17/12/8888'
    );

    $summaries[] = array(
                'icon'   => 'fa fa-gear',
                'label'  => esc_html__( "Date Posted", "opaljob" ),
                'value'  => '17/12/8888'
    );

    $summaries[] = array(
                'icon'   => 'fa fa-gear',
                'label'  => esc_html__( "Date Posted", "opaljob" ),
                'value'  => '17/12/8888'
    );

    $summaries[] = array(
                'icon'   => 'fa fa-gear',
                'label'  => esc_html__( "Date Posted", "opaljob" ),
                'value'  => '17/12/8888'
    );
?>
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
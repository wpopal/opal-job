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
<div class="opaljob-panel panel-job-summary">
    <div class="panel-heading"><h4><?php echo esc_html__('Job Detail')?></h4></div>
    <div class="panel-body">

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
</div>
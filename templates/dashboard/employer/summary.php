<div class="opaljob-dashboard-summary">
	<h2 class="page-title"><?php esc_html_e( 'Dashboard', 'opaljob' ); ?></h2>
	<div class="dashboard-content">	
		<div class="opal-row">	
			<?php do_action( 'opaljob_dashboard_employer_summary_top' ); ?>
		</div>

		<div class="opal-row mt-4">
			<div class="job-middle-left col-md-7">
				<?php do_action( 'opaljob_dashboard_employer_summary_middle_left' ); ?>
			</div>
			<div class="job-middle-right col-md-5">
				<?php do_action( 'opaljob_dashboard_employer_summary_middle_right' ); ?>
			</div>
		</div>

		<div class="opal-row">
			 <?php do_action( 'opaljob_dashboard_employer_summary_bottom' ); ?>
		</div>
	</div>	
</div>
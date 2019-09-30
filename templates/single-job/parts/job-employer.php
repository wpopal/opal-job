<?php global $job, $member; if( $job->has_employer() ):  ?>
<?php $member = $job->get_employer(); ?>
<div class="job-member-info">
	<div class="opal-row">
		<div class="col-md-8">
			<div class="opaljob-panel panel-section-info" id="employer-information">
				<div class="panel-heading"><h4><?php echo sprintf( esc_html__( 'About %s', 'opaljob' ), $member->get_company() ); ?></h4></div>
				<div class="panel-body">
					<?php echo $member->description; ?>
					<p>
						<a href="<?php echo $member->get_link(); ?>"><?php echo sprintf( esc_html__( 'More about %s', 'opaljob' ), $member->get_company() ); ?></a>
					</p>
				</div>
			</div>
		</div>
		<div class="col-md-4"><?php opaljob_single_employer_meta_list(); ?></div>
	</div>	
</div>	
<?php endif ; ?>	
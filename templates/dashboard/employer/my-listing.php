<div class="opaljob-dashboard-mylisting">
	<h2><?php esc_html_e( 'My Listing', 'opaljob' ); ?></h2>
	<div class="dashboard-content">	
		<table class="table table-hover">
			<thead>
				<tr>
					<td width="40%"><?php esc_html_e( 'Name', 'opaljob' ); ?></td>
					<td><?php esc_html_e( 'Status', 'opaljob' ); ?></td>
					<td><?php esc_html_e( 'Applicants', 'opaljob' ); ?></td>
					<td><?php esc_html_e( 'Actions', 'opaljob' ); ?></td>
				</tr>	
			</thead>
			<tbody>
			<?php foreach( $jobs as $job ): ?>
				<tr class="job-item">
					<td>
						<h4><a href="<?php echo $job->get_link(); ?>"><?php echo $job->post_title; ?></a></h4>	
						<ul class="job-detail text-muted">
							<li>
								<span><?php esc_html_e( 'Created', 'opaljob' ); ?></span>:
								<span><?php echo $job->get_post_date(); ?></span>
							</li>
							<li>
								<span><?php esc_html_e( 'Updated', 'opaljob' ); ?></span>:
								<span><?php echo $job->get_post_date(); ?></span>
							</li>
						</ul>
					</td>
					<td>
						<span class="badge badge-success badge-label-<?php echo $job->post_status;?>">
							<?php echo $job->status_label();?>		
						</span>
					</td>
					<td>
						<a href="#">1 <?php esc_html_e( 'Applicant(s)', 'opaljob' ); ?></a>
					</td>	
					<td>
						<div class="button-actions">
							<ul class="inline-list">
								<li>
									<a class="btn btn-primary btn-sm" href="<?php echo $job->get_link_edit(); ?>">
										<i class="fa fa-pencil"></i>
									</a>
									<a class="btn btn-danger btn-sm" href="<?php echo $job->get_link(); ?>">
										<i class="fa fa-trash"></i>
									</a>
								</li>
							</ul>	
						</div>

					</td>
				</tr>
			<?php endforeach; ?>	
			</tbody>
		</table>	
	</div>
</div>	
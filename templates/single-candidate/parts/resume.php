<?php
	global $member; 

	$resume_education  	   = $member->get_resume_education( ); 
	$resume_award 	   	   = $member->get_resume_award( ); 
	$resume_experience 	   = $member->get_resume_experience( ); 
	$resume_skill 	   	   = $member->get_resume_skill( ); 
	$resume_portfolio 	   = $member->get_resume_portfolio( );

//	echo '<PRe>' . print_r( $resume_experience ,1 );die; 
?>
<div class="opaljob-panel panel-section-gallery"  id="employer-gallery">
	
	<div class="panel-body">
		
		<?php if( $resume_education ) : ?> 
		<div class="panel-resume-education">
			<h4><?php esc_html_e( 'Education' , 'opaljob' );?></h4>
			<ul class="list-timelife">
				<?php foreach ( $resume_education as $item ) : 

					$name 		 	 = $member->get_field_name( 'name' ); 
					$start_date 	 = $member->get_field_name( 'start_date' );
					$end_date 		 = $member->get_field_name( 'end_date' );
					$academy 		 = $member->get_field_name( 'academy' );

					$args = array(
						$name 		=> '',
						$start_date => '',
						$end_date	=> '',
						$academy	=> ''
					);

					$item = array_merge( $args, $item );
				?>
				<li>
					<div class="item-head"><?php echo $item["_name"]; ?> <span><?php echo $item[$start_date] . ' - ' . $item[$end_date]; ?></span></div>
					<div class="item-description"><?php echo $item[$academy]; ?></div>
				</li> 
				<?php endforeach;  ?>
			</ul>	
 			<?php ?>
		</div>
		<?php endif; ?>

		<?php if( $resume_award ) : ?> 
		<div class="panel-resume-award">
			<h4><?php esc_html_e( 'Award' , 'opaljob' );?></h4>
			<ul class="list-timelife">
				<?php foreach ( $resume_award as $item ) : 

					$name 		 = $member->get_field_name( 'name' );
					$year 		 = $member->get_field_name( 'year' );
					$description = $member->get_field_name( 'description' );
					$args = array(
						$name => '',
						$year => '',
						$description => ''
					);
					$item = array_merge( $args, $item );
				?>
				<li>
					<div class="item-head"><?php echo $item[$name]; ?> <span><?php echo $item[$year]; ?></span></div>
					<div class="item-description"><?php echo $item[$description]; ?></div>
				</li> 
				<?php endforeach; ?>
			</ul>	
 			<?php ?>
		</div>
		<?php endif; ?>

		<?php if( $resume_experience ) : ?> 
		<div class="panel-resume-experience">
			<h4><?php esc_html_e( 'Experience' , 'opaljob' );?></h4>
			<ul class="list-timelife">
				<?php foreach ( $resume_experience as $item ) : 

					$name 		 	 = $member->get_field_name( 'name' ); 
					$start_date 	 = $member->get_field_name( 'start_date' );
					$end_date 		 = $member->get_field_name( 'end_date' );
					$academy 		 = $member->get_field_name( 'academy' );

					$args = array(
						$name 		=> '',
						$start_date => '',
						$end_date	=> '',
						$academy	=> ''
					);

					$item = array_merge( $args, $item );
				?>
				<li>
					<div class="item-head"><?php echo $item["_name"]; ?> <span><?php echo $item[$start_date] . ' - ' . $item[$end_date]; ?></span></div>
					<div class="item-description"><?php echo $item[$academy]; ?></div>
				</li> 
				<?php endforeach;  ?>
			</ul>	
 			<?php ?>
		</div>
		<?php endif; ?>

	</div>
</div>
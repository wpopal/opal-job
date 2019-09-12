
<a href="#" class="btn btn-info job-following-button" data-employer-id="<?php echo $member->ID;?>">
	<?php echo sprintf( esc_html__( '%s Followers', 'opaljob' ), $member->get_count_followers() ); ?>		
</a>
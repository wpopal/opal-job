<?php global $member; ?>
<h4><?php echo sprintf( esc_html__( 'About %s', 'opaljob' ) , $member->display_name ); ?></h4>
<div class="entry-content">
	<?php echo $member->description; ?>
</div>
<?php global $member;	 ?>
<div class="opaljob-panel panel-section-info" id="employer-information">
	<div class="panel-heading"><h4><?php echo sprintf( esc_html__( 'About %s', 'opaljob' ), $member->get_company() ); ?></h4></div>
	<div class="panel-body">
		<?php echo $member->description; ?>
	</div>
</div>
<?php 
	$tags = $member->get_tags();
	if( $tags ):
?> 
<div class="opaljob-panel panel-section-tags"  id="employer-tags">
	<div class="panel-heading"><h4><?php esc_html_e( 'Skill Tags', 'opaljob' ); ?></h4></div>
	<div class="panel-body">
		 <div class="member-skill-tags skill-tags">
             <?php foreach ( $tags as $tax ): ?>
                 <a href="<?php echo $tax['link']; ?>" class="tag-item btn btn-sm btn-outline-dark">
                    <?php echo $tax['name']; ?>
                 </a>
             <?php endforeach; ?>
	     </div>
	</div>
</div>
<?php endif; ?>
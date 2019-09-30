<?php 
	global $job; 
	$tags = $job->get_tags();
	if( $tags ):
?> 
<div class="opaljob-panel panel-section-tags"  id="job-tags">
	<div class="panel-heading"><h4><?php esc_html_e( 'Skill Tags', 'opaljob' ); ?></h4></div>
	<div class="panel-body">
		 <div class="skill-tags">
             <?php foreach ( $tags as $tax ): ?>
                 <a href="<?php echo get_term_link( $tax->term_id ); ?>" class="tag-item btn btn-sm btn-outline-dark type-item <?php echo $tax->slug; ?>">
                     <?php echo $tax->name; ?>
                 </a>
             <?php endforeach; ?>
	     </div>
	</div>
</div>
<?php endif; ?>
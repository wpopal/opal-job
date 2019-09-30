<?php global $job; $types = $job->get_types_tax(); if( $types ): ?>
<div class="job-types">
    <?php foreach( $types as $type ): ?>
        <a href="<?php echo get_term_link( $type->term_id ); ?>" class="btn btn-sm type-item <?php echo $type->slug; ?>"><?php echo $type->name; ?></a>
    <?php endforeach; ?>    
</div> 
<?php endif; ?>
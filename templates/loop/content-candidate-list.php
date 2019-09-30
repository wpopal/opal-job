<?php 
    global $member;

    $specialism = $member->get_specialism(); 
    $location = $member->get_location();  
?>
<article  class="member-list-style" data-id="job-<?php echo $member->ID; ?>">
    <div class="card-wrap">
        <div class="member-avatar card-logo">
            <a href="<?php echo $member->get_link(); ?>" class="member-thumb">
                <img src="<?php echo $member->get_avatar(); ?>">
            </a>
            <?php if( $member->is_featured() ): ?>
                <div class="agency-label">
                    <span class="label label-featured" aria-label="<?php esc_html_e('Featured Agency', 'opaljob'); ?>"  title="<?php esc_html_e('Featured Agency', 'opaljob'); ?>">
                        <samp class="screen-reader-text"><?php esc_html_e( 'Featured', 'opaljob' ); ?></samp>
                        <i class="fa fa-bolt" aria-hidden="true"></i>
                    </span>
                </div>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <h4>
                <?php echo $member->get_name(); ?>
                <?php if( $member->is_trusted() ): ?>
                    <sup class="trusted-label hint--top" aria-label="<?php esc_html_e('Trusted Member', 'opaljob'); ?>" title="<?php esc_html_e('Trusted Member', 'opaljob'); ?>">
                        <i class="text-primary fa fa-check-circle " aria-hidden="true"></i>
                    </sup>
                <?php endif; ?>
            </h4>
            <ul class="member-content-info list-style list-inline">

                <?php if( $specialism ): ?>
                <li class="member-specialism">
                    <i class="fa fa-pencil"></i> <?php foreach( $specialism as $tax ): ?> <a href="<?php echo $tax['link']; ?>"><span><?php echo $tax['name']; ?></span></a> <?php endforeach; ?>
                </li>
                <?php endif; ?>
                <?php if( $location ): ?>
                <li class="member-location"><i class="fa fa-location-arrow"></i> <span><?php echo $location; ?></span></li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="member-right">
            <?php echo opaljob_favorite_candidate_button( $member->ID ); ?>
        </div>    

    </div>
    <!-- .entry-header -->
</article><!-- #post-## -->
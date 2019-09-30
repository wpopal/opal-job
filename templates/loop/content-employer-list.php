<?php
    global $member;
    $category = $member->get_category();
    $location = $member->get_location();
?>
<article  class="member-list-style" data-id="job-<?php echo $member->ID; ?>">
        <div class="card-wrap">
            <?php if( $member->is_featured() ): ?>
                <div class="agency-label">
                        <span class="label label-featured" aria-label="<?php esc_html_e('Featured Agency', 'opaljob'); ?>"  title="<?php esc_html_e('Featured Agency', 'opaljob'); ?>">
                            <samp class="screen-reader-text"><?php esc_html_e( 'Featured', 'opaljob' ); ?></samp>
                            <i class="fa fa-bolt" aria-hidden="true"></i>
                        </span>
                </div>
            <?php endif; ?>
            <div class="member-avatar card-logo">
                <a href="<?php echo $member->get_link(); ?>" class="member-thumb">
                    <img src="<?php echo $member->get_avatar(); ?>">
                </a>
            </div>
            <div class="card-body">
                <h4>
                    <a href="<?php echo $member->get_link(); ?>" class="member-thumb">
                        <?php echo $member->get_name(); ?>
                    </a>
                    <?php if( $member->is_trusted() ): ?>
                        <sup class="trusted-label hint--top" aria-label="<?php esc_html_e('Trusted Member', 'opaljob'); ?>" title="<?php esc_html_e('Trusted Member', 'opaljob'); ?>">
                            <i class="text-primary fa fa-check-circle " aria-hidden="true"></i>
                        </sup>
                    <?php endif; ?>
                </h4>
                <ul class="member-content-info list-style list-inline">
                    <li class="member-address"><i class="fa fa-map-marker"></i> <?php echo $member->get_address(); ?></li>
                    <li class="member-website"><a href="<?php echo $member->web; ?>" rel="nofollow" target="_blank"><?php echo $member->web; ?></a></li>
                    <?php if( $category ): ?>
                    <li class="member-category"><i class="fa fa-pencil"></i> <?php foreach( $category as $tax ): ?><a href="<?php echo $tax['link']; ?>"><span><?php echo $tax['name']; ?></span></a><?php endforeach; ?></li>
                    <?php endif; ?>
                    <?php if( $location ): ?>
                    <li class="member-location"><i class="fa fa-location-arrow"></i> <span><?php echo $location; ?></span></li>
                    <?php endif; ?>
                </ul>
            </div>

        <div class="member-right">
            <a href="<?php echo $member->get_link(); ?>" class="btn btn-primary "><?php echo sprintf( esc_html__('%s Open Jobs', 'opaljob'), $member->get_count_jobs() ); ?></a>
        </div>
    </div><!-- .entry-header -->
</article><!-- #post-## -->
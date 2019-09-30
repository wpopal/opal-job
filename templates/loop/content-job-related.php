<?php
    global $job;

?>
<article  class="job-list-related" data-id="job-<?php echo $job->ID; ?>">
    <header class="entry-header">
        <div class="card-wrap">
            <div class="member-avatar card-logo">
                <a href="<?php echo $job->get_link(); ?>">
                    <img src="<?php echo $job->get_employer_avatar(); ?>">
                </a>
            </div>
            <div class="card-body">
                <?php opaljob_render_template( 'common/job/type-label' ); ?>
                <h4><a href="<?php echo $job->get_link(); ?>"><?php echo $job->post_title;  ?></a></h4>
            </div>
        </div>
        <?php if( $job->is_featured() == 'on' ): ?>
        <div class="job-featured">
                <span class="label label-featured" aria-label="<?php esc_attr_e( 'Featured', 'opaljob' ); ?>" title="<?php esc_attr_e( 'Featured', 'opaljob' ); ?>">
                    <samp class="screen-reader-text"><?php esc_html_e( 'Featured', 'opaljob' ); ?></samp>
                    <i class="fa fa-bolt" aria-hidden="true"></i>
                </span>
        </div>
        <?php endif; ?>
    </header>
</article><!-- #post-## -->
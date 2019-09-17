<?php 
global $member;
?>
<article  class="candidate-list-style" data-id="job-<?php echo $job->ID; ?>">

    <header class="entry-header">
        <div class="opal-row">
            <div class="col-md-6">
              <div class="member-avatar">
                    <a href="<?php echo $member->get_link(); ?>" class="member-thumb">
                        <img src="<?php echo $member->get_avatar(); ?>">
                    </a>
                    <?php if( $member->is_featured() ): ?>
                        <div class="agency-label">
                            <span class="label label-featured" aria-label="<?php esc_html_e('Featured Agency', 'opaljob'); ?>"  title="<?php esc_html_e('Featured Agency', 'opaljob'); ?>">
                                <?php echo esc_html_e('Featured','opaljob'); ?>
                            </span>
                        </div>
                    <?php endif; ?>

                    <?php if( $member->is_trusted() ): ?>
                    <span class="trusted-label hint--top" aria-label="<?php esc_html_e('Trusted Member', 'opaljob'); ?>" title="<?php esc_html_e('Trusted Member', 'opaljob'); ?>">
                        <i class="fa fa-star"></i>
                    </span>
                    <?php endif; ?> 
                </div>  

            </div>
            <div class="col-md-2">
                <div class="job-meta-card">
                    <span class="meta-label"><?php esc_html_e( 'Location', 'opaljob' ); ?></span>
                    <span class="meta-content"><?php esc_html_e( 'Newyork', 'opaljob' ); ?></span>
                </div>
            </div>    
            <div class="col-md-3">
                <span class="meta-label"><?php esc_html_e( 'Salary', 'opaljob' ); ?></span>
                <span class="meta-content"><?php esc_html_e( 'Login to view', 'opaljob' ); ?></span>
            </div>    
        </div>
    </header>
    <!-- .entry-header -->
</article><!-- #post-## -->
<?php 
global $job;
?>
<article  class="job-grid-style" data-id="job-<?php echo $job->ID; ?>">

    <header class="entry-header">
        <div class="opal-row">
            <div class="col-md-6">
                <div class="employer-var">
                    <div class="employer-logo">
                        <a href="<?php echo $job->get_employer_link(); ?>" class="member-avatar">
                            <img src="<?php echo $job->get_employer_avatar(); ?>">
                        </a>
                    </div>    
                    <div class="employer-meta">
                        <a href="<?php echo $job->get_link(); ?>"><h4><?php echo $job->post_title;  ?></h4></a>
                    </div>
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

    <div class="job-content">
        <?php echo $job->get_post_excerpt(); ?>
        <div class="job-meta-tags">
            <?php echo $job->get_tags(); ?>
        </div>    
    </div>
    <!-- .entry-content -->
</article><!-- #post-## -->
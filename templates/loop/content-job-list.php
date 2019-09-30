<?php 
global $job;

$member     = $job->get_employer();
$location   = $job->get_location_tax();
$is_hightlighted = $job->is_hightlighted(); 
$class = $is_hightlighted ? "job-list-style job-item job-highlighted" : "job-list-style job-item"; 
?>
<article   <?php echo post_class( $class, $job->ID ); ?> data-id="job-<?php echo $job->ID; ?>"><div class="job-item-wrap">
    <?php do_action( "opaljob_job_loop_content_before" ); ?>
    <header class="entry-header">
        <div class="opal-row">
            <div class="col-md-6">
                <div class="card-wrap">
                    <div class="member-avatar card-logo">
                        <a href="<?php echo $job->get_link(); ?>">
                            <img src="<?php echo $job->get_employer_avatar(); ?>">
                        </a>
                        <?php opaljob_render_template( 'common/job/featured-label', array('job' => $job) ); ?> 
                    </div>
                    <div class="card-body">
                        <?php opaljob_render_template( 'common/job/type-label' ); ?>
                        <h4><a href="<?php echo $job->get_link(); ?>"><?php echo $job->post_title;  ?></a></h4>
                        <div class="job-posted">
                           <?php echo sprintf( esc_html__( 'Posted %1$s at %2$s', 'opaljob' ), 
                                $job->get_posted_ago(),
                                '<a href="'.$member->get_link().'">'. $member->get_name() .'</a>'
                            ); ?>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-2">
                <div class="job-meta-card">
                    <div class="meta-label"><?php esc_html_e( 'Location', 'opaljob' ); ?></div>
                    <div class="meta-content">
                        <?php if( $location ): ?>
                        <span class="job-location">
                           <i class="fa  fa-map-marker"></i>
                            <?php foreach( $location as $tax ): ?><a href="<?php echo get_term_link( $tax->term_id ); ?>">
                                <span><?php echo $tax->name; ?></span>
                            </a><?php endforeach; ?>
                        </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>    
            <div class="col-md-3">
                <div class="job-meta-card">
                    <div class="meta-label"><?php esc_html_e( 'Salary', 'opaljob' ); ?></div>
                    <div class="meta-content"><?php echo $job->get_salary(); ?></div>
                </div>    
            </div>    
        </div>
    </header>
    <?php if ( $is_hightlighted ): ?>
    <!-- .entry-header -->
    <div class="job-content">
        <?php echo $job->get_post_excerpt(); ?>
        <div class="job-meta-tags">
            <?php // echo $job->get_tags(); ?>
        </div>    
    </div>
    <!-- .entry-content -->
    <?php endif ; ?>

    <?php do_action( "opaljob_job_loop_content_after" ); ?>
</div></article><!-- #post-## -->
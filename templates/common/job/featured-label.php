<?php if(  $job->is_featured() ): ?>
    <span class="label-featured label tooltip" title="<?php esc_html_e( 'Featured', 'opaljob' ); ?>">
        <samp class="screen-reader-text"><?php esc_html_e( 'Featured', 'opaljob' ); ?></samp>
        <i class="fa fa-bolt" aria-hidden="true"></i>
    </span>
<?php endif;  ?>

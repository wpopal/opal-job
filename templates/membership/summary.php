
<div class="card mb-4">
    <div class="card-heading p-4">
        <div class="mini-stat-icon float-right">
            <i class="mdi mdi-cube-outline bg-primary  text-white"></i>
        </div>
        <div>
            <h5 class="font-16"><?php esc_html_e( "Actived Membership Summary", 'opaljob' ); ?></h5>
        </div>
    
        <p class="text-muted mt-2 mb-0">Previous period</p>
    </div>

    <div class="card-body">
    	<?php echo do_shortcode( "[opalmembership_user_current_package]" ); ?>
    </div>
</div>


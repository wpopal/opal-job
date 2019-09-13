<?php $statistic = opaljob_new_statistic_object(); ?>
<div class="col-sm-6 col-xl-3">
    <div class="card">
        <div class="card-heading p-4">
            <div class="mini-stat-icon float-right">
                <i class="mdi mdi-cube-outline bg-primary  text-white"></i>
            </div>
            <div>
                <h5 class="font-16"><?php esc_html_e( "Pushlish.", 'opaljob' ); ?></h5>
            </div>
            <h3 class="mt-4"><?php echo $statistic->count_publish_jobs(); ?></h3>
        </div>
    </div>
</div>

<div class="col-sm-6 col-xl-3">
    <div class="card">
        <div class="card-heading p-4">
            <div class="mini-stat-icon float-right">
                <i class="mdi mdi-cube-outline bg-primary  text-white"></i>
            </div>
            <div>
                <h5 class="font-16"><?php esc_html_e( "Featured.", 'opaljob' ); ?></h5>
            </div>
            <h3 class="mt-4">43,225</h3>
           
            
        </div>
    </div>
</div>

<div class="col-sm-6 col-xl-3">
    <div class="card">
        <div class="card-heading p-4">
            <div class="mini-stat-icon float-right">
                <i class="mdi mdi-cube-outline bg-primary  text-white"></i>
            </div>
            <div>
                <h5 class="font-16"><?php esc_html_e( "Pending.", 'opaljob' ); ?></h5>
            </div>
            <h3 class="mt-4"><?php echo $statistic->count_pending_jobs(); ?></h3>
        </div>
    </div>
</div>

<div class="col-sm-6 col-xl-3">
    <div class="card">
        <div class="card-heading p-4">
            <div class="mini-stat-icon float-right">
                <i class="mdi mdi-cube-outline bg-primary  text-white"></i>
            </div>
            <div>
                <h5 class="font-16"><?php esc_html_e( "Expired.", 'opaljob' ); ?></h5>
            </div>
           <h3 class="mt-4"><?php echo $statistic->count_expired_jobs(); ?></h3>
            
        </div>
    </div>
</div>
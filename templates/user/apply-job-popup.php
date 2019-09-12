<?php global $job; 
    $member = $job->get_employer(); 
?>
<div id="opaljob-apply-form-popup" class="white-popup popup-width-80  mfp-hide opaljob-mfp-popup">
    <div class="opaljob-popup-content">
    	<form method="post" action="" class="opaljob-apply-job-form">
	        <div class="popup-head">
	            <?php echo sprintf( esc_html__( "You are applying to job: %s of %s", "opaljob" ) , $job->post_title, $member->get_company() ) ;?>
	        </div>
	        <div class="popup-body">

	            <?php echo $form->render( array(), $fields ); ?>
	            <?php  wp_nonce_field( 'save-apply-job', 'apply_action' ); ?>
	            <button class="button btn btn-primary btn-3d" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> <?php esc_html_e( ' Processing', 'opaljob' ); ?>" type="submit" name="apply-job-form"><?php echo esc_html__( 'Apply Now', 'opaljob' ); ?></button>
	        </div>
	    </form>    
    </div>
</div>
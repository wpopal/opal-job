<?php 
if(  $existed != false || $existed != '' ) {
    $fav_class = 'fa fa-heart';
} else {
    $fav_class = 'fa fa-heart-o';
}
$need_login = '';
if( !is_user_logged_in() ){
	$need_login .= ' opaljob-need-login';
} else {
	$need_login .= " job-toggle-favorite";
}
?>
<span class="<?php echo esc_attr( $need_login ); ?> hint--top btn btn-outline-primary btn-lg" aria-label="<?php esc_html_e('Add To Favorite', 'opaljob'); ?>" data-job-id="<?php echo intval( $job_id ); ?>" title="<?php esc_html_e('Add To Favorite', 'opaljob'); ?>">
	<span class="<?php echo esc_attr( $fav_class ); ?>"></span>
</span>
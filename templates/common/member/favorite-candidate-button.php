<?php 
$class = '';
if(  $existed != false || $existed != '' ) {
    $fav_class = 'fa fa-heart';
    $title = esc_html__('Add To Shortlist', 'opaljob');

} else {
    $fav_class = 'fa fa-heart-o';
    $title = esc_html__('Remove this in Shortlist', 'opaljob');
    $class .= ' added ';
}

if( !is_user_logged_in() ){
	$class .= ' opaljob-need-login';
} else {
	$class .= " candidate-toggle-favorite";
}
?>
<span class="<?php echo esc_attr( $class ); ?> hint--top btn btn-outline-primary btn-lg" aria-label="<?php esc_attr( $title ); ?>" data-member-id="<?php echo intval( $member_id ); ?>" title="<?php esc_attr( $title ); ?>">
	<span class="<?php echo esc_attr( $fav_class ); ?>"></span>
</span>
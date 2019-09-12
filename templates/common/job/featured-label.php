<?php
$featured = get_post_meta( get_the_ID(), OPALESTATE_PROPERTY_PREFIX.'featured', true );
?>
<?php //if( $featured != 0 ) { ?>
    <span class="label-featured label"><?php esc_html_e( 'Featured', 'opaljob' ); ?></span>
<?php //} ?>

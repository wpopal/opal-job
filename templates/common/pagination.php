<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// global $wp_query;

if ( !isset( $max_num_pages ) ||  $max_num_pages <= 1 ) {
	return;
}

$args = apply_filters( 'opaljob_pagination_args', [
	'prev_text' => __( '&laquo;' ),
	'next_text' => __( '&raquo;' ),
	'type'      => 'list',
] );

?>

<nav class="opaljob-pagination">
	<?php 
		$total_pages = 10; 
		$paged 		 = 1; 
		$pagination_args = array(
			'base'     => '%_%',
			'format'   => '?paged=%#%',
			'total'    => $total_pages,
			'current'  => $paged,
			'show_all' => false,
		);
		echo paginate_links( $pagination_args );
	?>
</nav>	


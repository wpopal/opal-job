<div class="job-category-blocks">
    <div>
		<?php foreach ( $terms as $category ): ?>
			<?php
			$tax_link = get_term_link( $category->term_id );
			$image    = wp_get_attachment_image_url( get_term_meta( $category->term_id, 'opaljob_category_image_id', true ), 'full' );
			?>
            <div class="column-item  job-category ">
                <a href="<?php echo esc_url( $tax_link ); ?>" class="job-category-overlay"></a>
				<?php
				$style = '';
				if ( $image ) {
					$style = 'style="background-image:url(' . esc_url( $image ) . ')"';
				} else {
					$style = 'style="background-image:url(' . opaljob_get_image_placeholder_src() . ')"';
                }
				?>

                <div class="job-category-bg" <?php echo $style; ?>>
                </div>
                <div class="static-content">
                    <div class="job-category-info text-center">
						<?php if ( $category->name ) : ?>
                            <h4 class="job-category-title">
                                <a href="<?php echo esc_url( $tax_link ); ?>"><?php echo esc_html( $category->name ); ?></a>
                            </h4>
						<?php endif; ?>

						<?php if ( $category->count ) : ?>
                            <div class="job-category-count">
								<?php
								printf(
									_nx(
										'%1$s Job',
										'%1$s Jobs',
										$category->count,
										'opaljob'
									),
									number_format_i18n( $category->count )
								);
								?>
                            </div>
						<?php endif; ?>
                    </div>
                </div>
            </div>
		<?php endforeach; ?>
    </div>
</div>
<?php 
	$active_tab = ! empty( $_GET['opaljob_tab'] ) ? opaljob_clean( $_GET['opaljob_tab'] ) : 'form_field_options';
	wp_nonce_field( 'opaljob_save_form_meta', 'opaljob_meta_nonce' );
	?>
    <input id="opaljob_active_tab" type="hidden" name="opaljob_active_tab">
    <div class="js-opaljob-metabox-wrap opaljob-metabox-panel-wrap">
        <ul class="opaljob-form-data-tabs opaljob-metabox-tabs">
			<?php foreach ( $form_data_tabs as $index => $form_data_tab ) : ?>
				<?php
				// Determine if current tab is active.
				$is_active = $active_tab === $form_data_tab['id'] ? true : false;
				?>
                <li class="<?php echo "{$form_data_tab['id']}_tab" . ( $is_active ? ' active' : '' ) . ( $this->has_sub_tab( $form_data_tab ) ? ' has-sub-fields' : '' ); ?>"
                    data-tab="<?php echo $form_data_tab['id']; ?>">
                    <a href="#<?php echo $form_data_tab['id']; ?>"
                       data-tab-id="<?php echo $form_data_tab['id']; ?>">
						<?php if ( ! empty( $form_data_tab['icon-html'] ) ) : ?>
							<?php echo $form_data_tab['icon-html']; ?>
						<?php else : ?>
                            <span class="opaljob-icon opaljob-icon-default"></span>
						<?php endif; ?>
                        <span class="opaljob-label"><?php echo $form_data_tab['label']; ?></span>
                    </a>
					<?php if ( $this->has_sub_tab( $form_data_tab ) ) : ?>
                        <ul class="opaljob-metabox-sub-tabs opaljob-hidden">
							<?php foreach ( $form_data_tab['sub-fields'] as $sub_tab ) : ?>
                                <li class="<?php echo "{$sub_tab['id']}_tab"; ?>">
                                    <a href="#<?php echo $sub_tab['id']; ?>"
                                       data-tab-id="<?php echo $sub_tab['id']; ?>">
										<?php if ( ! empty( $sub_tab['icon-html'] ) ) : ?>
											<?php echo $sub_tab['icon-html']; ?>
										<?php else : ?>
                                            <span class="opaljob-icon opaljob-icon-default"></span>
										<?php endif; ?>
                                        <span class="opaljob-label"><?php echo $sub_tab['label']; ?></span>
                                    </a>
                                </li>
							<?php endforeach; ?>
                        </ul>
					<?php endif; ?>
                </li>
			<?php endforeach; ?>
        </ul>

		<?php foreach ( $this->settings as $setting ) : ?>
			<?php do_action( "opaljob_before_{$setting['id']}_settings" ); ?>
			<?php
			// Determine if current panel is active.
			$is_active = $active_tab === $setting['id'] ? true : false;
			?>
            <div id="<?php echo $setting['id']; ?>"
                 class="panel opaljob_options_panel<?php echo( $is_active ? ' active' : '' ); ?> opaljob-panel">
				<?php if ( ! empty( $setting['fields'] ) ) : ?>
					<?php foreach ( $setting['fields'] as $field ) : ?>
						<?php $this->render_field( $field ); ?>
					<?php endforeach; ?>
				<?php endif; ?>
            </div>
			<?php do_action( "opaljob_after_{$setting['id']}_settings" ); ?>

			<?php if ( $this->has_sub_tab( $setting ) ) : ?>
				<?php if ( ! empty( $setting['sub-fields'] ) ) : ?>
					<?php foreach ( $setting['sub-fields'] as $index => $sub_fields ) : ?>
                        <div id="<?php echo $sub_fields['id']; ?>" class="panel opaljob_options_panel opaljob-hidden">
							<?php if ( ! empty( $sub_fields['fields'] ) ) : ?>
								<?php foreach ( $sub_fields['fields'] as $sub_field ) : ?>
									<?php $this->render_field( $sub_field ); ?>
								<?php endforeach; ?>
							<?php endif; ?>
                        </div>
					<?php endforeach; ?>
				<?php endif; ?>
			<?php endif; ?>
		<?php endforeach; ?>
    </div>
	<?php
?>
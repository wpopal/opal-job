<?php // opaljob_select_specialisms_field(); ?>
<?php 
	$sps = get_terms( 'opaljob_tag', [ 'hide_empty' => false ] );
?>
<?php if( $sps ) : ?>
<div class="field-multi-select">
	<div class="field-heading"><?php esc_html_e( 'Tags', 'opaljob' ); ?></div>	
	<?php foreach ( $sps as $tax ): ?>
	<div class="more-options-item">
	    <label class="more-options-label">
	        <input type="checkbox" name="tags[]" class="form-checkbox-control" value="<?php echo esc_attr( $tax->slug ); ?>">
	        <?php echo esc_html( $tax->name ); ?>
	    </label>
	</div>
	<?php endforeach; ?>
</div>	
<?php endif ; ?>
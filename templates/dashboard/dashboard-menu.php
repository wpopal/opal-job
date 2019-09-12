<div class="opaljob-dashboard-menu">
	<ul class="dashboard-menu navbar-nav bg-gradient-primary">
		<?php foreach ( $menu as $key => $item ): ?>
			<?php if( isset($item['type'])  && $item['type'] == 'title' ) : ?>
			<li class="nav-item-title">
				<span><?php echo $item['title'] ; ?></span>
			</li>	
			<?php else : ?>	
			<li class="nav-item">
				<a href="<?php echo $item['link']; ?>" <?php if( $key==$active) : ?> class="active"<?php endif; ?> >
					<i class="<?php echo $item['icon']; ?>"></i> 
					<span><?php echo $item['title'] ; ?></span>
				</a>
			</li>
			<?php endif; ?>
		<?php endforeach; ?>	
	</ul>

</div>		



<div class="opaljob-topbar">
	<div class="topbar-left">
 
        <!-- Your site title as branding in the menu -->
        <?php if ( ! has_custom_logo() ) { ?>
        <?php if ( is_front_page() && is_home() ) : ?>
            <h1 class="navbar-brand mb-0">
                <a rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" itemprop="url">
                    <?php bloginfo( 'name' ); ?>
                </a>
            </h1>
        <?php else : ?>
            <a class="navbar-brand" rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" itemprop="url">
                <?php bloginfo( 'name' ); ?>
            </a>
        <?php endif; ?>
        <?php } else {
            the_custom_logo();
        } ?>
        <!-- end custom logo -->
	</div>
	<div class="topbar-right">
		<ul class="navbar-right list-inline float-right mb-0">
			<li class="dropdown">
				<a>bbb</a>
				<div class="dropdown-menu dropdown-menu-right profile-dropdown ">
						fsdfa
				</div>
			</li>
			<li class="dropdown">
				<a>bb</a>
				<div class="dropdown-menu dropdown-menu-right profile-dropdown ">
						fsdfa
				</div>
			</li>
		</ul>
	</div>	
</div>

<div class="opaljob-dashboard">
	<div class="inner">
		<div class="opaljob-dashboard-sidebar">
			<?php do_action("opaljob_dashboard_sidebar" ); ?>
		</div>	
		<div class="opaljob-dashboard-content"><div class="content-inner">
			<div class="container-fluid">
			<?php do_action("opaljob_dashboard_content" ); ?>
			</div>

		</div></div>	
	</div>	

</div>
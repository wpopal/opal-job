<div id="opaljob-user-form-popup" class="white-popup mfp-hide opaljob-mfp-popup tabl-simple-style">
    <div class="opaljob-tab hr-mode">
        <div class="nav opaljob-tab-head">
            <a href="#o-login-form" class="tab-item"><?php esc_html_e( 'Login', 'opaljob' ); ?></a>
            <a href="#o-register-form" class="tab-item"><?php esc_html_e( 'Register', 'opaljob' ); ?></a>
        </div>
        <div class="opaljob-tab-wrap">
            <div class="opaljob-tab-content" id="o-login-form">
				<?php
                    $atts = array(
                        'message'   => '',
                        'redirect'  => '',
                        'hide_title'    => false
                    );
                    opaljob_render_template( 'user/login-form', $atts );
                ?>
            </div>
            <div class="opaljob-tab-content" id="o-register-form">
				<?php
                    $atts = array(
                        'message'   => '',
                        'redirect'  => '',
                        'hide_title'    => false
                    );
                    opaljob_render_template( 'user/register-form', $atts );
                ?>
            </div>
        </div>
    </div>
</div>
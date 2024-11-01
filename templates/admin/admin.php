<div id="wrapper" class="cptwd-wrapper">
  <div class="cptwd-content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-body _buttonss">
              <h4 class="cptwd-heading pull-left display-block"><?php esc_html_e( 'Settings Manager', 'mmwcptwd' ); ?></h4>
            </div>
          <div class="panel-body">
              <div class="col-lg-6">
                  <form id="save_cpt_options" method="post" action="options.php">
                    <?php
                      settings_fields( 'mmwcptwd_admin_settings' );
                      do_settings_sections( 'mmwcptwd_admin_page' );
                      mmwcptwd_submit_button();
                    ?>
                  </form>
              </div>
            </div>
          </div>
         </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div id="wrapper" class="cptwd-wrapper">
  <div class="cptwd-content">
    <?php settings_errors(); ?>
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-body _buttonss">
              <h4 class="cptwd-heading pull-left display-block"><?php esc_html_e( 'Manage Widgets', 'mmwcptwd' ); ?></h4>
            </div>
          <div class="panel-body">
          <div class="tab-content">
            <div class="row">
              <div class="col-md-12">
               <ul class="nav nav-tabs" role="tablist">
                  <li role="presentation" class="<?php echo !isset($_POST["edit_widgets"]) ? 'active' : '' ?>"> 
                    <a href="#cptwd_custom_widget" aria-controls="cptwd_custom_widget" role="tab" data-toggle="tab" aria-selected="true">
                      <?php esc_html_e( 'Widgets', 'mmwcptwd' ); ?>
                  </a>
                </li>
                  <li role="presentation" class="<?php echo isset($_POST["edit_widgets"]) ? 'active' : '' ?>"> 
                    <a href="#cptwd_add_edit_widget" aria-controls="cptwd_add_edit_widget" role="tab" data-toggle="tab" aria-selected="false">
                     <?php echo isset($_POST["edit_widgets"]) ? 'Edit' : 'Add' ?> <?php esc_html_e( 'Widget', 'mmwcptwd' ); ?> 
                  </a>
                </li>
                  <li role="presentation"> 
                    <a href="#cptwd_export_widget" aria-controls="cptwd_export_widget" role="tab" data-toggle="tab" aria-selected="false">
                      <?php esc_html_e( 'Export', 'mmwcptwd' ); ?> 
                  </a>
                </li>
              </ul>
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane <?php echo !isset($_POST["edit_widgets"]) ? 'active' : '' ?>" id="cptwd_custom_widget" role="tabpanel" aria-labelledby="cptwd_custom_widget-tab">
                   <table id="cptwdTable" class="table">
                    <thead>
                        <tr>
                            <th width="10"><?php esc_html_e( '#', 'mmwcptwd' ); ?></th>
                            <th><?php esc_html_e( 'Widget ID', 'mmwcptwd' ); ?></th>
                            <th><?php esc_html_e( 'Widget Name', 'mmwcptwd' ); ?></th>
                            <th><?php esc_html_e( 'Description', 'mmwcptwd' ); ?></th>
                            <th><?php esc_html_e( 'Option', 'mmwcptwd' ); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $options = get_option( 'mmwcptwd_cwm' ) ?: array();
                         $i = 0; foreach ( $options as $option): $i++;
                         $hierarchical = isset($option['hierarchical']) ? "TRUE" : "FALSE";
                         ?>
                        <tr class="<?php echo $option['cwm_name']; ?>" id="cpdwd_<?php echo $option['cwm_name']; ?>">
                          <td><?php echo esc_html__( $i, 'mmwcptwd' ) ?></td>
                          <td><?php echo esc_html__( $option['widget_id'], 'mmwcptwd' ); ?></td>
                          <td><?php echo esc_html__( $option['cwm_name'], 'mmwcptwd' ); ?></td>
                          <td><?php echo esc_html__( $option['description'], 'mmwcptwd' ); ?></td>
                          <td>
                            <form method="post" action="" class="cptwd_edit_form cptwd_edit_delete">
                              <input type="hidden" name="edit_widgets" value="<?php echo esc_attr($option['widget_id']) ?>">
                              <button type="submit" class="btn btn-primary btn-icon cptwd_edit_taxo" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square-o"></i></button>
                            </form>
                            <form method="post" action="options.php" class="cptwd_edit_form cptwd_edit_delete">
                              <?php echo settings_fields( 'mmwcptwd_admin_widget_settings' ); ?>
                              <input type="hidden" name="remove" value="<?php echo esc_attr($option['widget_id']) ?>">
                              <button type="submit" class="btn btn-danger btn-icon cptwd_delete_taxo" data-toggle="tooltip" data-placement="top" title="Delete" onclick='return confirm("<?php echo esc_js(__('Are you sure you want to delete this Custom Widget? The data associated with it will not be deleted' ,'mmwcptwd'));?>")'><i class="fa fa-remove"></i></button>
                            </form>
                          </td>
                        </tr>
                         <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
                <div role="tabpanel" class="tab-pane <?php echo isset($_POST["edit_widgets"]) ? 'active' : '' ?>" id="cptwd_add_edit_widget" role="tabpanel" aria-labelledby="cptwd_add_edit_widget-tab">
                  <div class="col-lg-6">
                    <form id="save_widget" method="post" action="options.php">
                       <?php
                        settings_fields( 'mmwcptwd_admin_widget_settings' );
      					        do_settings_sections( 'mmwcptwd_admin_widget_page' );
                        mmwcptwd_submit_button();
                        ?>
                    </form>
                  </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="cptwd_export_widget" role="tabpanel" aria-labelledby="cptwd_export_widget-tab">
                  <div class="cptwd_export">
                    <div class="cptwd-body">
                       <h4><?php echo esc_html__( 'Export Your Custom Widget', 'mmwcptwd' ); ?></h4>
          					    <?php foreach ($options as $option) { ?>
          			        <h5><?php echo esc_html__( $option['cwm_name'], 'mmwcptwd' ); ?></h5>
          			        <pre class="prettyprint">
                         function mmwcptwd_widgets_<?php echo esc_attr( strtolower(str_replace(' ', '_', $option['widget_id'])) ); ?>() {
                          register_sidebar( array(
                              'name'          => __( '<?php echo esc_attr( $option['cwm_name']); ?>', 'mmwcptwd' ),
                              'id'            => '<?php echo esc_attr( strtolower($option['widget_id']) ); ?>',
                              'description'   => __( '<?php echo esc_attr( $option['description']); ?>', 'mmwcptwd' ),
                              'before_widget'  => '<?php echo esc_html('<li id="%1$s" class="widget %2$s '.strtolower($option['before_widget']).'">');?>',
                              'after_widget'  => '<?php echo esc_html('</li>'); ?>',
                              'before_title'  => '<?php echo esc_html('<h2 id="%1$s" class="widget %2$s '.strtolower($option['before_title']).'">');?>',
                              'after_title'   => '<?php echo esc_html('</h2>'); ?>',
                          ) );
                      }
                      add_action( 'widgets_init', 'mmwcptwd_widgets_<?php echo esc_attr( strtolower(str_replace(' ', '_', $option['widget_id'])) ); ?>' );

          					    </pre>
          					    <?php } ?>
                    </div>
                  </div>
                </div>
              </div>                         
              </div>
            </div>
          </div>
         </div>
        </div>
      </div>
    </div>
  </div>
</div>


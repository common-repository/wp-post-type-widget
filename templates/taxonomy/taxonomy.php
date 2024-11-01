<div id="wrapper" class="cptwd-wrapper">
  <div class="cptwd-content">
    <?php settings_errors(); ?>
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-body _buttonss">
              <h4 class="cptwd-heading pull-left display-block"><?php esc_html_e( 'Manage Taxonomies', 'mmwcptwd' ); ?></h4>
            </div>
          <div class="panel-body">
          <div class="tab-content">
            <div class="row">
              <div class="col-md-12">
               <ul class="nav nav-tabs" role="tablist">
                  <li role="presentation" class="<?php echo !isset($_POST["edit_taxonomy"]) ? 'active' : '' ?>"> 
                    <a href="#cptwd_post_tax" aria-controls="cptwd_post_tax" role="tab" data-toggle="tab" aria-selected="true">
                      <?php esc_html_e( 'Taxonomies', 'mmwcptwd' ); ?>
                  </a>
                </li>
                  <li role="presentation" class="<?php echo isset($_POST["edit_taxonomy"]) ? 'active' : '' ?>"> 
                    <a href="#cptwd_add_edit_taxo" aria-controls="cptwd_add_edit_taxo" role="tab" data-toggle="tab" aria-selected="false">
                     <?php echo isset($_POST["edit_taxonomy"]) ? 'Edit' : 'Add' ?> <?php esc_html_e( 'Taxonomy', 'mmwcptwd' ); ?> 
                  </a>
                </li>
                  <li role="presentation"> 
                    <a href="#cptwd_export_taxo" aria-controls="cptwd_export_taxo" role="tab" data-toggle="tab" aria-selected="false">
                      <?php esc_html_e( 'Export', 'mmwcptwd' ); ?> 
                  </a>
                </li>
              </ul>
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane <?php echo !isset($_POST["edit_taxonomy"]) ? 'active' : '' ?>" id="cptwd_post_tax" role="tabpanel" aria-labelledby="cptwd_post_tax-tab">
                   <table id="cptwdTable" class="table">
                    <thead>
                        <tr>
                            <th width="10"><?php esc_html_e( '#', 'mmwcptwd' ); ?></th>
                            <th><?php esc_html_e( 'Taxonomy ID', 'mmwcptwd' ); ?></th>
                            <th><?php esc_html_e( 'Singular Name', 'mmwcptwd' ); ?></th>
                            <th><?php esc_html_e( 'Hierarchical', 'mmwcptwd' ); ?></th>
                            <th><?php esc_html_e( 'Gutenberg', 'mmwcptwd' ); ?></th>
                            <th><?php esc_html_e( 'Image', 'mmwcptwd' ); ?></th>
                            <th><?php esc_html_e( 'Post Type', 'mmwcptwd' ); ?></th>
                            <th><?php esc_html_e( 'Option', 'mmwcptwd' ); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $options = get_option( 'mmwcptwd_tax' ) ?: array();
                         $i = 0; foreach ( $options as $option): $i++;
                         
                         $hierarchical = isset($option['hierarchical']) ? "<button class='btn-primary' data-toggle='tooltip' data-placement='top' title='TRUE' disabled>TRUE</button>" : "<button class='btn-danger' data-toggle='tooltip' data-placement='top' title='FALSE' disabled>FALSE</button>";
                         
                         $has_gutenberg = isset($option['has_gutenberg']) && !empty($option['has_gutenberg']) ? "<button class='btn-primary' data-toggle='tooltip' data-placement='top' title='TRUE' disabled>TRUE</button>" : "<button class='btn-danger' data-toggle='tooltip' data-placement='top' title='FALSE' disabled>FALSE</button>";

                         $has_image = isset($option['has_image']) && !empty($option['has_image']) ? "<button class='btn-primary' data-toggle='tooltip' data-placement='top' title='TRUE' disabled>TRUE</button>" : "<button class='btn-danger' data-toggle='tooltip' data-placement='top' title='FALSE' disabled>FALSE</button>";
                         ?>
                         
                        <tr class="<?php echo $option['taxonomy']; ?>" id="cpdwd_<?php echo $option['taxonomy']; ?>">
                          <td><?php echo esc_html__( $i, 'mmwcptwd' ); ?></td>
                          <td><?php echo esc_html__( $option['taxonomy'], 'mmwcptwd' ); ?></td>
                          <td><?php echo esc_html__( $option['singular_name'], 'mmwcptwd' ); ?></td>
                          <td><?php echo $hierarchical; ?></td>
                          <td><?php echo $has_gutenberg; ?></td>
                          <td><?php echo $has_image; ?></td>
                          <td>
                            <?php if (!empty($option['objects'])): ?>
                              <?php foreach ($option['objects'] as $key => $value): ?>
                             <button class='btn-primary' data-toggle='tooltip' data-placement='top' title='TRUE' disabled><?php echo $key; ?></button>
                           <?php endforeach; ?>
                            <?php else: ?>
                              <button class='btn-danger' data-toggle='tooltip' data-placement='top' title='No Post Select' disabled><?php echo esc_html__( 'No Post Select', 'mmwcptwd' ); ?></button>
                            <?php endif; ?>
                          </td>
                          <td>
                            <form method="post" action="" class="cptwd_edit_form cptwd_edit_delete">
                              <input type="hidden" name="edit_taxonomy" value="<?php echo esc_attr($option['taxonomy']) ?>">
                              <button type="submit" class="btn btn-primary btn-icon cptwd_edit_taxo" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square-o"></i></button>
                            </form>
                            <form method="post" action="options.php" class="cptwd_edit_form cptwd_edit_delete">
                              <?php echo settings_fields( 'mmwcptwd_taxonomy_settings' ); ?>
                              <input type="hidden" name="remove" value="<?php echo esc_attr($option['taxonomy']) ?>">
                              <button type="submit" class="btn btn-danger btn-icon cptwd_delete_taxo" data-toggle="tooltip" data-placement="top" title="Delete" onclick='return confirm("<?php echo esc_js(__('Are you sure you want to delete this Custom Taxonomy? The data associated with it will not be deleted' ,'mmwcptwd'));?>")'><i class="fa fa-remove"></i></button>
                              
                            </form>
                          </td>
                        </tr>
                         <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
                <div role="tabpanel" class="tab-pane <?php echo isset($_POST["edit_taxonomy"]) ? 'active' : '' ?>" id="cptwd_add_edit_taxo" role="tabpanel" aria-labelledby="cptwd_add_edit_taxo-tab">
                  <div class="col-lg-6">
                    <form id="save_taxonomy" method="post" action="options.php">
                       <?php
                          settings_fields( 'mmwcptwd_taxonomy_settings' );
                          do_settings_sections( 'mmwcptwd_taxonomy_page' );
                          mmwcptwd_submit_button();
                        ?>
                    </form>
                  </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="cptwd_export_taxo" role="tabpanel" aria-labelledby="cptwd_export_taxo-tab">
                  <div class="cptwd_export">
                    <div class="cptwd-body">
                       <h4><?php echo esc_html__( 'Export Your Taxonomies', 'mmwcptwd' ); ?></h4>
                        <?php foreach ($options as $option) { ?>
                              <h5><?php echo esc_html__( $option['singular_name'], 'mmwcptwd' ); ?></h5>
                              <pre class="prettyprint">
                                    // Register Custom Taxonomy
                                    function mmwcptwd_taxonomy_<?php echo esc_attr( strtolower(str_replace(' ', '_', $option['taxonomy'])) ); ?>() {

                                        $labels = array(
                                            'name'                       => _x( '<?php echo $option['taxonomy']; ?>', 'Taxonomy General Name', 'mmwcptwd' ),
                                            'singular_name'              => _x( '<?php echo $option['singular_name']; ?>', 'Taxonomy Singular Name', 'mmwcptwd' ),
                                            'menu_name'                  => __( '<?php echo $option['singular_name']; ?>', 'mmwcptwd' ),
                                            'all_items'                  => __( 'All <?php echo $option['singular_name']; ?>', 'mmwcptwd' ),
                                            'parent_item'                => __( 'Parent <?php echo $option['singular_name']; ?>', 'mmwcptwd' ),
                                            'parent_item_colon'          => __( 'Parent <?php echo $option['singular_name']; ?>:', 'mmwcptwd' ),
                                            'new_item_name'              => __( 'New <?php echo $option['singular_name']; ?>', 'mmwcptwd' ),
                                            'add_new_item'               => __( 'Add <?php echo $option['singular_name']; ?>', 'mmwcptwd' ),
                                            'edit_item'                  => __( 'Edit <?php echo $option['singular_name']; ?>', 'mmwcptwd' ),
                                            'update_item'                => __( 'Update <?php echo $option['singular_name']; ?>', 'mmwcptwd' ),
                                            'view_item'                  => __( 'View <?php echo $option['singular_name']; ?>', 'mmwcptwd' ),
                                            'separate_items_with_commas' => __( 'Separate items with commas', 'mmwcptwd' ),
                                            'add_or_remove_items'        => __( 'Add or remove <?php echo $option['singular_name']; ?>', 'mmwcptwd' ),
                                            'choose_from_most_used'      => __( 'Choose from the most used', 'mmwcptwd' ),
                                            'popular_items'              => __( 'Popular <?php echo $option['singular_name']; ?>', 'mmwcptwd' ),
                                            'search_items'               => __( 'Search <?php echo $option['singular_name']; ?>', 'mmwcptwd' ),
                                            'not_found'                  => __( 'Not Found', 'mmwcptwd' ),
                                            'no_terms'                   => __( 'No items', 'mmwcptwd' ),
                                            'items_list'                 => __( 'Items list', 'mmwcptwd' ),
                                            'items_list_navigation'      => __( 'Items list navigation', 'mmwcptwd' ),
                                        );
                                        $args = array(
                                            'labels'                     => $labels,
                                            'hierarchical'               => false,
                                            'public'                     => true,
                                            'show_ui'                    => true,
                                            'show_admin_column'          => true,
                                            'show_in_nav_menus'          => true,
                                            'show_tagcloud'              => true,
                                        );
                                        
                                        <?php if (!empty($option['objects'])): ?>
                                         <?php foreach ($option['objects'] as $key => $value): ?>
                                        register_taxonomy( 'taxonomy', array( '<?php echo esc_attr( $key ); ?>' ), $args );
                                         <?php endforeach; ?>
                                          <?php else: ?>
                                        register_taxonomy( 'taxonomy', array( 'no_post_select' ), $args );
                                         <?php endif; ?>

                                    }
                                    add_action( 'init', 'mmwcptwd_taxonomy_<?php echo esc_attr( strtolower(str_replace(' ', '_', $option['taxonomy'])) ); ?>', 0 );
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


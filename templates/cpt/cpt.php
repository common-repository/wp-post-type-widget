<div id="wrapper" class="cptwd-wrapper">
  <div class="cptwd-content">
    <?php settings_errors(); ?>
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-body _buttons">
              <h4 class="cptwd-heading pull-left display-block"><?php esc_html_e( 'Manage Post Type', 'mmwcptwd' ); ?></h4>
          </div>
          <div class="panel-body">
          <div class="tab-content">
            <div class="row">
              <div class="col-md-12">
               <ul class="nav nav-tabs" role="tablist">
                  <li role="presentation" class="<?php echo !isset( $_POST["edit_post"] ) ? 'active' : '' ?>"> 
                    <a href="#cptwd_post" aria-controls="cptwd_post" role="tab" data-toggle="tab" aria-selected="true">
                      <?php esc_html_e( 'Post Types', 'mmwcptwd' ); ?>
                  </a>
                </li>
                  <li role="presentation" class="<?php echo isset( $_POST["edit_post"] ) ? 'active' : '' ?>"> 
                    <a href="#cptwd_add_edit" aria-controls="cptwd_add_edit" role="tab" data-toggle="tab" aria-selected="false">
                     <?php echo isset( $_POST["edit_post"] ) ? 'Edit' : 'Add' ?> <?php esc_html_e( 'Custom Post Type', 'mmwcptwd' ); ?> 
                  </a>
                </li>
                  <li role="presentation"> 
                    <a href="#cptwd_export" aria-controls="cptwd_export" role="tab" data-toggle="tab" aria-selected="false">
                      <?php esc_html_e( 'Export', 'mmwcptwd' ); ?> 
                  </a>
                </li>
              </ul>
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane <?php echo !isset( $_POST["edit_post"] ) ? 'active' : '' ?>" id="cptwd_post" role="tabpanel" aria-labelledby="cptwd_post-tab">
                   <table id="cptwdTable" class="table">
                    <thead>
                        <tr>
                            <th width="10"><?php esc_html_e( '#', 'mmwcptwd' ); ?></th>
                            <th><?php esc_html_e( 'Post Type', 'mmwcptwd' ); ?></th>
                            <th><?php esc_html_e( 'Singular Name', 'mmwcptwd' ); ?></th>
                            <th><?php esc_html_e( 'Plural Name', 'mmwcptwd' ); ?></th>
                            <th><?php esc_html_e( 'Public', 'mmwcptwd' ); ?></th>
                            <th><?php esc_html_e( 'Archive', 'mmwcptwd' ); ?></th>
                            <th><?php esc_html_e( 'Gutenberg', 'mmwcptwd' ); ?></th>
                            <th><?php esc_html_e( 'Support', 'mmwcptwd' ); ?></th>
                            <th><?php esc_html_e( 'Option', 'mmwcptwd' ); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $options = get_option( 'mmwcptwd_cpt' ) ?: array();
                         $i = 0; foreach ( $options as $option): $i++;

                          $public = isset($option['public']) && !empty($option['public']) ? "<button class='btn-primary' data-toggle='tooltip' data-placement='top' title='TRUE' disabled>TRUE</button>" : "<button class='btn-danger' data-toggle='tooltip' data-placement='top' title='FALSE' disabled>FALSE</button>";

                          $archive = isset($option['has_archive']) && !empty($option['has_archive']) ? "<button class='btn-primary' data-toggle='tooltip' data-placement='top' title='TRUE' disabled>TRUE</button>" : "<button class='btn-danger' data-toggle='tooltip' data-placement='top' title='FALSE' disabled>FALSE</button>";
                         
                         $has_gutenberg = isset($option['has_gutenberg']) && !empty($option['has_gutenberg']) ? "<button class='btn-primary' data-toggle='tooltip' data-placement='top' title='TRUE' disabled>TRUE</button>" : "<button class='btn-danger' data-toggle='tooltip' data-placement='top' title='FALSE' disabled>FALSE</button>";


                          $title = isset( $option['title'] ) && !empty($option['title']) ? "<button class='btn-primary' data-toggle='tooltip' data-placement='top' title='Enable' disabled>".ucfirst($option['title'])."</button>" : "<button class='btn-danger' data-toggle='tooltip' data-placement='top' title='Disable' disabled>".esc_html('Title', 'mmwcptwd')."</button>";

                          $editor = isset( $option['editor'] ) && !empty($option['editor']) ? "<button class='btn-primary' data-toggle='tooltip' data-placement='top' title='Enable' disabled>".ucfirst($option['editor'])."</button>" : "<button class='btn-danger' data-toggle='tooltip' data-placement='top' title='Disable' disabled>".esc_html('Editor', 'mmwcptwd')."</button>";

                           $author  = isset( $option['author'] ) && !empty($option['author']) ? "<button class='btn-primary' data-toggle='tooltip' data-placement='top' title='Enable' disabled>".esc_html('Author', 'mmwcptwd')."</button>" : "<button class='btn-danger' data-toggle='tooltip' data-placement='top' title='Disable' disabled>".esc_html('Author', 'mmwcptwd')."</button>";

                          $thumbnail  = isset( $option['thumbnail'] ) && !empty($option['thumbnail']) ? "<button class='btn-primary' data-toggle='tooltip' data-placement='top' title='Enable' disabled>".esc_html('Thumbnail', 'mmwcptwd')."</button>" : "<button class='btn-danger' data-toggle='tooltip' data-placement='top' title='Disable' disabled>".esc_html('Thumbnail', 'mmwcptwd')."</button>";

                          $excerpts  = isset( $option['excerpts'] ) && !empty($option['excerpts']) ? "<button class='btn-primary btn-margin-top' data-toggle='tooltip' data-placement='top' title='Enable' disabled>".esc_html('Excerpts', 'mmwcptwd')."</button>" : "<button class='btn-danger btn-margin-top' data-toggle='tooltip' data-placement='top' title='Disable' disabled>".esc_html('Excerpts', 'mmwcptwd')."</button>";

                          $custom_fields  = isset( $option['custom_fields'] ) && !empty($option['custom_fields']) ? "<button class='btn-primary btn-margin-top' data-toggle='tooltip' data-placement='top' title='Enable' disabled>".esc_html('Custom Fields', 'mmwcptwd')."</button>" : "<button class='btn-danger btn-margin-top' data-toggle='tooltip' data-placement='top' title='Disable' disabled>".esc_html('Custom Fields', 'mmwcptwd')."</button>";

                          $comments  = isset( $option['comments'] ) && !empty($option['comments']) ? "<button class='btn-primary btn-margin-top' data-toggle='tooltip' data-placement='top' title='Enable' disabled>".esc_html('Comments', 'mmwcptwd')."</button>" : "<button class='btn-danger btn-margin-top' data-toggle='tooltip' data-placement='top' title='Disable' disabled>".esc_html('Comments', 'mmwcptwd')."</button>";

                          $taxonomies_value  = isset( $option['taxonomies_value'] ) && !empty($option['taxonomies_value']) ? "<button class='btn-primary btn-margin-top' data-toggle='tooltip' data-placement='top' title='Enable' disabled>".esc_html('Taxonomy', 'mmwcptwd')."</button>" : "<button class='btn-danger btn-margin-top' data-toggle='tooltip' data-placement='top' title='Disable' disabled>".esc_html('Taxonomy', 'mmwcptwd')."</button>";
                         ?>
                        <tr class="<?php echo $option['post_type']; ?>" id="cpdwd_<?php echo $option['post_type']; ?>">
                          <td><?php echo esc_html__( $i, 'mmwcptwd' ); ?></td>
                          <td><?php echo esc_html__( $option['post_type'], 'mmwcptwd' ); ?></td>
                          <td><?php echo esc_html__( $option['singular_name'], 'mmwcptwd' ); ?></td>
                          <td><?php echo esc_html__( $option['plural_name'], 'mmwcptwd' ); ?></td>
                          <td><?php echo $public; ?></td>
                          <td><?php echo $archive; ?></td>
                          <td><?php echo $has_gutenberg; ?></td>
                          <td><?php echo $title . ' ' . $editor . ' ' . $author . ' ' . $thumbnail . ' <br> ' . $excerpts . ' ' . $custom_fields . ' ' . $comments . ' ' . $taxonomies_value; ?></td>
                          <td>
                            <form method="post" action="" class="cptwd_edit_form cptwd_edit_delete">
                              <input type="hidden" name="edit_post" value="<?php echo esc_attr($option['post_type']) ?>">
                              <button type="submit" class="btn btn-primary btn-icon cptwd_edit" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square-o"></i></button>
                            </form>
                            <form method="post" action="options.php" class="cptwd_edit_form cptwd_edit_delete">
                              <?php echo settings_fields( 'mmwcptwd_post_type_settings' ); ?>
                              <input type="hidden" name="remove" value="<?php echo esc_attr($option['post_type']) ?>">
                              <button type="submit" class="btn btn-danger btn-icon cptwd_delete" data-toggle="tooltip" data-placement="top" title="Delete" onclick='return confirm("<?php echo esc_js(__('Are you sure you want to delete this Post Type? The data associated with it will not be deleted' ,'mmwcptwd'));?>")'><i class="fa fa-remove"></i></button>
                            </form>
                          </td>
                        </tr>
                         <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
                <div role="tabpanel" class="tab-pane <?php echo isset( $_POST["edit_post"] ) ? 'active' : '' ?>" id="cptwd_add_edit" role="tabpanel" aria-labelledby="cptwd_add_edit-tab">
                  <div class="col-lg-6">
                    <form id="save_cpt" method="post" action="options.php">
                       <?php
                          settings_fields( 'mmwcptwd_post_type_settings' );
                          do_settings_sections( 'mmwcptwd_post_type_page' );
                          mmwcptwd_submit_button();
                        ?>
                    </form>
                  </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="cptwd_export" role="tabpanel" aria-labelledby="cptwd_export-tab">
                  <div class="cptwd_export">
                    <div class="cptwd-body">
                      <h4><?php echo esc_html__( 'Export Your Custom Post Types', 'mmwcptwd' ); ?></h4>
                      <?php foreach ( $options as $option ) { ?>
                          <h5><?php echo esc_html__( $option['singular_name'], 'mmwcptwd' ); ?></h5>
                          <pre class="prettyprint">
                            // Register Custom Post Type
                            function mmwcptwd_post_<?php echo esc_attr( strtolower(str_replace(' ', '_', $option['singular_name'])) ); ?>() {

                              $labels = array(
                                'name'                  => _x( '<?php echo $option['plural_name']; ?>', 'Post Type General Name', 'mmwcptwd' ),
                                'singular_name'         => _x( '<?php echo $option['singular_name']; ?>', 'Post type singular name', 'mmwcptwd' ),
                                'menu_name'             => _x( '<?php echo $option['plural_name']; ?>', 'Admin Menu text', 'mmwcptwd' ),
                                'name_admin_bar'        => _x( '<?php echo $option['singular_name']; ?>', 'Add New on Toolbar', 'mmwcptwd' ),
                                'add_new'               => __( 'Add <?php echo $option['singular_name']; ?>', 'mmwcptwd' ),
                                'add_new_item'          => __( 'Add New <?php echo $option['singular_name']; ?>', 'mmwcptwd' ),
                                'new_item'              => __( 'New <?php echo $option['singular_name']; ?>', 'mmwcptwd' ),
                                'edit_item'             => __( 'Edit <?php echo $option['singular_name']; ?>', 'mmwcptwd' ),
                                'view_item'             => __( 'View <?php echo $option['singular_name']; ?>', 'mmwcptwd' ),
                                'view_items'            => __( 'View <?php echo $option['plural_name']; ?>', 'mmwcptwd' ),
                                'all_items'             => __( 'All Items', 'mmwcptwd' ),
                                'search_items'          => __( 'Search <?php echo $option['plural_name']; ?>', 'mmwcptwd' ),
                                'parent_item_colon'     => __( 'Parent <?php echo $option['singular_name']; ?>:', 'mmwcptwd' ),
                                'not_found'             => __( 'Not <?php echo $option['singular_name']; ?> found', 'mmwcptwd' ),
                                'not_found_in_trash'    => __( 'Not <?php echo $option['singular_name']; ?> found in Trash', 'mmwcptwd' ),
                                'featured_image'        => _x( 'Featured Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'mmwcptwd' ),
                                'set_featured_image'    => _x( 'Set featured image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'mmwcptwd' ),
                                'remove_featured_image' => _x( 'Remove featured image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'mmwcptwd' ),
                                'use_featured_image'    => _x( 'Use as featured image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'mmwcptwd' ),
                                'archives'              => _x( '<?php echo $option['singular_name']; ?>', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'mmwcptwd' ),
                                'insert_into_item'      => _x( 'Insert into <?php echo $option['singular_name']; ?>', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'mmwcptwd' ),
                                'uploaded_to_this_item' => _x( 'Uploaded to this <?php echo $option['singular_name']; ?>', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'mmwcptwd' ),
                                'filter_items_list'     => _x( 'Filter <?php echo $option['plural_name']; ?>', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'mmwcptwd' ),
                                'items_list_navigation' => _x( '<?php echo $option['plural_name']; ?> list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'mmwcptwd' ),
                                'items_list'            => _x( '<?php echo $option['plural_name']; ?> list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'mmwcptwd' ),
                                'attributes'            => __( '<?php echo $option['singular_name']; ?>', 'mmwcptwd' ),
                                'update_item'           => __( 'Update Item', 'mmwcptwd' ),
                              );
                              $args = array(
                                'label'                 => __( '<?php echo $option['singular_name']; ?>', 'mmwcptwd' ),
                                'description'           => __( '<?php echo $option['singular_name']; ?> Description', 'mmwcptwd' ),
                                'labels'                => $labels,
                                'supports'              => false,
                                'taxonomies'            => array( 'category', 'post_tag' ),
                                'hierarchical'          => false,
                                'public'                => <?php echo isset( $option['public'] ) ? "true" : "false"; ?>,
                                'show_ui'               => true,
                                'show_in_menu'          => true,
                                'menu_position'         => <?php echo $option['menu_position']; ?>,
                                'menu_icon'             => <?php echo $option['menu_icon']; ?>,
                                'show_in_admin_bar'     => true,
                                'show_in_nav_menus'     => true,
                                'can_export'            => true,
                                'has_archive'           => <?php echo isset( $option['has_archive'] ) ? "true" : "false"; ?>,
                                'exclude_from_search'   => false,
                                'publicly_queryable'    => true,
                                'capability_type'       => 'post',
                              );
                              register_post_type( '<?php echo $option['post_type']; ?>', $args );

                            }
                            add_action( 'init', 'mmwcptwd_post_<?php echo esc_attr( strtolower(str_replace(' ', '_', $option['singular_name'])) ); ?>', 0 );
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
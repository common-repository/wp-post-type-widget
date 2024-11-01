<?php
/**
 * @package  getwebPlugin
 */
namespace rsCustomPost\Base;

use rsCustomPost\Api\MMWCPTWD_SettingsApi;
use rsCustomPost\Base\MMWCPTWD_BaseController;
use rsCustomPost\Api\Callbacks\MMWCPTWD_CptCallbacks;
use rsCustomPost\Api\Callbacks\MMWCPTWD_AdminCallbacks;

/**
 *
 */
if(!class_exists('MMWCPTWD_PostTypeController')):
  class MMWCPTWD_PostTypeController extends MMWCPTWD_BaseController
  {
    public $settings;

    public $callbacks;

    public $cpt_callbacks;

    public $subpages = array();

    public $custom_post_types = array();

    public function mmwcptwd_register()
    {
      if ( ! $this->mmwcptwd_activated( 'cpt_manager' ) ) return;
      if ( ! $this->mmwcptwd_last_code() ) return;
      if ( ! $this->mmwcptwd_wp_version_check() ) return;

      $this->settings = new MMWCPTWD_SettingsApi();

      $this->callbacks = new MMWCPTWD_AdminCallbacks();

      $this->cpt_callbacks = new MMWCPTWD_CptCallbacks();

      $this->mmwcptwd_set_sub_pages();

      $this->mmwcptwd_set_settings();

      $this->mmwcptwd_set_sections();

      $this->mmwcptwd_set_fields();

      $this->settings->mmwcptwd_add_sub_pages( $this->subpages )->mmwcptwd_register();

      $this->mmwcptwd_store_custom_post_types();

      if ( ! empty( $this->custom_post_types ) ) {
        add_action( 'init', array( $this, 'mmwcptwd_register_custom_post_types' ) );
      }
    }
   
    public function mmwcptwd_set_sub_pages()
    {
      $this->subpages = array(
        array(
          'parent_slug' => 'mmwcptwd',
          'page_title' => 'Post Types',
          'menu_title' => 'Manage CPT',
          'capability' => 'manage_options',
          'menu_slug' => 'mmwcptwd-posts',
          'callback' => array( $this->callbacks, 'mmwcptwd_admin_cpt' )
        )
      );
    }

    public function mmwcptwd_set_settings()
    {
      $args = array(
        array(
          'option_group' => 'mmwcptwd_post_type_settings',
          'option_name' => 'mmwcptwd_cpt',
          'callback' => array( $this->cpt_callbacks, 'mmwcptwd_cpt_sanitize' )
        )
      );

      $this->settings->mmwcptwd_set_settings( $args );
    }

    public function mmwcptwd_set_sections()
    {
      $args = array(
        array(
          'id' => 'mmwcptwd_post_type_index',
          'title' => '',
          'callback' => array( $this->cpt_callbacks, 'mmwcptwd_cpt_section_manager' ),
          'page' => 'mmwcptwd_post_type_page'
        )
      );

      $this->settings->mmwcptwd_set_sections( $args );
    }
   
    public function mmwcptwd_set_fields()
    {
      $args = array(
        array(
          'id' => 'post_type',
          'title' => 'Post Type',
          'callback' => array( $this->cpt_callbacks, 'mmwcptwd_cpt_field' ),
          'page' => 'mmwcptwd_post_type_page',
          'section' => 'mmwcptwd_post_type_index',
          'args' => array(
            'option_name' => 'mmwcptwd_cpt',
            'label_for' => 'post_type',
            'placeholder' => 'eg. product (ID should be LOWERCASE. Don\'t change id when update.)',
            'array' => 'post_type',
            'required' => true,
            'default'  => '',
            'type' => 'text',
          )
        ),
        array(
          'id' => 'singular_name',
          'title' => 'Singular Name',
          'callback' => array( $this->cpt_callbacks, 'mmwcptwd_cpt_field' ),
          'page' => 'mmwcptwd_post_type_page',
          'section' => 'mmwcptwd_post_type_index',
          'args' => array(
            'option_name' => 'mmwcptwd_cpt',
            'label_for' => 'singular_name',
            'placeholder' => 'eg. Product',
            'array' => 'post_type',
            'required' => true,
            'default'  => '',
            'type' => 'text',
          )
        ),
        array(
          'id' => 'plural_name',
          'title' => 'Plural Name',
          'callback' => array( $this->cpt_callbacks, 'mmwcptwd_cpt_field' ),
          'page' => 'mmwcptwd_post_type_page',
          'section' => 'mmwcptwd_post_type_index',
          'args' => array(
            'option_name' => 'mmwcptwd_cpt',
            'label_for' => 'plural_name',
            'placeholder' => 'eg. Products',
            'array' => 'post_type',
            'required' => true,
            'default'  => '',
            'type' => 'text',
          )
        ),
        
        array(
          'id' => 'menu_icon',
          'title' => 'Icon Name',
          'callback' => array( $this->cpt_callbacks, 'mmwcptwd_cpt_field' ),
          'page' => 'mmwcptwd_post_type_page',
          'section' => 'mmwcptwd_post_type_index',
          'args' => array(
            'option_name' => 'mmwcptwd_cpt',
            'label_for' => 'menu_icon',
            'placeholder' => 'dashicons-admin-site',
            'array' => 'post_type',
            'required' => true,
            'default'  => '',
            'type' => 'text',
          )
        ),
        array(
          'id' => 'menu_position',
          'title' => 'Menu Position',
          'callback' => array( $this->cpt_callbacks, 'mmwcptwd_cpt_field' ),
          'page' => 'mmwcptwd_post_type_page',
          'section' => 'mmwcptwd_post_type_index',
          'args' => array(
            'option_name' => 'mmwcptwd_cpt',
            'label_for' => 'menu_position',
            'placeholder' => 'eg. 5',
            'array' => 'post_type',
            'required' => true,
            'default'  => '',
            'type' => 'select_menu_position',
          )
        ),
        array(
          'id' => 'public',
          'title' => 'Public',
          'callback' => array( $this->cpt_callbacks, 'mmwcptwd_cpt_field' ),
          'page' => 'mmwcptwd_post_type_page',
          'section' => 'mmwcptwd_post_type_index',
          'args' => array(
            'option_name' => 'mmwcptwd_cpt',
            'label_for' => 'public',
            'class' => 'ui-toggle',
            'array' => 'post_type',
            'required' => true,
            'default'  =>   1,
            'type' => 'checkbox',
          )
        ),
        array(
          'id' => 'title',
          'title' => 'Support Title',
          'callback' => array( $this->cpt_callbacks, 'mmwcptwd_cpt_field' ),
          'page' => 'mmwcptwd_post_type_page',
          'section' => 'mmwcptwd_post_type_index',
          'args' => array(
            'option_name' => 'mmwcptwd_cpt',
            'label_for' => 'title',
            'class' => 'ui-toggle',
            'array' => 'post_type',
            'required' => true,
            'default'  => 'title',
            'type' => 'checkbox',
          )
        ),
        array(
          'id' => 'editor',
          'title' => 'Support Editor',
          'callback' => array( $this->cpt_callbacks, 'mmwcptwd_cpt_field' ),
          'page' => 'mmwcptwd_post_type_page',
          'section' => 'mmwcptwd_post_type_index',
          'args' => array(
            'option_name' => 'mmwcptwd_cpt',
            'label_for' => 'editor',
            'class' => 'ui-toggle',
            'array' => 'post_type',
            'required' => true,
            'default'  => 'editor',
            'type' => 'checkbox',
          )
        ),
        array(
          'id' => 'author',
          'title' => 'Support Author',
          'callback' => array( $this->cpt_callbacks, 'mmwcptwd_cpt_field' ),
          'page' => 'mmwcptwd_post_type_page',
          'section' => 'mmwcptwd_post_type_index',
          'args' => array(
            'option_name' => 'mmwcptwd_cpt',
            'label_for' => 'author',
            'class' => 'ui-toggle',
            'array' => 'post_type',
            'required' => true,
            'default'  => 'author',
            'type' => 'checkbox',
          )
        ),
        array(
          'id' => 'thumbnail',
          'title' => 'Support Thumbnail',
          'callback' => array( $this->cpt_callbacks, 'mmwcptwd_cpt_field' ),
          'page' => 'mmwcptwd_post_type_page',
          'section' => 'mmwcptwd_post_type_index',
          'args' => array(
            'option_name' => 'mmwcptwd_cpt',
            'label_for' => 'thumbnail',
            'class' => 'ui-toggle',
            'array' => 'post_type',
            'required' => true,
            'default'  => 'thumbnail',
            'type' => 'checkbox',
          )
        ),
        array(
          'id' => 'excerpts',
          'title' => 'Support Excerpt',
          'callback' => array( $this->cpt_callbacks, 'mmwcptwd_cpt_field' ),
          'page' => 'mmwcptwd_post_type_page',
          'section' => 'mmwcptwd_post_type_index',
          'args' => array(
            'option_name' => 'mmwcptwd_cpt',
            'label_for' => 'excerpts',
            'class' => 'ui-toggle',
            'array' => 'post_type',
            'required' => true,
            'default'  => 'excerpt',
            'type' => 'checkbox',
          )
        ),
        array(
          'id' => 'custom_fields',
          'title' => 'Support Custom Fields',
          'callback' => array( $this->cpt_callbacks, 'mmwcptwd_cpt_field' ),
          'page' => 'mmwcptwd_post_type_page',
          'section' => 'mmwcptwd_post_type_index',
          'args' => array(
            'option_name' => 'mmwcptwd_cpt',
            'label_for' => 'custom_fields',
            'class' => 'ui-toggle',
            'array' => 'post_type',
            'required' => true,
            'default'  => 'custom-fields',
            'type' => 'checkbox',
          )
        ),
        array(
          'id' => 'comments',
          'title' => 'Support Comments',
          'callback' => array( $this->cpt_callbacks, 'mmwcptwd_cpt_field' ),
          'page' => 'mmwcptwd_post_type_page',
          'section' => 'mmwcptwd_post_type_index',
          'args' => array(
            'option_name' => 'mmwcptwd_cpt',
            'label_for' => 'comments',
            'class' => 'ui-toggle',
            'array' => 'post_type',
            'required' => true,
            'default'  => 'comments',
            'type' => 'checkbox',
          )
        ),
        array(
          'id' => 'taxonomies_value',
          'title' => 'Support Taxonomies',
          'callback' => array( $this->cpt_callbacks, 'mmwcptwd_cpt_field' ),
          'page' => 'mmwcptwd_post_type_page',
          'section' => 'mmwcptwd_post_type_index',
          'args' => array(
            'option_name' => 'mmwcptwd_cpt',
            'label_for' => 'taxonomies_value',
            'class' => 'ui-toggle',
            'array' => 'post_type',
            'required' => true,
            'default'  => 1,
            'type' => 'checkbox',
          )
        ),
        array(
          'id' => 'has_archive',
          'title' => 'Archive',
          'callback' => array( $this->cpt_callbacks, 'mmwcptwd_cpt_field' ),
          'page' => 'mmwcptwd_post_type_page',
          'section' => 'mmwcptwd_post_type_index',
          'args' => array(
            'option_name' => 'mmwcptwd_cpt',
            'label_for' => 'has_archive',
            'class' => 'ui-toggle',
            'array' => 'post_type',
            'required' => true,
            'default'  => 1,
            'type' => 'checkbox',
          )
        ),

        array(
          'id' => 'has_gutenberg',
          'title' => 'Gutenberg Editor',
          'callback' => array( $this->cpt_callbacks, 'mmwcptwd_cpt_field' ),
          'page' => 'mmwcptwd_post_type_page',
          'section' => 'mmwcptwd_post_type_index',
          'args' => array(
            'option_name' => 'mmwcptwd_cpt',
            'label_for' => 'has_gutenberg',
            'class' => 'ui-toggle',
            'array' => 'post_type',
            'required' => true,
            'default'  => 1,
            'type' => 'checkbox',
          )
        )
      );

      $this->settings->mmwcptwd_set_fields( $args );
    }

    public function mmwcptwd_store_custom_post_types()
    {
      $options = get_option( 'mmwcptwd_cpt' ) ?: array();

      foreach ($options as $option) {
        $title = isset($option["title"]) && !empty($option["title"]) ? $option["title"] : '';
        $editor = isset($option["editor"]) && !empty($option["editor"]) ? $option["editor"] : '';
        $author = isset($option["author"]) && !empty($option["author"]) ? $option["author"] : '';
        $thumbnail = isset($option["thumbnail"]) && !empty($option["thumbnail"]) ? $option["thumbnail"] : '';
        $excerpts = isset($option["excerpts"]) && !empty($option["excerpts"]) ? $option["excerpts"] : '';
        $custom_fields = isset($option["custom_fields"]) && !empty($option["custom_fields"]) ? $option["custom_fields"] : '';
        $comments = isset($option["comments"]) && !empty($option["comments"]) ? $option["comments"] : '';
        $menu_position = isset($option["menu_position"]) && !empty($option["menu_position"]) ? $option["menu_position"] : 5;
        $menu_icon = isset($option["menu_icon"]) && !empty($option["menu_icon"]) ? $option["menu_icon"] : 'dashicons-admin-site';
        $has_gutenberg = isset($option["has_gutenberg"]) && !empty($option['has_gutenberg']) && $option['has_gutenberg'] == 1  ? true : false;
        $taxonomies_value = isset($option["taxonomies_value"]) && !empty($option['taxonomies_value']) && $option['taxonomies_value'] == 1  ? array( 'category', 'post_tag' ) : array( '' );

        $this->custom_post_types[] = array(
          'post_type'             => __($option['post_type'], 'mmwcptwd'),
          'name'                  => __($option['plural_name'], 'mmwcptwd'),
          'singular_name'         => __(ucwords($option['singular_name']), 'mmwcptwd'),
          'menu_name'             => __($option['plural_name'], 'mmwcptwd'),
          'name_admin_bar'        => __(ucwords($option['singular_name']), 'mmwcptwd'),
          'archives'              => __(ucwords($option['singular_name']) . ' Archives', 'mmwcptwd'),
          'attributes'            => __(ucwords($option['singular_name']) . ' Attributes', 'mmwcptwd'),
          'parent_item_colon'     => __('Parent ' . ucwords($option['singular_name']), 'mmwcptwd'),
          'all_items'             => __('All ' . ucwords($option['plural_name']), 'mmwcptwd'),
          'add_new_item'          => __('Add New ' . ucwords($option['singular_name']), 'mmwcptwd'),
          'add_new'               => __('Add New', 'mmwcptwd'),
          'new_item'              => __('New ' . ucwords($option['singular_name']), 'mmwcptwd'),
          'edit_item'             => __('Edit ' . ucwords($option['singular_name']), 'mmwcptwd'),
          'update_item'           => __('Update ' . ucwords($option['singular_name']), 'mmwcptwd'),
          'view_item'             => __('View ' . ucwords($option['singular_name']), 'mmwcptwd'),
          'view_items'            => __('View ' . ucwords($option['plural_name']), 'mmwcptwd'),
          'search_items'          => __('Search ' . ucwords($option['plural_name']), 'mmwcptwd'),
          'not_found'             => __('No ' . ucwords($option['singular_name']) . ' Found', 'mmwcptwd'),
          'not_found_in_trash'    => __('No ' . ucwords($option['singular_name']) . ' Found in Trash', 'mmwcptwd'),
          'featured_image'        => __( ucwords($option['singular_name']).' Featured Image', 'mmwcptwd'),
          'set_featured_image'    => __('Set '.ucwords($option['singular_name']).' Featured Image', 'mmwcptwd'),
          'remove_featured_image' => __('Remove '.ucwords($option['singular_name']).' Featured Image', 'mmwcptwd'),
          'use_featured_image'    => __('Use '.ucwords($option['singular_name']).' Featured Image', 'mmwcptwd'),
          'insert_into_item'      => __('Insert into ' . ucwords($option['singular_name']), 'mmwcptwd'),
          'uploaded_to_this_item' => __('Upload to this ' . ucwords($option['singular_name']), 'mmwcptwd'),
          'items_list'            => __(ucwords($option['plural_name']) . ' List', 'mmwcptwd'),
          'items_list_navigation' => __(ucwords($option['plural_name']) . ' List Navigation', 'mmwcptwd'),
          'filter_items_list'     => __('Filter' . ucwords($option['plural_name']) . ' List', 'mmwcptwd'),
          'label'                 => __(ucwords($option['singular_name']), 'mmwcptwd'),
          'description'           => __(ucwords($option['plural_name']) . 'Custom Post Type', 'mmwcptwd'),
          'supports'              => array( $title,$editor,$author,$thumbnail,$excerpts,$custom_fields,$comments ),
          'show_in_rest'          => $has_gutenberg,
          'taxonomies'            => $taxonomies_value,
          'hierarchical'          => false,
          'public'                => isset($option['public']) ?: false,
          'show_ui'               => true,
          'show_in_menu'          => true,
          'menu_position'         => $menu_position,
          'menu_icon'             => $menu_icon,
          'show_in_admin_bar'     => true,
          'show_in_nav_menus'     => true,
          'can_export'            => true,
          'has_archive'           => isset($option['has_gutenberg']) ?: false,
          'exclude_from_search'   => false,
          'publicly_queryable'    => true,
          'capability_type'       => 'post'
        );
      }
    }

    public function mmwcptwd_register_custom_post_types()
    {
      foreach ($this->custom_post_types as $post_type) {
        register_post_type( $post_type['post_type'],
          array(
            'labels' => array(
              'name'                  => _x($post_type['name'], 'Post type general name', 'mmwcptwd'),
              'singular_name'         => _x($post_type['singular_name'], 'Post type singular name', 'mmwcptwd'),
              'menu_name'             => _x($post_type['menu_name'], 'Admin Menu text', 'mmwcptwd'),
              'name_admin_bar'        => _x($post_type['name_admin_bar'], 'Add New on Toolbar', 'mmwcptwd'),
              'add_new'               => __($post_type['add_new'], 'mmwcptwd'),
              'add_new_item'          => __($post_type['add_new_item'], 'mmwcptwd'),
              'new_item'              => __($post_type['new_item'], 'mmwcptwd'),
              'edit_item'             => __($post_type['edit_item'], 'mmwcptwd'),
              'view_item'             => __($post_type['view_item'], 'mmwcptwd'),
              'view_items'            => __($post_type['view_items'], 'mmwcptwd'),
              'all_items'             => __($post_type['all_items'], 'mmwcptwd'),
              'search_items'          => __($post_type['search_items'], 'mmwcptwd'),
              'parent_item_colon'     => __($post_type['parent_item_colon'], 'mmwcptwd'),
              'not_found'             => __($post_type['not_found'],'mmwcptwd'),
              'not_found_in_trash'    => __($post_type['not_found_in_trash'],'mmwcptwd'),
              'featured_image'        => _x($post_type['featured_image'], 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'mmwcptwd'),
              'set_featured_image'    => _x($post_type['set_featured_image'], 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'mmwcptwd'),
              'remove_featured_image' => _x($post_type['remove_featured_image'], 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'mmwcptwd'),
              'use_featured_image'    => _x($post_type['use_featured_image'], 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'mmwcptwd'),
              'archives'              => _x($post_type['archives'], 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'mmwcptwd'),
              'insert_into_item'      => _x($post_type['insert_into_item'], 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'mmwcptwd'),
              'uploaded_to_this_item' => _x($post_type['uploaded_to_this_item'], 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'mmwcptwd'),
              'filter_items_list'     => _x($post_type['filter_items_list'], 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'mmwcptwd'),
              'items_list_navigation' => _x($post_type['items_list_navigation'], 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'mmwcptwd'),
              'items_list'            => _x($post_type['items_list'], 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'mmwcptwd'),
              'attributes'            => __($post_type['attributes'], 'mmwcptwd'),
              'update_item'           => __($post_type['update_item'], 'mmwcptwd'),
              

            ),
            'label'                     => $post_type['label'],
            'description'               => __($post_type['description'], 'mmwcptwd'),
            'supports'                  => $post_type['supports'],
            'show_in_rest'              => $post_type['show_in_rest'],
            'taxonomies'                => $post_type['taxonomies'],
            'hierarchical'              => $post_type['hierarchical'],
            'public'                    => $post_type['public'],
            'show_ui'                   => $post_type['show_ui'],
            'show_in_menu'              => $post_type['show_in_menu'],
            'menu_position'             => $post_type['menu_position'],
            'menu_icon'                 => $post_type['menu_icon'],
            'show_in_admin_bar'         => $post_type['show_in_admin_bar'],
            'show_in_nav_menus'         => $post_type['show_in_nav_menus'],
            'can_export'                => $post_type['can_export'],
            'has_archive'               => $post_type['has_archive'],
            'exclude_from_search'       => $post_type['exclude_from_search'],
            'publicly_queryable'        => $post_type['publicly_queryable'],
            'capability_type'           => $post_type['capability_type']
          )
        );
      }
    }
  }
endif;
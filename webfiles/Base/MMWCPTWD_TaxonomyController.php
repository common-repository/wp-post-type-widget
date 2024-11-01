<?php 
/**
 * @package  getwebPlugin
 */
namespace rsCustomPost\Base;

use rsCustomPost\Api\MMWCPTWD_SettingsApi;
use rsCustomPost\Base\MMWCPTWD_BaseController;
use rsCustomPost\Api\Callbacks\MMWCPTWD_AdminCallbacks;
use rsCustomPost\Api\Callbacks\MMWCPTWD_TaxonomyCallbacks;

/**
* 
*/
if(!class_exists('MMWCPTWD_TaxonomyController')):
	class MMWCPTWD_TaxonomyController extends MMWCPTWD_BaseController
	{
		public $settings;

		public $callbacks;

		public $tax_callbacks;

		public $subpages = array();

		public $taxonomies = array();

		public function mmwcptwd_register()
		{
			if ( ! $this->mmwcptwd_activated( 'taxonomy_manager' ) ) return;
			if ( ! $this->mmwcptwd_last_code() ) return;
			if ( ! $this->mmwcptwd_wp_version_check() ) return;

			$this->settings = new MMWCPTWD_SettingsApi();

			$this->callbacks = new MMWCPTWD_AdminCallbacks();

			$this->tax_callbacks = new MMWCPTWD_TaxonomyCallbacks();

			$this->mmwcptwd_set_sub_pages();

			$this->mmwcptwd_set_settings();

			$this->mmwcptwd_set_sections();

			$this->mmwcptwd_set_fields();

			$this->settings->mmwcptwd_add_sub_pages( $this->subpages )->mmwcptwd_register();

			$this->mmwcptwd_store_custom_taxonomies();

			$options = get_option( 'mmwcptwd_tax' ) ?: array();
			foreach ($options as $option) {
				if ( isset($option['has_image']) && $option['has_image'] == 1 ) {
					add_action( "{$option['taxonomy']}_add_form_fields", array ( $this, 'mmwcptwd_add_taxonomies_category_image' ), 10, 2 );
					add_action( 'admin_footer', array ( $this, 'mmwcptwd_add_script' ) );
					add_action( "created_{$option['taxonomy']}", array ( $this, 'mmwcptwd_save_taxonomies_category_image' ), 10, 2 );
					add_action( "{$option['taxonomy']}_edit_form_fields", array ( $this, 'mmwcptwd_update_taxonomies_category_image' ), 10, 2 );
					add_filter( "manage_edit-{$option['taxonomy']}_columns",  array ( $this, 'mmwcptwd_add_taxonomi_img_column') );
					add_filter( "manage_{$option['taxonomy']}_custom_column",  array ( $this, 'mmwcptwd_show_taxonomi_img_in_column'), 10, 3 );
					add_action( 'admin_enqueue_scripts', array( $this, 'mmwcptwd_load_media' ) );
				}
			}
			

			if ( ! empty( $this->taxonomies ) ) {
				add_action( 'init', array( $this, 'mmwcptwd_register_custom_taxonomy' ));
			}
		}

		public function mmwcptwd_set_sub_pages()
		{
			$this->subpages = array(
				array(
					'parent_slug' => 'mmwcptwd', 
					'page_title' => 'Manage Taxonomies', 
					'menu_title' => 'Manage Taxonomies', 
					'capability' => 'manage_options', 
					'menu_slug' => 'mmwcptwd-taxonomy', 
					'callback' => array( $this->callbacks, 'mmwcptwd_admin_taxonomy' )
				)
			);
		}

		public function mmwcptwd_set_settings()
		{
			$args = array(
				array(
					'option_group' => 'mmwcptwd_taxonomy_settings',
					'option_name' => 'mmwcptwd_tax',
					'callback' => array($this->tax_callbacks, 'mmwcptwd_tax_sanitize')
				)
			);

			$this->settings->mmwcptwd_set_settings( $args );
		}

		public function mmwcptwd_set_sections()
		{
			$args = array(
				array(
					'id' => 'mmwcptwd_taxonomy_index',
					'title' => '',
					'callback' => '',
					'page' => 'mmwcptwd_taxonomy_page'
				)
			);

			$this->settings->mmwcptwd_set_sections( $args );
		}

		public function mmwcptwd_set_fields()
		{
			$args = array(
				array(
					'id' => 'taxonomy',
					'title' => 'Taxonomy ID',
					'callback' => array($this->tax_callbacks, 'mmwcptwd_taxonomy_field'),
					'page' => 'mmwcptwd_taxonomy_page',
					'section' => 'mmwcptwd_taxonomy_index',
					'args' => array(
						'option_name' => 'mmwcptwd_tax',
						'label_for' => 'taxonomy',
						'placeholder' => 'Ex. product (ID should be LOWERCASE. Don\'t change id when update.)',
						'array' => 'taxonomy',
						'required' => true,
						'default'  => '',
	          			'type' => 'text',
					)
				),
				array(
					'id' => 'singular_name',
					'title' => 'Singular Name',
					'callback' => array( $this->tax_callbacks, 'mmwcptwd_taxonomy_field' ),
					'page' => 'mmwcptwd_taxonomy_page',
					'section' => 'mmwcptwd_taxonomy_index',
					'args' => array(
						'option_name' => 'mmwcptwd_tax',
						'label_for' => 'singular_name',
						'placeholder' => 'Ex. Product',
						'array' => 'taxonomy',
						'required' => true,
						'default'  => '',
	          			'type' => 'text',
					)
				),
				array(
					'id' => 'hierarchical',
					'title' => 'Hierarchical',
					'callback' => array( $this->tax_callbacks, 'mmwcptwd_taxonomy_field' ),
					'page' => 'mmwcptwd_taxonomy_page',
					'section' => 'mmwcptwd_taxonomy_index',
					'args' => array(
						'option_name' => 'mmwcptwd_tax',
						'label_for' => 'hierarchical',
						'class' => 'ui-toggle',
						'array' => 'taxonomy',
						'required' => true,
						'default'  =>   1,
	          			'type' => 'checkbox',
					)
				),
				array(
					'id' => 'has_gutenberg',
					'title' => 'Gutenberg Editor',
					'callback' => array( $this->tax_callbacks, 'mmwcptwd_taxonomy_field' ),
					'page' => 'mmwcptwd_taxonomy_page',
					'section' => 'mmwcptwd_taxonomy_index',
					'args' => array(
						'option_name' => 'mmwcptwd_tax',
						'label_for' => 'has_gutenberg',
						'class' => 'ui-toggle',
						'array' => 'taxonomy',
						'required' => true,
						'default'  =>   1,
	          			'type' => 'checkbox',
					)
				),
				array(
					'id' => 'has_image',
					'title' => 'Upload Taxonomy Image',
					'callback' => array( $this->tax_callbacks, 'mmwcptwd_taxonomy_field' ),
					'page' => 'mmwcptwd_taxonomy_page',
					'section' => 'mmwcptwd_taxonomy_index',
					'args' => array(
						'option_name' => 'mmwcptwd_tax',
						'label_for' => 'has_image',
						'class' => 'ui-toggle',
						'array' => 'taxonomy',
						'required' => true,
						'default'  =>   1,
	          			'type' => 'checkbox',
					)
				),
				array(
					'id' => 'objects',
					'title' => 'Post Types',
					'callback' => array( $this->tax_callbacks, 'mmwcptwd_taxonomy_field' ),
					'page' => 'mmwcptwd_taxonomy_page',
					'section' => 'mmwcptwd_taxonomy_index',
					'args' => array(
						'option_name' => 'mmwcptwd_tax',
						'label_for' => 'objects',
						'class' => 'ui-toggle',
						'array' => 'taxonomy',
						'required' => true,
						'default'  =>   1,
	          			'type' => 'post_checkbox',
					)
				)
			);

			$this->settings->mmwcptwd_set_fields( $args );
		}

		public function mmwcptwd_store_custom_taxonomies()
		{
			$options = get_option( 'mmwcptwd_tax' ) ?: array();

			foreach ($options as $option) {
				if (isset($option['has_gutenberg']) && !empty($option['has_gutenberg'])) {
					
				}
				$labels = array(
					'name'              => _x($option['singular_name'], 'taxonomy general name', 'mmwcptwd'),
					'singular_name'     => _x($option['singular_name'], 'taxonomy singular name', 'mmwcptwd'),
					'search_items'      => __('Search ' . ucwords($option['singular_name']), 'mmwcptwd'),
					'all_items'         => __('All ' . ucwords($option['singular_name']), 'mmwcptwd'),
					'parent_item'       => __('Parent ' . ucwords($option['singular_name']), 'mmwcptwd'),
					'parent_item_colon' => __('Parent ' . ucwords($option['singular_name']) . ':', 'mmwcptwd'),
					'edit_item'         => __('Edit ' . ucwords($option['singular_name']), 'mmwcptwd'),
					'update_item'       => __('Update ' . ucwords($option['singular_name']), 'mmwcptwd'),
					'add_new_item'      => __('Add New ' . ucwords($option['singular_name']), 'mmwcptwd'),
					'new_item_name'     => __('New ' . ucwords($option['singular_name']) . ' Name', 'mmwcptwd'),
					'menu_name'         => __(ucwords($option['singular_name']), 'mmwcptwd'),
				);

				$this->taxonomies[] = array(
					'hierarchical'      => isset($option['hierarchical']) ? true : false,
					'labels'            => $labels,
					'show_ui'           => true,
					'show_admin_column' => true,
					'show_in_rest'      => isset($option['has_gutenberg']) && $option['has_gutenberg'] == 1  ? true : false,
					'query_var'         => true,
					'rewrite'           => array( 'slug' => $option['taxonomy'] ),
					'objects'           => isset($option['objects']) ? $option['objects'] : null
				);

			}
		}

		public function mmwcptwd_register_custom_taxonomy()
		{
			foreach ($this->taxonomies as $taxonomy) {
				$objects = isset($taxonomy['objects']) ? array_keys($taxonomy['objects']) : null;
				register_taxonomy( $taxonomy['rewrite']['slug'], $objects, $taxonomy );
			}
		}
		public function mmwcptwd_add_taxonomies_category_image( $taxonomy ) { ?>
		   <div class="form-field term-group">
		     <label for="cpt-taxonomy-image"><?php _e('Image', 'mmwcptwd'); ?></label>
		     <input type="hidden" id="cpt-taxonomy-image" name="cpt-taxonomy-image" class="custom_media_url" value="">
		     <div id="category-image-wrapper"></div>
		     <p>
		       <input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php _e( 'Add Image', 'mmwcptwd' ); ?>" />
		       <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php _e( 'Remove Image', 'mmwcptwd' ); ?>" />
		    </p>
		   </div>
	 <?php
	 }
	 public function mmwcptwd_add_script() { ?>
	   <script>
	     jQuery(document).ready( function($) {
	       function mmwcptwd_media_upload(button_class) {
	         var _custom_media = true,
	         _orig_send_attachment = wp.media.editor.send.attachment;
	         $('body').on('click', button_class, function(e) {
	           var button_id = '#'+$(this).attr('id');
	           var send_attachment_bkp = wp.media.editor.send.attachment;
	           var button = $(button_id);
	           _custom_media = true;
	           wp.media.editor.send.attachment = function(props, attachment){
	             if ( _custom_media ) {
	               $('#cpt-taxonomy-image').val(attachment.id);
	               $('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
	               $('#category-image-wrapper .custom_media_image').attr('src',attachment.url).css('display','block');
	             } else {
	               return _orig_send_attachment.apply( button_id, [props, attachment] );
	             }
	            }
	         wp.media.editor.open(button);
	         return false;
	       });
	     }
	     mmwcptwd_media_upload('.ct_tax_media_button.button'); 
	     $('body').on('click','.ct_tax_media_remove',function(){
	       $('#cpt-taxonomy-image').val('');
	       $('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
	     });
	     $(document).ajaxComplete(function(event, xhr, settings) {
	       var queryStringArr = settings.data.split('&');
	       if( $.inArray('action=add-tag', queryStringArr) !== -1 ){
	         var xml = xhr.responseXML;
	         $response = $(xml).find('term_id').text();
	         if($response!=""){
	           $('#category-image-wrapper').html('');
	         }
	       }
	     });
	   });
	 </script>
	 <?php }
	 public function mmwcptwd_save_taxonomies_category_image ( $term_id, $tt_id ) {
	   if( isset( $_POST['cpt-taxonomy-image'] ) && '' !== $_POST['cpt-taxonomy-image'] ){
	     $image = $_POST['cpt-taxonomy-image'];
	     add_term_meta( $term_id, 'cpt-taxonomy-image', $image, true );
	   }
	 }
	  public function mmwcptwd_update_taxonomies_category_image ( $term, $taxonomy ) { ?>
	   <tr class="form-field term-group-wrap">
	     <th scope="row">
	       <label for="cpt-taxonomy-image"><?php _e( 'Image', 'mmwcptwd' ); ?></label>
	     </th>
	     <td>
	       <?php $image_id = get_term_meta ( $term->term_id, 'cpt-taxonomy-image', true ); ?>
	       <input type="hidden" id="cpt-taxonomy-image" name="cpt-taxonomy-image" value="<?php echo $image_id; ?>">
	       <div id="category-image-wrapper">
	         <?php if ( $image_id ) { ?>
	           <?php echo wp_get_attachment_image( $image_id, 'thumbnail' ); ?>
	         <?php } ?>
	       </div>
	       <p>
	         <input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php _e( 'Add Image', 'cpt' ); ?>" />
	         <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php _e( 'Remove Image', 'cpt' ); ?>" />
	       </p>
	     </td>
	   </tr>
	 <?php
	 }
	 public function mmwcptwd_load_media() {
	     wp_enqueue_media();
	   }
	   
	  public function mmwcptwd_add_taxonomi_img_column( $columns ){
	    $columns['taxonomy_image'] = __( 'Image', 'mmwcptwd' );
	    return $columns;
	}
	public function mmwcptwd_show_taxonomi_img_in_column( $image, $column_name, $term_id ){
	    global $feature_groups;
		if( $column_name !== 'taxonomy_image' ){
		        return $image;
		    }

		    $term_id = absint( $term_id );
		    $image_meta = get_term_meta( $term_id, 'cpt-taxonomy-image', true );
		    $image_url = wp_get_attachment_image_url( $image_meta, 'thumbnail' );

		    if( !empty( $image_meta ) ){
		        $image .=  "<img src=\"{$image_url}\" width=\"50\" height=\"50\"/>";
		    }
		    return $image;
		}
	}
endif;
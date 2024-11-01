<?php 
/**
 * @package  getwebPlugin
 */
namespace rsCustomPost\Base;

use rsCustomPost\Api\MMWCPTWD_SettingsApi;
use rsCustomPost\Base\MMWCPTWD_BaseController;
use rsCustomPost\Api\Callbacks\MMWCPTWD_WidgetCallbacks;
use rsCustomPost\Api\Callbacks\MMWCPTWD_AdminCallbacks;

/**
* 
*/

if(!class_exists('MMWCPTWD_WidgetController')):
	class MMWCPTWD_WidgetController extends MMWCPTWD_BaseController
	{
		public $settings;

		public $callbacks;

		public $cwm_callbacks;

		public $subpages = array();

		public $custom_post_types = array();

		public function mmwcptwd_register()
		{
			if ( ! $this->mmwcptwd_activated( 'widget_manager' ) ) return;
			if ( ! $this->mmwcptwd_last_code() ) return;
			if ( ! $this->mmwcptwd_wp_version_check() ) return;
			
			$this->settings = new MMWCPTWD_SettingsApi();

			$this->callbacks = new MMWCPTWD_AdminCallbacks();

			$this->cwm_callbacks = new MMWCPTWD_WidgetCallbacks();

			$this->mmwcptwd_set_sub_pages();

			$this->mmwcptwd_set_settings();

			$this->mmwcptwd_set_sections();

			$this->mmwcptwd_set_fields();

			$this->settings->mmwcptwd_add_sub_pages( $this->subpages )->mmwcptwd_register();

			$this->mmwcptwd_store_custom_widget();

	        if (! empty($this->mmwcptwd_custom_widget_types)) {
	            add_action('widgets_init', array( &$this, 'mmwcptwd_register_custom_widget'), 1000);
	        }
		}

		public function mmwcptwd_set_sub_pages()
		{
			$this->subpages = array(
				array(
					'parent_slug' => 'mmwcptwd', 
					'page_title' => 'Manage Widget', 
					'menu_title' => 'Manage Widget', 
					'capability' => 'manage_options', 
					'menu_slug' => 'mmwcptwd-widgets', 
					'callback' => array( $this->callbacks, 'mmwcptwd_admin_widget' )
				),
			);
		}

		public function mmwcptwd_set_settings()
		{
			$args = array(
				array(
					'option_group' => 'mmwcptwd_admin_widget_settings',
					'option_name' => 'mmwcptwd_cwm',
					'callback' => array( $this->cwm_callbacks, 'mmwcptwd_cwm_sanitize' )
				),
				
			);

			$this->settings->mmwcptwd_set_settings( $args );
		}

		public function mmwcptwd_set_sections()
		{
			$args = array(
				array(
					'id' => 'mmwcptwd_admin_widget_index',
					'title' => '',
					'callback' => '',
					'page' => 'mmwcptwd_admin_widget_page'
				),
				
			);

			$this->settings->mmwcptwd_set_sections( $args );
		}

		public function mmwcptwd_set_fields()
		{
			$args = array(
				array(
					'id' => 'widget_id',
					'title' => 'Widget ID',
					'callback' => array( $this->cwm_callbacks, 'mmwcptwd_widget_field' ),
					'page' => 'mmwcptwd_admin_widget_page',
					'section' => 'mmwcptwd_admin_widget_index',
					'args' => array(
						'option_name' => 'mmwcptwd_cwm',
						'label_for' => 'widget_id',
						'placeholder' => 'eg. Widget ID  (ID should be LOWERCASE. Don\'t change id when update.)',
						'array' => 'cwm_name',
						'required' => true,
						'default'  => '',
	          			'type' => 'text',
					)
				),

				array(
					'id' => 'cwm_name',
					'title' => 'Widget Name',
					'callback' => array( $this->cwm_callbacks, 'mmwcptwd_widget_field' ),
					'page' => 'mmwcptwd_admin_widget_page',
					'section' => 'mmwcptwd_admin_widget_index',
					'args' => array(
						'option_name' => 'mmwcptwd_cwm',
						'label_for' => 'cwm_name',
						'placeholder' => 'eg. Widget Name',
						'array' => 'cwm_name',
						'required' => true,
						'default'  => '',
	          			'type' => 'text',
					)
				),
				
				array(
					'id' => 'description',
					'title' => 'Description',
					'callback' => array( $this->cwm_callbacks, 'mmwcptwd_widget_field' ),
					'page' => 'mmwcptwd_admin_widget_page',
					'section' => 'mmwcptwd_admin_widget_index',
					'args' => array(
						'option_name' => 'mmwcptwd_cwm',
						'label_for' => 'description',
						'placeholder' => 'eg. Widget Description',
						'array' => 'cwm_name',
						'required' => true,
						'default'  => '',
	          			'type' => 'text',
					)
	            ),
				array(
					'id' => 'class',
					'title' => 'Widget Class',
					'callback' => array( $this->cwm_callbacks, 'mmwcptwd_widget_field' ),
					'page' => 'mmwcptwd_admin_widget_page',
					'section' => 'mmwcptwd_admin_widget_index',
					'args' => array(
						'option_name' => 'mmwcptwd_cwm',
						'label_for' => 'class',
						'placeholder' => 'eg. Widget Class',
						'array' => 'cwm_name',
						'required' => true,
						'default'  => '',
	          			'type' => 'text',
					)
	            ),
				array(
					'id' => 'before_widget',
					'title' => 'Before Widget Class',
					'callback' => array( $this->cwm_callbacks, 'mmwcptwd_widget_field' ),
					'page' => 'mmwcptwd_admin_widget_page',
					'section' => 'mmwcptwd_admin_widget_index',
					'args' => array(
						'option_name' => 'mmwcptwd_cwm',
						'label_for' => 'before_widget',
						'placeholder' => 'eg. Before Widget',
						'array' => 'cwm_name',
						'required' => true,
						'default'  => '',
	          			'type' => 'text',
					)
	            ),
	            array(
					'id' => 'before_title',
					'title' => 'Before Title Class',
					'callback' => array( $this->cwm_callbacks, 'mmwcptwd_widget_field' ),
					'page' => 'mmwcptwd_admin_widget_page',
					'section' => 'mmwcptwd_admin_widget_index',
					'args' => array(
						'option_name' => 'mmwcptwd_cwm',
						'label_for' => 'before_title',
						'placeholder' => 'eg. Before Title',
						'array' => 'cwm_name',
						'required' => true,
						'default'  => '',
	          			'type' => 'text',
					)
	            ),
			);

			$this->settings->mmwcptwd_set_fields( $args );
		}

		public function mmwcptwd_store_custom_widget()
		{
			$options = get_option( 'mmwcptwd_cwm' ) ?: array();
			foreach ($options as $option) {
	            $this->mmwcptwd_custom_widget_types[] =  array(
					'name'          => __($option['cwm_name'], 'mmwcptwd'),
	                'id'            => esc_attr( $option['widget_id'] ),    // ID should be LOWERCASE  ! ! !
	                'description'   => __(!empty($option['description']) ? $option['description'] : '', 'mmwcptwd'),
	                'class'         => esc_attr( !empty($option['class']) ? $option['class'] : '' ),
	                'before_widget' => esc_attr( $option["before_widget"] ),
	                'after_widget'  => '</div></div></div>',
	                'before_title'  => esc_attr( $option["before_title"] ),
	                'after_title'   => '</h3></div>',
	            );
	            
	        }
	        
		}

		public function mmwcptwd_register_custom_widget()
		{
			$options = get_option( 'mmwcptwd_cwm' ) ?: array();
			foreach ( $options as $cwm_name) {
				$args['name']          = __($cwm_name['cwm_name'], 'mmwcptwd');
				$args['id']            = esc_attr( $cwm_name['widget_id'] );    // ID should be LOWERCASE  ! ! !
				$args['description']   = __(!empty($cwm_name['description']) ? $cwm_name['description'] : '', 'mmwcptwd');
				$args['class']         = esc_attr( !empty($cwm_name['class']) ? $cwm_name['class'] : '' );
				$args['before_widget'] = '<div class="widget %2$s clearfix '.esc_attr($cwm_name["before_widget"]).'"><div class="mmwdcptwd-widgets-wrapper"><div class="mmwdcptwd-tiltle">';
				$args['after_widget']  = '</div></div></div>';
				$args['before_title']  = '<div class="widget-title '.esc_attr($cwm_name["before_title"]).'"><h3 class="mmwdcptwd-block-title">';
				$args['after_title']   = '</h3></div>';
				register_sidebar( $args );
			}
		}
	}
endif;
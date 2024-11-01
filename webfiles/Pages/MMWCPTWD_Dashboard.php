<?php 
/**
 * @package  getwebPlugin
 */
namespace rsCustomPost\Pages;

use rsCustomPost\Api\MMWCPTWD_SettingsApi;
use rsCustomPost\Base\MMWCPTWD_BaseController;
use rsCustomPost\Api\Callbacks\MMWCPTWD_AdminCallbacks;
use rsCustomPost\Api\Callbacks\MMWCPTWD_ManagerCallbacks;

class MMWCPTWD_Dashboard extends MMWCPTWD_BaseController
{
	public $settings;

	public $admin_callbacks;

	public $manage_callbacks;

	public $pages = array();

	public function mmwcptwd_register()
	{
	  if ( ! $this->mmwcptwd_last_code() ) return;
      if ( ! $this->mmwcptwd_wp_version_check() ) return;
      
		$this->settings = new MMWCPTWD_SettingsApi();

		$this->admin_callbacks = new MMWCPTWD_AdminCallbacks();

		$this->manage_callbacks = new MMWCPTWD_ManagerCallbacks();
		
		$this->mmwcptwd_set_pages();
		$this->mmwcptwd_set_settings();
		$this->mmwcptwd_set_sections();
		$this->mmwcptwd_set_fields();

		$this->settings->mmwcptwd_add_pages( $this->pages )->mmwcptwd_with_sub_page( 'Settings' )->mmwcptwd_register();
	}

	public function mmwcptwd_set_pages() 
	{
		$this->pages = array(
			array(
				'page_title' => 'MMWCPTWD Settings', 
				'menu_title' => 'WP CPT', 
				'capability' => 'manage_options', 
				'menu_slug' => 'mmwcptwd', 
				'callback' => array( $this->admin_callbacks, 'mmwcptwd_admin_settings' ), 
				'icon_url' => 'dashicons-plus', 
				'position' => 110
			)
		);
	}

	public function mmwcptwd_set_settings()
	{
		$args = array(
			array(
				'option_group' => 'mmwcptwd_admin_settings',
				'option_name' => 'mmwcptwd_options',
				'callback' => array( $this->manage_callbacks, 'mmwcptwd_checkbox_sanitize' )
			)
		);

		$this->settings->mmwcptwd_set_settings( $args );
	}

	public function mmwcptwd_set_sections()
	{
		$args = array(
			array(
				'id' => 'mmwcptwd_admin_index',
				'title' => '',
				'callback' => array( $this->manage_callbacks, 'mmwcptwd_admin_section_manager' ),
				'page' => 'mmwcptwd_admin_page'
			)
		);

		$this->settings->mmwcptwd_set_sections( $args );
	}

	public function mmwcptwd_set_fields()
	{
		$args = array();

		foreach ( $this->managers as $key => $value ) {
			$args[] = array(
				'id' => $key,
				'title' => $value,
				'callback' => array( $this->manage_callbacks, 'mmwcptwd_checkbox_field' ),
				'page' => 'mmwcptwd_admin_page',
				'section' => 'mmwcptwd_admin_index',
				'args' => array(
					'option_name' => 'mmwcptwd_options',
					'label_for' => $key,
					'class' => 'ui-toggle',
					'default'  =>   1,
          			'input_type' => 'checkbox',
				)
			);
		}

		$this->settings->mmwcptwd_set_fields( $args );
	}
}
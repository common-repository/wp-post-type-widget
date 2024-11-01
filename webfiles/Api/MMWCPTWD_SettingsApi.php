<?php 
/**
 * @package  getwebPlugin
 */
namespace rsCustomPost\Api;
if(!class_exists('MMWCPTWD_SettingsApi')):
class MMWCPTWD_SettingsApi
{
	public $mmwcptwd_admin_pages = array();

	public $mmwcptwd_admin_sub_pages = array();

	public $settings = array();

	public $sections = array();

	public $fields = array();

	public function mmwcptwd_register()
	{
		if ( ! empty($this->mmwcptwd_admin_pages) || ! empty($this->mmwcptwd_admin_sub_pages) ) {
			add_action( 'admin_menu', array( $this, 'mmwcptwd_add_admin_menu' ) );
		}

		if ( !empty($this->settings) ) {
			add_action( 'admin_init', array( $this, 'mmwcptwd_register_custom_fields' ) );
		}
	}

	public function mmwcptwd_add_pages( array $pages )
	{
		$this->mmwcptwd_admin_pages = $pages;

		return $this;
	}

	public function mmwcptwd_with_sub_page( string $title = null ) 
	{
		if ( empty($this->mmwcptwd_admin_pages) ) {
			return $this;
		}

		$admin_page = $this->mmwcptwd_admin_pages[0];

		$subpage = array(
			array(
				'parent_slug' => $admin_page['menu_slug'], 
				'page_title' => $admin_page['page_title'], 
				'menu_title' => ($title) ? $title : $admin_page['menu_title'], 
				'capability' => $admin_page['capability'], 
				'menu_slug' => $admin_page['menu_slug'], 
				'callback' => $admin_page['callback']
			)
		);

		$this->mmwcptwd_admin_sub_pages = $subpage;

		return $this;
	}

	public function mmwcptwd_add_sub_pages( array $pages )
	{
		$this->mmwcptwd_admin_sub_pages = array_merge( $this->mmwcptwd_admin_sub_pages, $pages );

		return $this;
	}

	public function mmwcptwd_add_admin_menu()
	{
		foreach ( $this->mmwcptwd_admin_pages as $page ) {
			add_menu_page( $page['page_title'], $page['menu_title'], $page['capability'], $page['menu_slug'], $page['callback'], $page['icon_url'], $page['position'] );
		}

		foreach ( $this->mmwcptwd_admin_sub_pages as $page ) {
			add_submenu_page( $page['parent_slug'], $page['page_title'], $page['menu_title'], $page['capability'], $page['menu_slug'], $page['callback'] );
		}
	}

	public function mmwcptwd_set_settings( array $settings )
	{
		$this->settings = $settings;

		return $this;
	}

	public function mmwcptwd_set_sections( array $sections )
	{
		$this->sections = $sections;

		return $this;
	}

	public function mmwcptwd_set_fields( array $fields )
	{
		$this->fields = $fields;

		return $this;
	}

	public function mmwcptwd_register_custom_fields()
	{
		// register setting
		foreach ( $this->settings as $setting ) {
			register_setting( $setting["option_group"], $setting["option_name"], ( isset( $setting["callback"] ) ? $setting["callback"] : '' ) );
		}

		// add settings section
		foreach ( $this->sections as $section ) {
			add_settings_section( $section["id"], $section["title"], ( isset( $section["callback"] ) ? $section["callback"] : '' ), $section["page"] );
		}

		// add settings field
		foreach ( $this->fields as $field ) {
			add_settings_field( $field["id"], $field["title"], ( isset( $field["callback"] ) ? $field["callback"] : '' ), $field["page"], $field["section"], ( isset( $field["args"] ) ? $field["args"] : '' ) );
		}
	}
}
endif;
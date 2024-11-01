<?php 
/**
 * @package  getwebPlugin
 */
namespace rsCustomPost\Base;
if(!class_exists('MMWCPTWD_BaseController')):
	class MMWCPTWD_BaseController
	{
		public $plugin_path;

		public $plugin_url;

		public $plugin;

		public $managers = array();

		public function __construct() {
			$this->plugin_path = plugin_dir_path( dirname( __FILE__, 2 ) );
			$this->plugin_url = plugin_dir_url( dirname( __FILE__, 2 ) );
			$this->plugin = plugin_basename( dirname( __FILE__, 3 ) ) . '/mmwcptwd.php';		

			$this->managers = array(
				'cpt_manager' => 'Enable CPT',
				'taxonomy_manager' => 'Enable Taxonomy',
				'widget_manager' => 'Enable Widget',
			);
		}

		public function mmwcptwd_activated( string $key )
		{
			$option = get_option( 'mmwcptwd_options' );
			return isset( $option[ $key ] ) ? $option[ $key ] : false;
		}
		public function mmwcptwd_last_code()
		{
			$option = get_option( 'last_code' );
			return isset( $option ) && $option == 'last_code_russell' ? true : false;
		}
		public function mmwcptwd_wp_version_check() {
			$wp_version = get_bloginfo( 'version' );
			return ! version_compare( $wp_version, MWCPTWD_WPMIN_VERSION, '<' ) ? true : false;
		}
		
	}
endif;
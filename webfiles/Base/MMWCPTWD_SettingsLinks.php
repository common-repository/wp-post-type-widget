<?php
/**
 * @package  getwebPlugin
 */
namespace rsCustomPost\Base;

use rsCustomPost\Base\MMWCPTWD_BaseController;

if(!class_exists('MMWCPTWD_SettingsLinks')):
	class MMWCPTWD_SettingsLinks extends MMWCPTWD_BaseController
	{
		public function mmwcptwd_register() 
		{
			add_filter( "plugin_action_links_$this->plugin", array( $this, 'mmwcptwd_settings_link' ) );
		}

		public function mmwcptwd_settings_link( $links ) 
		{
			$_base = plugin_basename( __FILE__ );
			$settings_link = '<a href="admin.php?page=mmwcptwd" title="Setting">'.esc_html__( 'Setting', 'mmwcptwd' ).'</a>';
			array_push( $links, $settings_link );
			$_base = '<a href="$" target="_blank" title="Donate">'.esc_html__( 'Donate', 'mmwcptwd' ).'</a>';
            array_push( $links, $_base );
			return $links;
		}
		/**
		 * WP version check
		*/
		public function mmwcptwd_wp_version_error_warning( ) {
			$wp_version = get_bloginfo( 'version' );

			if ( ! version_compare( $wp_version, WOOS_WP_VERSION, '<' ) ) {
				return;
			}

		?>
		<div class="notice notice-warning woos-warning">
		<p><?php
			echo sprintf(
				__( '<strong>WP Post Type & Widget %1$s requires WordPress %2$s or higher to work properly.</strong> Please <a href="%3$s">update WordPress</a> first.', 'mmwcptwd' ),
				MMWCPTWD_VERSION,
				MWCPTWD_WPMIN_VERSION,
				admin_url( 'update-core.php' )
			);
		?></p>
		</div>
		<?php }
	}
endif;
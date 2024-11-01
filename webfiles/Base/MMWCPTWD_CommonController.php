<?php 
/**
 * @package  getwebPlugin
 */

namespace rsCustomPost\Base;

use rsCustomPost\Base\MMWCPTWD_BaseController;

/**
 *
 */
if(!class_exists('MMWCPTWD_CommonController')):
	class MMWCPTWD_CommonController extends MMWCPTWD_BaseController {
		
		public function mmwcptwd_register() {
		    add_action( 'wp_head', array( $this, 'mmwcptwd_developer' ) );
			add_action( 'admin_notices', array( $this, 'mmwcptwd_wp_version_error_check'), 10, 3 );
			add_filter('the_generator', array( $this,'mmwcptwd_remove_version'));
		}

		public function mmwcptwd_wp_version_error_check( ) {
			$wp_version = get_bloginfo( 'version' );

			if ( ! version_compare( $wp_version, MWCPTWD_WPMIN_VERSION, '<' ) ) {
				return;
			}

		?>
		<div class="notice notice-warning mmwcptwd-warning">
		<p><?php
			echo sprintf(
				__( '<strong>Custom Post Type and Widget %1$s requires WordPress %2$s or higher.</strong> Please <a href="%3$s">update WordPress</a> first.', 'mmwcptwd' ),
				MMWCPTWD_VERSION,
				MWCPTWD_WPMIN_VERSION,
				admin_url( 'update-core.php' )
			);
		?></p>
		</div>
		<?php
		}
		public function mmwcptwd_developer()
		{
			echo '<!-- Custom Post Type and Widget Developed by Abu Sayed Russell Email: abusayedrussell@gmail.com -->';
		}
		public function mmwcptwd_remove_version() {
			return '';
		}

	}
endif;
<?php 
/**
 * @package  getwebPlugin
 */

namespace rsCustomPost\Base;

use rsCustomPost\Base\MMWCPTWD_BaseController;

/**
 *
 */
if(!class_exists('MMWCPTWD_Enqueue')):
	class MMWCPTWD_Enqueue extends MMWCPTWD_BaseController {
		
		public function mmwcptwd_register() {
			if (is_admin() && !empty($_GET["page"]) && ($_GET["page"] == "mmwcptwd") || (isset($_GET['page']) && $_GET['page']=='mmwcptwd-posts') || (isset($_GET['page']) && $_GET['page']=='mmwcptwd-taxonomy')  || (isset($_GET['page']) && $_GET['page']=='mmwcptwd-widgets') ) {
		       add_action( 'admin_enqueue_scripts', array( $this, 'mmwcptwd_enqueue' ) );
		    }
		}

		function mmwcptwd_enqueue( ) {
			$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
			$page_slug = !empty($_GET["page"]) && $_GET["page"] == "mmwcptwd" ? $_GET["page"] : '';

			if ( ((!empty($_GET["page"])) && ( $_GET["page"] == "mmwcptwd") ) || ( $_GET['page'] == 'mmwcptwd-posts' || $_GET['page'] == 'mmwcptwd-taxonomy' || $_GET['page'] == 'mmwcptwd-widgets')) {

			wp_enqueue_style("mmwcptwd-font",  mmwcptwd_plugin_url('/assets/plugins/font-awesome/css/font-awesome.min.css'), array(), MMWCPTWD_VERSION, false);
			wp_enqueue_style("mmwcptwd-reset", mmwcptwd_plugin_url('/assets/css/reset.css'), array(), MMWCPTWD_VERSION, false);
			wp_enqueue_style("mmwcptwd-robot", mmwcptwd_plugin_url('/assets/plugins/roboto/roboto.css'), array(), MMWCPTWD_VERSION, false);
			wp_enqueue_style("mmwcptwd-vendor", mmwcptwd_plugin_url('/assets/plugins/app-build/vendor.css'), array(), MMWCPTWD_VERSION, false);
			wp_enqueue_style("mmwcptwd", 		mmwcptwd_plugin_url('/assets/css/mmwcptwd-main.css'), array(), MMWCPTWD_VERSION, false);

			wp_enqueue_script("mmwcptwd-popper", mmwcptwd_plugin_url('/assets/plugins/bootstrap/js/popper.min.js'), array(), MMWCPTWD_VERSION, true);
			wp_enqueue_script("mmwcptwd-boots", mmwcptwd_plugin_url('/assets/plugins/bootstrap/js/bootstrap.min.js'), array(), MMWCPTWD_VERSION, true);
			wp_enqueue_script("mmwcptwd-tooltip", mmwcptwd_plugin_url('/assets/plugins/bootstrap/js/tooltip.js'), array(), MMWCPTWD_VERSION, true);
			wp_enqueue_script("mmwcptwd-datatable", mmwcptwd_plugin_url('/assets/plugins/datatables/datatables.min.js'), array(), MMWCPTWD_VERSION, true);		
			wp_enqueue_script("mmwcptwd-main", mmwcptwd_plugin_url('/assets/plugins/app-build/main.js'), array(), MMWCPTWD_VERSION, true);
			}
		}
	}
endif;
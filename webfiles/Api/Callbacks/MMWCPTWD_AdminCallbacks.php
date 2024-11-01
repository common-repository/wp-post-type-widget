<?php 
/**
 * @package  getwebPlugin
 */
namespace rsCustomPost\Api\Callbacks;

use rsCustomPost\Base\MMWCPTWD_BaseController;

if(!class_exists('MMWCPTWD_AdminCallbacks')):
	class MMWCPTWD_AdminCallbacks extends MMWCPTWD_BaseController
	{
		public function mmwcptwd_admin_settings()
		{
			return require_once( "$this->plugin_path/templates/admin/admin.php" );
		}

		public function mmwcptwd_admin_cpt()
		{
			return require_once( "$this->plugin_path/templates/cpt/cpt.php" );
		}

		public function mmwcptwd_admin_taxonomy()
		{
			return require_once( "$this->plugin_path/templates/taxonomy/taxonomy.php" );
		}

		public function mmwcptwd_admin_widget()
		{
			return require_once( "$this->plugin_path/templates/widget/widget.php" );
		}
	}
endif;
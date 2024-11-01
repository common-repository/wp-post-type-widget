<?php
/**
 * @package  getwebPlugin
 */
namespace rsCustomPost\Base;
if(!class_exists('MMWCPTWD_Deactivate')):
	class MMWCPTWD_Deactivate
	{
		public static function mmwcptwd_deactivate() {
			flush_rewrite_rules();
		}
	}
endif;
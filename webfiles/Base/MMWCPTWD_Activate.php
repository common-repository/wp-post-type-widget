<?php
/**
 * @package  getwebPlugin
 */
namespace rsCustomPost\Base;
if(!class_exists('MMWCPTWD_Activate')):
	class MMWCPTWD_Activate
	{
		public static function mmwcptwd_activate() {
			flush_rewrite_rules();

			$default = array();
			
			if ( ! get_option( 'mmwcptwd' ) ) {
				update_option( 'mmwcptwd', array('version:'.MMWCPTWD_WPMIN_VERSION) );
			}
			if ( ! get_option( 'last_code' ) ) {
				update_option( 'last_code', 'last_code_russell' );
			}

			if ( ! get_option( 'mmwcptwd_options' ) ) {
				update_option( 'mmwcptwd_options', $default );
			}

			if ( ! get_option( 'mmwcptwd_cpt' ) ) {
				update_option( 'mmwcptwd_cpt', $default );
			}

			if ( ! get_option( 'mmwcptwd_tax' ) ) {
				update_option( 'mmwcptwd_tax', $default );
			}
			if ( ! get_option( 'mmwcptwd_cwm' ) ) {
				update_option( 'mmwcptwd_cwm', $default );
			}

		}
	}
endif;
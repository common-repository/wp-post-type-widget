<?php

/**
 * Trigger this file on Plugin uninstall
 *
 * @package  getwebPlugin
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}
 function cptwd_plugin_delete_with_data() {
	global $wpdb;
	delete_option('mmwcptwd');
	delete_option('mmwcptwd_options');
	delete_option('mmwcptwd_cpt');
	delete_option('mmwcptwd_tax');
	delete_option('mmwcptwd_cwm');
}

cptwd_plugin_delete_with_data();
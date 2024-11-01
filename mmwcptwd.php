<?php
/**
 * @package  getwebPlugin
 */
/*
Plugin Name: WP Post Type & Widget
Plugin URI: https://wordpress.org/plugins/wp-post-type-widget
Description: Dynamically add custom post type and custom taxonomy type.
Version: 1.0.0
Author: Joy Shaha
Author URI: https://www.upwork.com/freelancers/~0109eba98d3423e68e
License: GPLv2
Text Domain: mmwcptwd
Domain Path: /languages
*/



// If this file is called firectly, abort!!!
defined( 'ABSPATH' ) or die( 'Hey, what are you doing here? You silly human!' );


if (!defined("MMWCPTWD_VERSION"))
    define("MMWCPTWD_VERSION", '1.0.0');

if (!defined("MWCPTWD_WPMIN_VERSION"))
    define("MWCPTWD_WPMIN_VERSION", '4.9');

if (!defined("MMWCPTWD_PHP_VERSION"))
    define("MMWCPTWD_PHP_VERSION", '5.6.0');

if (!defined("MMWCPTWD_FILE"))
    define("MMWCPTWD_FILE", __FILE__);

if (!defined("MMWCPTWD_PLUGIN"))
    define("MMWCPTWD_PLUGIN", __FILE__);

if (!defined("MMWCPTWD_PLUGIN_BASE"))
    define("MMWCPTWD_PLUGIN_BASE", plugin_basename(MMWCPTWD_FILE));

if (!defined("MMWCPTWD_PLUGIN_DIR_PATH"))
    define("MMWCPTWD_PLUGIN_DIR_PATH", plugin_dir_path(MMWCPTWD_FILE));

// Require once the Composer Autoload
if ( version_compare( PHP_VERSION, MMWCPTWD_PHP_VERSION, '>=' ) ) {
    require_once ( MMWCPTWD_PLUGIN_DIR_PATH . '/vendor/autoload.php' );
}else{
    add_action( 'admin_notices',  'mmwcptwd_php_version_error_warning');
}

function mmwcptwd_php_version_error_warning( ) {
        $php_version = phpversion();
         ?>
        <div class="notice notice-warning mmwps-warning">
         <p><?php echo sprintf( __("Your current PHP version is <strong> $php_version </strong>. You need to upgrade your PHP version to <strong> ".MMWCPTWD_PHP_VERSION." or later</strong> to run WP Post Type & Widget plugin.", "mmwcptwd" ) ); ?></p>
        </div>
    <?php
}
/**
 * The code that runs during plugin activation
 */
if ( version_compare( PHP_VERSION, MMWCPTWD_PHP_VERSION, '>=' ) ) {
	function mmwcptwd_activate_plugin() {
		rsCustomPost\Base\MMWCPTWD_Activate::mmwcptwd_activate();
	}
	register_activation_hook( __FILE__, 'mmwcptwd_activate_plugin' );
}
/**
 * The code that runs during plugin deactivation
 */
if ( version_compare( PHP_VERSION, MMWCPTWD_PHP_VERSION, '>=' ) ) {
	function mmwcptwd_deactivate_plugin() {
		rsCustomPost\Base\MMWCPTWD_Deactivate::mmwcptwd_deactivate();
	}
	register_deactivation_hook( __FILE__, 'mmwcptwd_deactivate_plugin' );
}
/**
 * Initialize all the core classes of the plugin
 */
if ( class_exists( 'rsCustomPost\\CPT' ) ) {
	rsCustomPost\CPT::mmwcptwd_registerServices();
}

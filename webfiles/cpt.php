<?php
/**
 * @package  getwebPlugin
 */
namespace rsCustomPost;

final class CPT
{
	/**
	 * Store all the classes inside an array
	 * @return array Full list of classes
	 */
	public static function mmwcptwd_getServices()
	{
		return [
			Pages\MMWCPTWD_Dashboard::class,
			Base\MMWCPTWD_Enqueue::class,
			Base\MMWCPTWD_SettingsLinks::class,
			Base\MMWCPTWD_PostTypeController::class,
			Base\MMWCPTWD_TaxonomyController::class,
			Base\MMWCPTWD_WidgetController::class,
			Base\MMWCPTWD_CommonController::class,
		];
	}

	/**
	 * Loop through the classes, initialize them,
	 * and call the mmwcptwd_registerServices() method if it exists
	 * @return
	 */
	public static function mmwcptwd_registerServices()
	{
		foreach (self::mmwcptwd_getServices() as $class) {
			$service = self::mmwcptwd_instantiate($class);
			if (method_exists($service, 'mmwcptwd_register')) {
				$service->mmwcptwd_register();
			}
		}
	}

	/**
	 * Initialize the class
	 * @param  class $class    class from the services array
	 * @return class mmwcptwd_instantiate  new mmwcptwd_instantiate of the class
	 */
	private static function mmwcptwd_instantiate($class)
	{
		$service = new $class();
		return $service;
	}
}

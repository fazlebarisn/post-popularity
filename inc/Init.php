<?php
/**
 * @package KbsPlugin
*/
namespace Inc;

final class Init
{
	/**
	 * Store all classes inside an array
	 * @return array Full list of classes
	 */

	public static function get_services(){
		return[	
			Base\Enqueue::class,
			Pages\Admin::class,
			LikeDislike\LikeDislike::class,
			LikeDislike\LikeDislikeAction::class,
		];
	}

	/**
	 * Loop through the classes, initialize them
	 * and call the register() methord if it exists
	 * @return 
	 */

	public static function register_services(){
		foreach (self::get_services() as $class) {
			$service = self::instantiate($class);
			if (method_exists($service, 'register')) {
				$service->register();
			}
		}
	}

	/**
	 * Initialize the class
	 * @param class $class class from the services array
	 * @return class instance new instance of the class
	 */

	private static function instantiate($class){
		$service = new $class();
		return $service;
	}
}

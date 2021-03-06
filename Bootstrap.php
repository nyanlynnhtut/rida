<?php

namespace Rida;

class Bootstrap extends \Reborn\Module\AbstractBootstrap
{

	/**
	 * This method will run when module boot.
	 *
	 * @return void;
	 */
	public function boot()
	{
		$path = \Config::get('rida::rida.docs_path');

		$path = is_null($path) ? __DIR__.DS.'docs'.DS : rtrim($path, DS).DS;

		define('DOCS_PATH', $path);

		require __DIR__.DS.'helpers.php';
	}

	/**
	 * Menu item register method for admin panel
	 *
	 * @return void
	 */
	public function adminMenu(\Reborn\Util\Menu $menu, $modUri)
	{
		// eg: $menu->add('name', 'Title', 'link', $parent_menu = null, $icon = 'icon-class', $order = 35);
	}

	/**
	 * Module Toolbar Data for Admin Panel
	 *
	 * @return array
	 */
	public function moduleToolbar()
	{
		return array();
	}

	/**
	 * Setting attributes for Module
	 *
	 * @return array
	 */
	public function settings()
	{
		return array();
	}

	/**
	 * Register method for Module.
	 * This method will call application start.
	 * You can register at requirement for Reborn CMS.
	 *
	 */
	public function register() {}

}

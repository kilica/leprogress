<?php
/**
 * @file
 * @package leprogress
 * @version $Id$
**/

if(!defined('XOOPS_ROOT_PATH'))
{
	exit;
}
require_once LEPROGRESS_TRUST_PATH . '/class/Enum.class.php';

/**
 * Leprogress_Utils
**/
class Leprogress_Utils
{
	/**
	 * &getXoopsHandler
	 * 
	 * @param	string	$name
	 * @param	bool  $optional
	 * 
	 * @return	XoopsObjectHandler
	**/
	public static function &getXoopsHandler(/*** string ***/ $name,/*** bool ***/ $optional = false)
	{
		// TODO will be emulated xoops_gethandler
		return xoops_gethandler($name,$optional);
	}

	/**
	 * &getModuleHandler
	 * 
	 * @param	string	$name
	 * @param	string	$dirname
	 * 
	 * @return	XoopsObjectHandleer
	**/
	public static function &getModuleHandler(/*** string ***/ $name,/*** string ***/ $dirname)
	{
		// TODO will be emulated xoops_getmodulehandler
		return xoops_getmodulehandler($name,$dirname);
	}

	/**
	 * getEnv
	 * 
	 * @param	string	$key
	 * 
	 * @return	string
	**/
	public static function getEnv(/*** string ***/ $key)
	{
		return getenv($key);
	}

	/**
	 * getModuleConfig
	 * 
	 * @param	string	$key
	 * 
	 * @return	mix
	**/
	public static function getModuleConfig($dirname, $key)
	{
		$handler = self::getXoopsHandler('config');
		$configArr = $handler->getConfigsByDirname($dirname);
		return $configArr[$key];
	}
}

?>

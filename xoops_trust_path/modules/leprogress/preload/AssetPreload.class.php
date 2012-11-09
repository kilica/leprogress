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

if(!defined('LEPROGRESS_TRUST_PATH'))
{
	define('LEPROGRESS_TRUST_PATH',XOOPS_TRUST_PATH . '/modules/leprogress');
}

require_once LEPROGRESS_TRUST_PATH . '/class/LeprogressUtils.class.php';

/**
 * Leprogress_AssetPreloadBase
**/
class Leprogress_AssetPreloadBase extends XCube_ActionFilter
{
	public $mDirname = null;

    /**
     * prepare
     * 
     * @param   string	$dirname
     * 
     * @return  void
    **/
    public static function prepare(/*** string ***/ $dirname)
    {
        $root =& XCube_Root::getSingleton();
        $instance = new Leprogress_AssetPreloadBase($root->mController);
        $instance->mDirname = $dirname;
        $root->mController->addActionFilter($instance);
    }

	/**
	 * _setup
	 * 
	 * @param	void
	 * 
	 * @return	bool
	**/
	public static function _setup()
	{
		$root =& XCube_Root::getSingleton();
		$instance = new self($root->mController);
		$root->mController->addActionFilter($instance);
		return true;
	}

	/**
	 * preBlockFilter
	 * 
	 * @param	void
	 * 
	 * @return	void
	**/
	public function preBlockFilter()
	{
		$this->mRoot->mDelegateManager->add('Module.leprogress.Global.Event.GetAssetManager','Leprogress_AssetPreloadBase::getManager');
		$this->mRoot->mDelegateManager->add('Legacy_Utils.CreateModule','Leprogress_AssetPreloadBase::getModule');
		$this->mRoot->mDelegateManager->add('Legacy_Utils.CreateBlockProcedure','Leprogress_AssetPreloadBase::getBlock');
		$file = LEPROGRESS_TRUST_PATH.'/class/DelegateFunctions.class.php';
		$this->mRoot->mDelegateManager->add('Module.'.$this->mDirname.'.Global.Event.GetNormalUri','Leprogress_CoolUriDelegate::getNormalUri', $file);
		$this->mRoot->mDelegateManager->add('Legacy_Workflow.AddItem','Leprogress_WorkflowDelegate::addItem', $file);
		$this->mRoot->mDelegateManager->add('Legacy_Workflow.DeleteItem','Leprogress_WorkflowDelegate::deleteItem', $file);
		$this->mRoot->mDelegateManager->add('Legacy_Workflow.GetHistory','Leprogress_WorkflowDelegate::getHistory', $file);
	}

	/**
	 * getManager
	 * 
	 * @param	Leprogress_AssetManager  &$obj
	 * @param	string	$dirname
	 * 
	 * @return	void
	**/
	public static function getManager(/*** Leprogress_AssetManager ***/ &$obj,/*** string ***/ $dirname)
	{
		require_once LEPROGRESS_TRUST_PATH . '/class/AssetManager.class.php';
		$obj = Leprogress_AssetManager::getInstance($dirname);
	}

	/**
	 * getModule
	 * 
	 * @param	Legacy_AbstractModule  &$obj
	 * @param	XoopsModule  $module
	 * 
	 * @return	void
	**/
	public static function getModule(/*** Legacy_AbstractModule ***/ &$obj,/*** XoopsModule ***/ $module)
	{
		if($module->getInfo('trust_dirname') == 'leprogress')
		{
			require_once LEPROGRESS_TRUST_PATH . '/class/Module.class.php';
			$obj = new Leprogress_Module($module);
		}
	}

	/**
	 * getBlock
	 * 
	 * @param	Legacy_AbstractBlockProcedure  &$obj
	 * @param	XoopsBlock	$block
	 * 
	 * @return	void
	**/
	public static function getBlock(/*** Legacy_AbstractBlockProcedure ***/ &$obj,/*** XoopsBlock ***/ $block)
	{
		$moduleHandler =& Leprogress_Utils::getXoopsHandler('module');
		$module =& $moduleHandler->get($block->get('mid'));
		if(is_object($module) && $module->getInfo('trust_dirname') == 'leprogress')
		{
			require_once LEPROGRESS_TRUST_PATH . '/blocks/' . $block->get('func_file');
			$className = 'Leprogress_' . substr($block->get('show_func'), 4);
			$obj = new $className($block);
		}
	}
}

?>

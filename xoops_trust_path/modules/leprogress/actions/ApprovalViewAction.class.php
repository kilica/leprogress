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

require_once LEPROGRESS_TRUST_PATH . '/class/AbstractViewAction.class.php';

/**
 * Leprogress_ApprovalViewAction
**/
class Leprogress_ApprovalViewAction extends Leprogress_AbstractViewAction
{
	/**
	 * &_getHandler
	 * 
	 * @param	void
	 * 
	 * @return	Leprogress_ApprovalHandler
	**/
	protected function &_getHandler()
	{
		$handler =& $this->mAsset->getObject('handler', 'Approval');
		return $handler;
	}

	/**
	 * executeViewSuccess
	 * 
	 * @param	XCube_RenderTarget	&$render
	 * 
	 * @return	void
	**/
	public function executeViewSuccess(/*** XCube_RenderTarget ***/ &$render)
	{
		$render->setTemplateName($this->mAsset->mDirname . '_approval_view.html');
		$render->setAttribute('object', $this->mObject);
		$render->setAttribute('dirname', $this->mAsset->mDirname);
	}

	/**
	 * executeViewError
	 * 
	 * @param	XCube_RenderTarget	&$render
	 * 
	 * @return	void
	**/
	public function executeViewError(/*** XCube_RenderTarget ***/ &$render)
	{
		$this->mRoot->mController->executeRedirect($this->_getNextUri('approval'), 1, _MD_LEPROGRESS_ERROR_CONTENT_IS_NOT_FOUND);
	}
}

?>

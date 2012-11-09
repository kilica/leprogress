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

require_once LEPROGRESS_TRUST_PATH . '/class/AbstractDeleteAction.class.php';

/**
 * Leprogress_HistoryDeleteAction
**/
class Leprogress_HistoryDeleteAction extends Leprogress_AbstractDeleteAction
{
	/**
	 * _getPageTitle
	 * 
	 * @param	void
	 * 
	 * @return	string
	**/
	protected function _getPagetitle()
	{
		return $this->mObject->mItem->getShow('title');
	}

	/**
	 * hasPermission
	 * 
	 * @param	void
	 * 
	 * @return	bool
	**/
	public function hasPermission()
	{
		if($this->mObject->get('uid')==Legacy_Utils::getUid()){
			return true;
		}
		elseif($this->mRoot->mContext->mUser->isInRole('Site.Owner')){
			return true;
		}
		else{
			return false;
		}
	}

	/**
	 * prepare
	 * 
	 * @param	void
	 * 
	 * @return	bool
	**/
	public function prepare()
	{
		parent::prepare();
		$this->mObject->loadItem();
	
		//check progress. if the progress is at the next approval, the history can't delete.
		$aHandler = Legacy_Utils::getModuleHandler('approval', $this->mAsset->mDirname);
		$approval = $aHandler->getPreviousApproval($this->mObject->mItem->getShow('dirname'), $this->mObject->mItem->getShow('dataname'), $this->mObject->mItem->getShow('step'));
		if($approval && $approval->getShow('step') != $this->mObject->getShow('step')){
			$this->mRoot->mController->executeRedirect($this->_getNextUri('history', 'list'), 1, _MD_LEPROGRESS_ERROR_CANT_DELETE_HISTORY);
		}
	}


	/**
	 * &_getHandler
	 * 
	 * @param	void
	 * 
	 * @return	Leprogress_HistoryHandler
	**/
	protected function &_getHandler()
	{
		$handler =& $this->mAsset->getObject('handler', 'History');
		return $handler;
	}

	/**
	 * _setupActionForm
	 * 
	 * @param	void
	 * 
	 * @return	void
	**/
	protected function _setupActionForm()
	{
		$this->mActionForm =& $this->mAsset->getObject('form', 'History',false,'delete');
		$this->mActionForm->prepare();
	}

	/**
	 * executeViewInput
	 * 
	 * @param	XCube_RenderTarget	&$render
	 * 
	 * @return	void
	**/
	public function executeViewInput(/*** XCube_RenderTarget ***/ &$render)
	{
		$render->setTemplateName($this->mAsset->mDirname . '_history_delete.html');
		$render->setAttribute('actionForm', $this->mActionForm);
		$render->setAttribute('object', $this->mObject);
		$render->setAttribute('dirname', $this->mAsset->mDirname);
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
		$this->mRoot->mController->executeForward($this->_getNextUri('history', 'list'));
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
		$this->mRoot->mController->executeRedirect($this->_getNextUri('history'), 1, _MD_LEPROGRESS_ERROR_DBUPDATE_FAILED);
	}

	/**
	 * executeViewCancel
	 * 
	 * @param	XCube_RenderTarget	&$render
	 * 
	 * @return	void
	**/
	public function executeViewCancel(/*** XCube_RenderTarget ***/ &$render)
	{
		$this->mRoot->mController->executeForward($this->_getNextUri('history'));
	}
}

?>

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

require_once LEPROGRESS_TRUST_PATH . '/class/AbstractEditAction.class.php';

/**
 * Leprogress_ApprovalEditAction
**/
class Leprogress_ApprovalEditAction extends Leprogress_AbstractEditAction
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
	 * hasPermission
	 * 
	 * @param	void
	 * 
	 * @return	bool
	**/
	public function hasPermission()
	{
		return ($this->mRoot->mContext->mUser->isInRole('Site.Owner')) ? true : false;
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
		if(! $this->mObject->isNew() && $this->mObject->countMyItem()>0){
			$this->mRoot->mController->executeRedirect($this->_getNextUri('approval', 'list'), 1, _MD_LEPROGRESS_ERROR_ITEM_REMAINS);
		}
		if($this->mObject->isNew()){
			$this->mObject->set('dirname', $this->mRoot->mContext->mRequest->getRequest('dirname'));
			$this->mObject->set('dataname', $this->mRoot->mContext->mRequest->getRequest('dataname'));
		}
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
		$this->mActionForm =& $this->mAsset->getObject('form', 'Approval',false,'edit');
		$this->mActionForm->prepare($this->mAsset->mDirname);
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
		$render->setTemplateName($this->mAsset->mDirname . '_approval_edit.html');
		$render->setAttribute('actionForm', $this->mActionForm);
		$render->setAttribute('object', $this->mObject);
		$render->setAttribute('dirname', $this->mAsset->mDirname);
		//get workflow client modules
		$clients = array();
		XCube_DelegateUtils::call('Legacy_WorkflowClient.GetClientList', new XCube_Ref($clients));
		$render->setAttribute('list', $clients);
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
		$this->mRoot->mController->executeForward($this->_getNextUri('approval', 'list'));
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
		$this->mRoot->mController->executeRedirect($this->_getNextUri('approval'), 1, _MD_LEPROGRESS_ERROR_DBUPDATE_FAILED);
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
		$this->mRoot->mController->executeForward($this->_getNextUri('approval'));
	}
}

?>

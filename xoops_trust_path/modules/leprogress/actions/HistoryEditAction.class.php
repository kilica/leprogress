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
 * Leprogress_HistoryEditAction
**/
class Leprogress_HistoryEditAction extends Leprogress_AbstractEditAction
{
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
	 * _checkStep
	 * 
	 * @param	void
	 * 
	 * @return	bool
	**/
	protected function _checkStep()
	{
		return ($this->mObject->mItem->get('step') == $this->mObject->get('step')) ? true : false;
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
		if($this->mObject->isNew()){
			$this->mObject->set('item_id', $this->mRoot->mContext->mRequest->getRequest('item_id'));
			$this->mObject->set('uid', Legacy_Utils::getUid());
			$this->mObject->set('step', $this->mObject->setMyStep());
		}
		$this->mObject->loadItem();
		$this->mObject->mItem->loadHistory();
	
		if(! $this->_checkStep()){
            $this->mRoot->mController->executeForward(Legacy_Utils::renderUri($this->mAsset->mDirname, 'item', $this->mObject->getShow('item_id')));
        }
	
		return true;
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
		$this->mActionForm =& $this->mAsset->getObject('form', 'History',false,'edit');
		$this->mActionForm->prepare();
	}

	/**
	 * _doExecute
	 * 
	 * @param	void
	 * 
	 * @return	Enum
	**/
	protected function _doExecute()
	{
		$iHandler = Legacy_Utils::getModuleHandler('item', $this->mAsset->mDirname);
		if($this->mObjectHandler->insert($this->mObject))
		{
			if($this->mObject->get('result')==Leprogress_Result::APPROVE){
				$iHandler->proceedStep($this->mObject->mItem);
			}
			else{
				$iHandler->revertStep($this->mObject->mItem);
			}
			return LEPROGRESS_FRAME_VIEW_SUCCESS;
		}
	
		return LEPROGRESS_FRAME_VIEW_ERROR;
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
		$render->setTemplateName($this->mAsset->mDirname . '_history_edit.html');
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
		$this->mRoot->mController->executeForward(Legacy_Utils::renderUri($this->mAsset->mDirname, 'item', $this->mObject->get('item_id'), 'view'));
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
		$this->mRoot->mController->executeForward($this->_getNextUri('history', 'list'));
	}
}

?>

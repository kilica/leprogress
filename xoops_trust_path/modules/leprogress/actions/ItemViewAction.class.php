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
 * Leprogress_ItemViewAction
**/
class Leprogress_ItemViewAction extends Leprogress_AbstractViewAction
{
	public $mMyStep = false;

	/**
	 * &_getHandler
	 * 
	 * @param	void
	 * 
	 * @return	Leprogress_ItemHandler
	**/
	protected function &_getHandler()
	{
		$handler =& $this->mAsset->getObject('handler', 'Item');
		return $handler;
	}

	/**
	 * _getPageTitle
	 * 
	 * @param	void
	 * 
	 * @return	string
	**/
	protected function _getPagetitle()
	{
		return $this->mObject->getShow('title');
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
		$this->mObject->loadHistory();
	
		if($this->_checkMyStep()){
			$this->mMyStep = true;
			$this->_setupActionForm();
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
	 * executeViewSuccess
	 * 
	 * @param	XCube_RenderTarget	&$render
	 * 
	 * @return	void
	**/
	public function executeViewSuccess(/*** XCube_RenderTarget ***/ &$render)
	{
		$render->setTemplateName($this->mAsset->mDirname . '_item_view.html');
		$render->setAttribute('object', $this->mObject);
		$render->setAttribute('dirname', $this->mAsset->mDirname);
		$render->setAttribute('approval', $this->mMyStep);
		if($this->mMyStep==true){
			$render->setAttribute('actionForm', $this->mActionForm);
		}
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
		$this->mRoot->mController->executeRedirect($this->_getNextUri('item', 'list'), 1, _MD_LEPROGRESS_ERROR_CONTENT_IS_NOT_FOUND);
	}

	/**
	 * _checkMyStep
	 * 
	 * @param	void
	 * 
	 * @return	bool
	**/
	protected function _checkMyStep()
	{
		$cri = new CriteriaCompo();
		$cri->add(new Criteria('dirname', $this->mObject->get('dirname')));
		$cri->add(new Criteria('dataname', $this->mObject->get('dataname')));
		$cri->add(new Criteria('step', $this->mObject->get('step')));
		$cri->add(new Criteria('uid', Legacy_Utils::getUid()));
		return (count(Legacy_Utils::getModuleHandler('approval', $this->mAsset->mDirname)->getObjects($cri))==1) ? true : false;
	}


}

?>

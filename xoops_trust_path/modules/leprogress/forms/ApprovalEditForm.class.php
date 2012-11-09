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

require_once XOOPS_ROOT_PATH . '/core/XCube_ActionForm.class.php';
require_once XOOPS_MODULE_PATH . '/legacy/class/Legacy_Validator.class.php';

/**
 * Leprogress_ApprovalEditForm
**/
class Leprogress_ApprovalEditForm extends XCube_ActionForm
{
	protected /*** string ***/ $_mDirname = null;

	/**
	 * getTokenName
	 * 
	 * @param	void
	 * 
	 * @return	string
	**/
	public function getTokenName()
	{
		return "module.leprogress.ApprovalEditForm.TOKEN";
	}

	/**
	 * prepare
	 * 
	 * @param	void
	 * 
	 * @return	void
	**/
	public function prepare($dirname)
	{
		$this->_mDirname = $dirname;
		//
		// Set form properties
		//
		$this->mFormProperties['approval_id'] = new XCube_IntProperty('approval_id');
		$this->mFormProperties['uid'] = new XCube_IntProperty('uid');
		$this->mFormProperties['dirname'] = new XCube_StringProperty('dirname');
		$this->mFormProperties['dataname'] = new XCube_StringProperty('dataname');
		$this->mFormProperties['step'] = new XCube_IntProperty('step');
	
		//
		// Set field properties
		//
		$this->mFieldProperties['approval_id'] = new XCube_FieldProperty($this);
		$this->mFieldProperties['approval_id']->setDependsByArray(array('required'));
		$this->mFieldProperties['approval_id']->addMessage('required', _MD_LEPROGRESS_ERROR_REQUIRED, _MD_LEPROGRESS_LANG_APPROVAL_ID);
	
		$this->mFieldProperties['uid'] = new XCube_FieldProperty($this);
		$this->mFieldProperties['uid']->setDependsByArray(array('required'));
		$this->mFieldProperties['uid']->addMessage('required', _MD_LEPROGRESS_ERROR_REQUIRED, _MD_LEPROGRESS_LANG_UID);
	
		$this->mFieldProperties['step'] = new XCube_FieldProperty($this);
		$this->mFieldProperties['step']->setDependsByArray(array('required', 'min'));
		$this->mFieldProperties['step']->addMessage('required', _MD_LEPROGRESS_ERROR_REQUIRED, _MD_LEPROGRESS_LANG_STEP);
		$this->mFieldProperties['step']->addMessage('min', _MD_LEPROGRESS_ERROR_MIN, _MD_LEPROGRESS_LANG_STEP, '1');
		$this->mFieldProperties['step']->addVar('min', '1');
	}

	/**
	 * load
	 * 
	 * @param	XoopsSimpleObject  &$obj
	 * 
	 * @return	void
	**/
	public function load(/*** XoopsSimpleObject ***/ &$obj)
	{
		$this->set('approval_id', $obj->get('approval_id'));
		$this->set('uid', $obj->get('uid'));
		$this->set('dirname', $obj->get('dirname'));
		$this->set('dataname', $obj->get('dataname'));
		$this->set('step', $obj->get('step'));
	}

	/**
	 * update
	 * 
	 * @param	XoopsSimpleObject  &$obj
	 * 
	 * @return	void
	**/
	public function update(/*** XoopsSimpleObject ***/ &$obj)
	{
		$target = $this->_getTarget();
	
		//$obj->set('approval_id', $this->get('approval_id'));
		$obj->set('uid', $this->get('uid'));
		$obj->set('dirname', $target[0]);
		$obj->set('dataname', $target[1]);
		$obj->set('step', $this->get('step'));
	}

	/**
	 * validateStep
	 * 
	 * @param	string	$dirname
	 * 
	 * @return	void
	**/
	public function validateStep()
	{
		if($this->get('approval_id')>0){
			return;
		}
		$handler = Legacy_Utils::getModuleHandler('approval', $this->_mDirname);
		$target = $this->_getTarget();
	
		$cri = new CriteriaCompo();
		$cri->add(new Criteria('dirname', $target[0]));
		$cri->add(new Criteria('dataname', $target[1]));
		$cri->add(new Criteria('step', $this->get('step')));
		if(count($handler->getObjects($cri))>0){
			$this->addErrorMessage(_MD_LEPROGRESS_ERROR_DUPLICATED_STEP);
		}
	}

	/**
	 * validateUid
	 * 
	 * @param	string	$dirname
	 * 
	 * @return	void
	**/
	public function validateUid()
	{
		if($this->get('uid')==0){
			$this->addErrorMessage(_MD_LEPROGRESS_ERROR_UID_REQUIRED);
		}
	}

	/**
	 * _getTarget
	 * 
	 * @param	void
	 * 
	 * @return	string[]
	**/
	protected function _getTarget()
	{
		$root = XCube_Root::getSingleton();
		return explode('|', $root->mContext->mRequest->getRequest('target'));		}
}

?>

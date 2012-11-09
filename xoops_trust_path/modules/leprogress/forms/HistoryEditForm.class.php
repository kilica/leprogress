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
 * Leprogress_HistoryEditForm
**/
class Leprogress_HistoryEditForm extends XCube_ActionForm
{
	/**
	 * getTokenName
	 * 
	 * @param	void
	 * 
	 * @return	string
	**/
	public function getTokenName()
	{
		return "module.leprogress.HistoryEditForm.TOKEN";
	}

	/**
	 * prepare
	 * 
	 * @param	void
	 * 
	 * @return	void
	**/
	public function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['progress_id'] = new XCube_IntProperty('progress_id');
		$this->mFormProperties['item_id'] = new XCube_IntProperty('item_id');
		$this->mFormProperties['uid'] = new XCube_IntProperty('uid');
		$this->mFormProperties['step'] = new XCube_IntProperty('step');
		$this->mFormProperties['result'] = new XCube_IntProperty('result');
		$this->mFormProperties['comment'] = new XCube_TextProperty('comment');
		$this->mFormProperties['posttime'] = new XCube_IntProperty('posttime');
	
		//
		// Set field properties
		//
		$this->mFieldProperties['item_id'] = new XCube_FieldProperty($this);
		$this->mFieldProperties['item_id']->setDependsByArray(array('required'));
		$this->mFieldProperties['item_id']->addMessage('required', _MD_LEPROGRESS_ERROR_REQUIRED, _MD_LEPROGRESS_LANG_ITEM_ID);
	
		$this->mFieldProperties['result'] = new XCube_FieldProperty($this);
		$this->mFieldProperties['result']->setDependsByArray(array('required'));
		$this->mFieldProperties['result']->addMessage('required', _MD_LEPROGRESS_ERROR_REQUIRED, _MD_LEPROGRESS_LANG_RESULT);
	
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
		$this->set('progress_id', $obj->get('progress_id'));
		$this->set('item_id', $obj->get('item_id'));
		$this->set('uid', $obj->get('uid'));
		$this->set('step', $obj->get('step'));
		$this->set('result', $obj->get('result'));
		$this->set('comment', $obj->get('comment'));
		$this->set('posttime', $obj->get('posttime'));
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
		//$obj->set('progress_id', $this->get('progress_id'));
		$obj->set('item_id', $this->get('item_id'));
		//$obj->set('uid', $this->get('uid'));
		//$obj->set('step', $this->get('step'));
		$obj->set('result', $this->get('result'));
		$obj->set('comment', $this->get('comment'));
	}
}

?>

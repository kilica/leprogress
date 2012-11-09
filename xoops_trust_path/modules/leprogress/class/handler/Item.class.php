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

/**
 * Leprogress_ItemObject
**/
class Leprogress_ItemObject extends XoopsSimpleObject
{
	public $mDirname = null;
	public $mHistory = array();
	protected $_mHistoryLoadedFlag = false;

	/**
	 * __construct
	 * 
	 * @param	string	$dirname
	 * 
	 * @return	void
	**/
	public function __construct()
	{
		$this->initVar('item_id', XOBJ_DTYPE_INT, '', false);
		$this->initVar('title', XOBJ_DTYPE_STRING, '', false, 255);
		$this->initVar('dirname', XOBJ_DTYPE_STRING, '', false, 45);
		$this->initVar('dataname', XOBJ_DTYPE_STRING, '', false, 45);
		$this->initVar('target_id', XOBJ_DTYPE_INT, '', false);
		$this->initVar('uid', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('step', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('status', XOBJ_DTYPE_INT, Lenum_WorkflowStatus::PROGRESS, false);
		$this->initVar('revision', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('url', XOBJ_DTYPE_TEXT, '', false);
		$this->initVar('posttime', XOBJ_DTYPE_INT, time(), false);
		$this->initVar('updatetime', XOBJ_DTYPE_INT, time(), false);
		$this->initVar('deletetime', XOBJ_DTYPE_INT, 0, false);
	}

	/**
	 * setFirstStep
	 * 
	 * @param	void
	 * 
	 * @return	void
	**/
	public function setFirstStep()
	{
		$approval = Legacy_Utils::getModuleHandler('approval', $this->getDirname())->getNextApproval($this->get('dirname'), $this->get('dataname'), 0);
		if($approval){
			$this->set('step', $approval->get('step'));
		}
		else{
			$this->set('step', 0);
			$this->set('status', Lenum_WorkflowStatus::FINISHED);
		}
	}

	/**
	 * incrementRevision
	 * 
	 * @param	void
	 * 
	 * @return	void
	**/
	public function incrementRevision()
	{
		$this->set('revision', $this->get('revision')+1);
	}

	/**
	 * loadHistory
	 * 
	 * @param	string	$order
	 * 
	 * @return	void
	**/
	public function loadHistory(/*** string ***/ $order='asc')
	{
		if ($this->_mHistoryLoadedFlag == false) {
			$handler =Legacy_Utils::getModuleHandler('history', $this->getDirname());
			$cri = new Criteria('item_id', $this->get('item_id'));
			$cri->setSort('posttime', $order);
			$this->mHistory =& $handler->getObjects($cri);
			$this->_mHistoryLoadedFlag = true;
		}
	}

	/**
	 * getShowStatus
	 * 
	 * @param	void
	 * 
	 * @return	string
	**/
	public function getShowStatus()
	{
		switch($this->get('status')){
			case Lenum_WorkflowStatus::DELETED:
				return _MD_LEPROGRESS_LANG_STATUS_DELETED;
				break;
			case Lenum_WorkflowStatus::REJECTED:
				return _MD_LEPROGRESS_LANG_STATUS_REJECTED;
				break;
			case Lenum_WorkflowStatus::PROGRESS:
				return _MD_LEPROGRESS_LANG_STATUS_PROGRESS;
				break;
			case Lenum_WorkflowStatus::FINISHED:
				return _MD_LEPROGRESS_LANG_STATUS_FINISHED;
				break;
		}
	}
}

/**
 * Leprogress_ItemHandler
**/
class Leprogress_ItemHandler extends XoopsObjectGenericHandler
{
	public /*** string ***/ $mTable = '{dirname}_item';

	public /*** string ***/ $mPrimary = 'item_id';

	public /*** string ***/ $mClass = 'Leprogress_ItemObject';

	/**
	 * __construct
	 * 
	 * @param	XoopsDatabase  &$db
	 * @param	string	$dirname
	 * 
	 * @return	void
	**/
	public function __construct(/*** XoopsDatabase ***/ &$db,/*** string ***/ $dirname)
	{
		$this->mTable = strtr($this->mTable,array('{dirname}' => $dirname));
		parent::XoopsObjectGenericHandler($db);
	}

	/**
	 * delete
	 * 
	 * @param	Leprogress_ItemObject  &$obj
	 * 
	 * @return	bool
	**/
	public function delete(/*** Leprogress_ItemObject ***/ $obj)
	{
		$handler = Legacy_Utils::getModuleHandler('history', $this->getDirname());
		$handler->deleteAll(new Criteria('item_id', $obj->get('item_id')));
		unset($handler);
	
		return parent::delete($obj);
	}

	/**
	 * proceedStep
	 * 
	 * @param	Leprogress_ItemObject	$obj
	 * 
	 * @return	bool
	**/
	public function proceedStep(/*** Leprogress_ItemObject ***/ $obj)
	{
		$approval = Legacy_Utils::getModuleHandler('approval', $obj->getDirname())->getNextApproval($obj->get('dirname'), $obj->get('dataname'), $obj->get('step'));
		if(is_object($approval)){
			$obj->set('step', $approval->get('step'));
            $obj->set('status', Lenum_WorkflowStatus::PROGRESS);
        }
		else{
			$obj->set('status', Lenum_WorkflowStatus::FINISHED);
		}
		if($this->insert($obj)){
            $result = null;
			XCube_DelegateUtils::call('Legacy_WorkflowClient.UpdateStatus', new XCube_Ref($result), $obj->get('dirname'), $obj->get('dataname'), $obj->get('target_id'), $obj->get('status'));
			return true;
		}
		return false;
	}

	/**
	 * revertStep
	 * 
	 * @param	Leprogress_ItemObject	$obj
	 * 
	 * @return	void
	**/
	public function revertStep(/*** Leprogress_ItemObject ***/ $obj)
	{
        $revertTo = Leprogress_Utils::getModuleConfig($obj->getDirname(), 'revert_to');
		$approval = Legacy_Utils::getModuleHandler('approval', $obj->getDirname())->getPreviousApproval($obj->get('dirname'), $obj->get('dataname'), $obj->get('step'));
		if(! is_object($approval) || $revertTo==Leprogress_RevertTo::ZERO){
            $obj->set('step', 0);
            $obj->set('status', Lenum_WorkflowStatus::REJECTED);
        }
		else{
            $obj->set('step', $approval->get('step'));
		}
		if($this->insert($obj)){
            $result = null;
			XCube_DelegateUtils::call('Legacy_WorkflowClient.UpdateStatus', new XCube_Ref($result), $obj->get('dirname'), $obj->get('dataname'), $obj->get('target_id'), $obj->get('status'));
			return true;
		}
		return false;
	}
}

?>

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
 * Leprogress_ApprovalObject
**/
class Leprogress_ApprovalObject extends XoopsSimpleObject
{
	public $mDirname = null;

	/**
	 * __construct
	 * 
	 * @param	string	$dirname
	 * 
	 * @return	void
	**/
	public function __construct()
	{
		$this->initVar('approval_id', XOBJ_DTYPE_INT, '', false);
		$this->initVar('uid', XOBJ_DTYPE_INT, '', false);
		$this->initVar('dirname', XOBJ_DTYPE_STRING, '', false, 45);
		$this->initVar('dataname', XOBJ_DTYPE_STRING, '', false, 45);
		$this->initVar('step', XOBJ_DTYPE_INT, 10, false);
	}

	/**
	 * getMyItem
	 * 
	 * @param	void
	 * 
	 * @return	Leprogress_ItemObject[]
	**/
	public function getMyItem()
	{
		$cri = new CriteriaCompo();
		$cri->add(new Criteria('status', Lenum_WorkflowStatus::PROGRESS));
		$cri->add(new Criteria('uid', $this->get('uid')));
		$cri->add(new Criteria('deletetime', 0));
		return Legacy_Utils::getModuleHandler('item', $this->getDirname())->getObjects($cri);
	}

	/**
	 * countMyItem
	 * 
	 * @param	void
	 * 
	 * @return	int
	**/
	public function countMyItem()
	{
		$cri = new CriteriaCompo();
		$cri->add(new Criteria('status', Lenum_WorkflowStatus::PROGRESS));
		$cri->add(new Criteria('uid', $this->get('uid')));
		$cri->add(new Criteria('deletetime', 0));
		return Legacy_Utils::getModuleHandler('item', $this->getDirname())->getCount($cri);
	}

	/**
	 * _getDirname
	 * 
	 * @param	void
	 * 
	 * @return	string
	**/
	public function getDirname()
	{
		return $this->mDirname;
	}
}

/**
 * Leprogress_ApprovalHandler
**/
class Leprogress_ApprovalHandler extends XoopsObjectGenericHandler
{
	public /*** string ***/ $mTable = '{dirname}_approval';

	public /*** string ***/ $mPrimary = 'approval_id';

	public /*** string ***/ $mClass = 'Leprogress_ApprovalObject';

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
	 * getNextApproval
	 * 
	 * @param	string	$dirname
	 * @param	string	$target
	 * @param	int 	$step
	 * 
	 * @return	Leprogress_ApprovalObject
	**/
	public function getNextApproval($dirname, $target, $step)
	{
		$cri = new CriteriaCompo();
		$cri->add(new Criteria('dirname', $dirname));
		$cri->add(new Criteria('dataname', $target));
		$cri->add(new Criteria('step', $step, '>'));
		$cri->setSort('step', 'ASC');
		$objs = $this->getObjects($cri);
		return (count($objs)>0) ? array_shift($objs) : NULL;
	}

	/**
	 * getPreviousApproval
	 * 
	 * @param	string	$dirname
	 * @param	string	$target
	 * @param	int 	$step
	 * 
	 * @return	Leprogress_ApprovalObject
	**/
	public function getPreviousApproval($dirname, $target, $step)
	{
		$cri = new CriteriaCompo();
		$cri->add(new Criteria('dirname', $dirname));
		$cri->add(new Criteria('dataname', $target));
		$cri->add(new Criteria('step', $step, '<'));
		$cri->setSort('step', 'DESC');
		$objs = $this->getObjects($cri);
		return (count($objs)>0) ? array_shift($objs) : NULL;
	}

	/**
	 * getApprovalList
	 * 
	 * @param	string	$dirname
	 * @param	string	$target
	 * 
	 * @return	Leprogress_ApprovalObject[]
	**/
	public function getApprovalList($dirname, $target)
	{
		$cri = new CriteriaCompo();
		$cri->add(new Criteria('dirname', $dirname));
		$cri->add(new Criteria('dataname', $target));
		$cri->setSort('step', 'ASC');
		return $this->getObjects($cri);
	}

}

?>

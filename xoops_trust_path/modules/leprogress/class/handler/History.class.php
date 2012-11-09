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
 * Leprogress_HistoryObject
**/
class Leprogress_HistoryObject extends XoopsSimpleObject
{
	public $mDirname = null;
	protected $_mItemLoadedFlag = false;
	public $mItem = null;

	/**
	 * __construct
	 * 
	 * @param	string	$dirname
	 * 
	 * @return	void
	**/
	public function __construct()
	{
		$this->initVar('progress_id', XOBJ_DTYPE_INT, '', false);
		$this->initVar('item_id', XOBJ_DTYPE_INT, '', false);
		$this->initVar('uid', XOBJ_DTYPE_INT, '', false);
		$this->initVar('step', XOBJ_DTYPE_INT, '', false);
		$this->initVar('result', XOBJ_DTYPE_INT, '', false);
		$this->initVar('comment', XOBJ_DTYPE_TEXT, '', false);
		$this->initVar('posttime', XOBJ_DTYPE_INT, time(), false);
	}

	/**
	 * loadItem
	 * 
	 * @param	void
	 * 
	 * @return	void
	 */
	public function loadItem()
	{
		if ($this->_mItemLoadedFlag == false) {
			$handler = Legacy_Utils::getModuleHandler('item', $this->getDirname());
			$this->mItem =& $handler->get($this->get('item_id'));
			$this->_mItemLoadedFlag = true;
		}
	}

	public function setMyStep()
	{
		$this->loadItem();
		$handler = Legacy_Utils::getModuleHandler('approval', $this->getDirname());
		$cri = new CriteriaCompo();
		$cri->add(new Criteria('dirname', $this->mItem->get('dirname')));
		$cri->add(new Criteria('dataname', $this->mItem->get('dataname')));
		$cri->add(new Criteria('uid', Legacy_Utils::getUid()));
		$objs = $handler->getObjects($cri);
		if(count($objs)==1){
			$obj = array_shift($objs);
			return $obj->get('step');
		}
	}

	/**
	 * getShowResult
	 * 
	 * @param	void
	 * 
	 * @return	string
	**/
	public function getShowResult()
	{
		switch($this->get('result')){
			case Leprogress_Result::HOLD:
				return _MD_LEPROGRESS_LANG_RESULT_HOLD;
			case Leprogress_Result::REJECT:
				return _MD_LEPROGRESS_LANG_RESULT_REJECT;
			case Leprogress_Result::APPROVE:
				return _MD_LEPROGRESS_LANG_RESULT_APPROVE;
		}
	}
}

/**
 * Leprogress_HistoryHandler
**/
class Leprogress_HistoryHandler extends XoopsObjectGenericHandler
{
	public /*** string ***/ $mTable = '{dirname}_history';

	public /*** string ***/ $mPrimary = 'progress_id';

	public /*** string ***/ $mClass = 'Leprogress_HistoryObject';

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

}

?>

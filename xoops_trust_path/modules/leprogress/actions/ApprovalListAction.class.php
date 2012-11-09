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

require_once LEPROGRESS_TRUST_PATH . '/class/AbstractListAction.class.php';

/**
 * Leprogress_ApprovalListAction
**/
class Leprogress_ApprovalListAction extends Leprogress_AbstractListAction
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
	 * &_getFilterForm
	 * 
	 * @param	void
	 * 
	 * @return	Leprogress_ApprovalFilterForm
	**/
	protected function &_getFilterForm()
	{
		$filter =& $this->mAsset->getObject('filter', 'Approval',false);
		$filter->prepare($this->_getPageNavi(), $this->_getHandler());
		return $filter;
	}

	/**
	 * getDefaultView
	 * 
	 * @param	void
	 * 
	 * @return	Enum
	**/
	public function getDefaultView()
	{
		$list = array();
		XCube_DelegateUtils::call('Legacy_WorkflowClient.GetClientList', new XCube_Ref($list));
		if(count($list)>0){
			$handler = $this->_getHandler();
			foreach(array_keys($list) as $key){
				$cri = new CriteriaCompo();
				$cri->add(new Criteria('dirname', $list[$key]['dirname']));
				$cri->add(new Criteria('dataname', $list[$key]['dataname']));
				$cri->setSort('step', 'ASC');
				$objs = $handler->getObjects($cri);
				if(count($objs)==0){
					$objs = array();
					$objs[0] = $handler->create();
					$objs[0]->set('dirname', $list[$key]['dirname']);
					$objs[0]->set('dataname', $list[$key]['dataname']);
				}
				$this->mObjects[$key] = $objs;
			}
		}
	/*
		$this->mFilter =& $this->_getFilterForm();
		$this->mFilter->fetch();
	
		$handler =& $this->_getHandler();
		$this->mObjects =& $handler->getObjects($this->mFilter->getCriteria());
	*/
		return LEPROGRESS_FRAME_VIEW_INDEX;
	}

	/**
	 * _getBaseUrl
	 * 
	 * @param	void
	 * 
	 * @return	string
	**/
	protected function _getBaseUrl()
	{
		return Legacy_Utils::renderUri($this->mAsset->mDirname, 'approval');
	}

	/**
	 * executeViewIndex
	 * 
	 * @param	XCube_RenderTarget	&$render
	 * 
	 * @return	void
	**/
	public function executeViewIndex(/*** XCube_RenderTarget ***/ &$render)
	{
		$render->setTemplateName($this->mAsset->mDirname . '_approval_list.html');
		$render->setAttribute('objects', $this->mObjects);
		$render->setAttribute('dirname', $this->mAsset->mDirname);
		$render->setAttribute('query', 'dirname=%s&dataname=%s');
	}
}

?>

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
 * Leprogress_HistoryListAction
**/
class Leprogress_HistoryListAction extends Leprogress_AbstractListAction
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
	 * &_getFilterForm
	 * 
	 * @param	void
	 * 
	 * @return	Leprogress_HistoryFilterForm
	**/
	protected function &_getFilterForm()
	{
		$filter =& $this->mAsset->getObject('filter', 'History',false);
		$filter->prepare($this->_getPageNavi(), $this->_getHandler());
		return $filter;
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
		return Legacy_Utils::renderUri($this->mAsset->mDirname, 'history');
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
		$itemObj = Legacy_Utils::getModuleHandler('item', $this->mAsset->mDirname)->get($this->mRoot->mContext->mRequest->getRequest('item_id'));
		$render->setTemplateName($this->mAsset->mDirname . '_history_list.html');
		$render->setAttribute('objects', $this->mObjects);
		$render->setAttribute('dirname', $this->mAsset->mDirname);
		$render->setAttribute('item', $itemObj);
		$render->setAttribute('pageNavi', $this->mFilter->mNavi);
	}
}

?>

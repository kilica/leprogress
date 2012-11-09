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

require_once LEPROGRESS_TRUST_PATH . '/actions/ItemListAction.class.php';

/**
 * Leprogress_ItemListAction
**/
class Leprogress_MytaskListAction extends Leprogress_ItemListAction
{
    /**
     * &_getFilterForm
     * 
     * @param   void
     * 
     * @return  Leprogress_ItemFilterForm
    **/
    protected function &_getFilterForm()
    {
        $filter =& $this->mAsset->getObject('filter', 'Mytask',false);
        $filter->prepare($this->_getPageNavi(), $this->_getHandler());
        return $filter;
    }

    /**
     * getDefaultView
     * 
     * @param   void
     * 
     * @return  Enum
    **/
    public function getDefaultView()
    {
        $this->mFilter =& $this->_getFilterForm();
        $this->mFilter->fetch();
    
        $itemObjs = array();
        $handler = $this->_getHandler();
    
        $approvalArr = Legacy_Utils::getModuleHandler('approval', $this->mAsset->mDirname)->getObjects(new Criteria('uid', Legacy_Utils::getUid()));;
        foreach($approvalArr as $approval){
            $cri = new CriteriaCompo();
            $cri->add(new Criteria('deletetime', 0));
            $cri->add(new Criteria('dirname', $approval->get('dirname')));
            $cri->add(new Criteria('dataname', $approval->get('dataname')));
            $cri->add(new Criteria('step', $approval->get('step')));
            $cri->add(new Criteria('status', Lenum_WorkflowStatus::FINISHED, '<>'));
            $cri->add(new Criteria('status', Lenum_WorkflowStatus::REJECTED, '<>'));
            $itemObjs = array_merge($itemObjs, $handler->getObjects($cri));
        }
        $this->mObjects = $itemObjs;
    
        return LEPROGRESS_FRAME_VIEW_INDEX;
    }



}

?>

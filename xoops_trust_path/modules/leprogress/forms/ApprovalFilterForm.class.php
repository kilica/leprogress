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

require_once LEPROGRESS_TRUST_PATH . '/class/AbstractFilterForm.class.php';

define('LEPROGRESS_APPROVAL_SORT_KEY_APPROVAL_ID', 1);
define('LEPROGRESS_APPROVAL_SORT_KEY_UID', 2);
define('LEPROGRESS_APPROVAL_SORT_KEY_DIRNAME', 3);
define('LEPROGRESS_APPROVAL_SORT_KEY_DATANAME', 4);
define('LEPROGRESS_APPROVAL_SORT_KEY_STEP', 5);
define('LEPROGRESS_APPROVAL_SORT_KEY_DEFAULT', LEPROGRESS_APPROVAL_SORT_KEY_APPROVAL_ID);

/**
 * Leprogress_ApprovalFilterForm
**/
class Leprogress_ApprovalFilterForm extends Leprogress_AbstractFilterForm
{
    public /*** string[] ***/ $mSortKeys = array(
        LEPROGRESS_APPROVAL_SORT_KEY_APPROVAL_ID => 'approval_id',
        LEPROGRESS_APPROVAL_SORT_KEY_UID => 'uid',
        LEPROGRESS_APPROVAL_SORT_KEY_DIRNAME => 'dirname',
        LEPROGRESS_APPROVAL_SORT_KEY_DATANAME => 'dataname',
        LEPROGRESS_APPROVAL_SORT_KEY_STEP => 'step'
    );

    /**
     * getDefaultSortKey
     * 
     * @param   void
     * 
     * @return  void
    **/
    public function getDefaultSortKey()
    {
        return array(LEPROGRESS_APPROVAL_SORT_KEY_DIRNAME, LEPROGRESS_APPROVAL_SORT_KEY_DATANAME, LEPROGRESS_APPROVAL_SORT_KEY_STEP);
    }

    /**
     * fetch
     * 
     * @param   void
     * 
     * @return  void
    **/
    public function fetch()
    {
        parent::fetch();
    
        $root =& XCube_Root::getSingleton();
    
        if (($value = $root->mContext->mRequest->getRequest('approval_id')) !== null) {
            $this->mNavi->addExtra('approval_id', $value);
            $this->_mCriteria->add(new Criteria('approval_id', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('uid')) !== null) {
            $this->mNavi->addExtra('uid', $value);
            $this->_mCriteria->add(new Criteria('uid', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('dirname')) !== null) {
            $this->mNavi->addExtra('dirname', $value);
            $this->_mCriteria->add(new Criteria('dirname', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('dataname')) !== null) {
            $this->mNavi->addExtra('dataname', $value);
            $this->_mCriteria->add(new Criteria('dataname', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('step')) !== null) {
            $this->mNavi->addExtra('step', $value);
            $this->_mCriteria->add(new Criteria('step', $value));
        }
    
        foreach(array_keys($this->mSort) as $k){
            $this->_mCriteria->addSort($this->getSort($k), $this->getOrder($k));
        }
    }
}

?>

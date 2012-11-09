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

define('LEPROGRESS_ITEM_SORT_KEY_ITEM_ID', 1);
define('LEPROGRESS_ITEM_SORT_KEY_DIRNAME', 2);
define('LEPROGRESS_ITEM_SORT_KEY_DATANAME', 3);
define('LEPROGRESS_ITEM_SORT_KEY_TARGET_ID', 4);
define('LEPROGRESS_ITEM_SORT_KEY_UID', 5);
define('LEPROGRESS_ITEM_SORT_KEY_STEP', 6);
define('LEPROGRESS_ITEM_SORT_KEY_STATUS', 7);
define('LEPROGRESS_ITEM_SORT_KEY_POSTTIME', 8);
define('LEPROGRESS_ITEM_SORT_KEY_DELETETIME', 9);
define('LEPROGRESS_ITEM_SORT_KEY_DEFAULT', LEPROGRESS_ITEM_SORT_KEY_ITEM_ID);

/**
 * Leprogress_MytaskFilterForm
**/
class Leprogress_MytaskFilterForm extends Leprogress_AbstractFilterForm
{
    public /*** string[] ***/ $mSortKeys = array(
        LEPROGRESS_ITEM_SORT_KEY_ITEM_ID => 'item_id',
        LEPROGRESS_ITEM_SORT_KEY_DIRNAME => 'dirname',
        LEPROGRESS_ITEM_SORT_KEY_DATANAME => 'dataname',
        LEPROGRESS_ITEM_SORT_KEY_TARGET_ID => 'target_id',
        LEPROGRESS_ITEM_SORT_KEY_UID => 'uid',
        LEPROGRESS_ITEM_SORT_KEY_STEP => 'step',
        LEPROGRESS_ITEM_SORT_KEY_STATUS => 'status',
        LEPROGRESS_ITEM_SORT_KEY_POSTTIME => 'posttime',
        LEPROGRESS_ITEM_SORT_KEY_DELETETIME => 'deletetime'
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
        return array(LEPROGRESS_ITEM_SORT_KEY_POSTTIME);
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
    
        if (($value = $root->mContext->mRequest->getRequest('item_id')) !== null) {
            $this->mNavi->addExtra('item_id', $value);
            $this->_mCriteria->add(new Criteria('item_id', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('dirname')) !== null) {
            $this->mNavi->addExtra('dirname', $value);
            $this->_mCriteria->add(new Criteria('dirname', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('dataname')) !== null) {
            $this->mNavi->addExtra('dataname', $value);
            $this->_mCriteria->add(new Criteria('dataname', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('target_id')) !== null) {
            $this->mNavi->addExtra('target_id', $value);
            $this->_mCriteria->add(new Criteria('target_id', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('uid')) !== null) {
            $this->mNavi->addExtra('uid', $value);
            $this->_mCriteria->add(new Criteria('uid', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('step')) !== null) {
            $this->mNavi->addExtra('step', $value);
            $this->_mCriteria->add(new Criteria('step', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('status')) !== null) {
            $this->mNavi->addExtra('status', $value);
            $this->_mCriteria->add(new Criteria('status', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('posttime')) !== null) {
            $this->mNavi->addExtra('posttime', $value);
            $this->_mCriteria->add(new Criteria('posttime', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('deletetime')) !== null) {
            $this->mNavi->addExtra('deletetime', $value);
            $this->_mCriteria->add(new Criteria('deletetime', $value));
        }
    
        foreach(array_keys($this->mSort) as $k){
            $this->_mCriteria->addSort($this->getSort($k), $this->getOrder($k));
        }
    }
}

?>

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

define('LEPROGRESS_HISTORY_SORT_KEY_PROGRESS_ID', 1);
define('LEPROGRESS_HISTORY_SORT_KEY_ITEM_ID', 2);
define('LEPROGRESS_HISTORY_SORT_KEY_UID', 3);
define('LEPROGRESS_HISTORY_SORT_KEY_STEP', 4);
define('LEPROGRESS_HISTORY_SORT_KEY_RESULT', 5);
define('LEPROGRESS_HISTORY_SORT_KEY_COMMENT', 6);
define('LEPROGRESS_HISTORY_SORT_KEY_POSTTIME', 7);
define('LEPROGRESS_HISTORY_SORT_KEY_DEFAULT', LEPROGRESS_HISTORY_SORT_KEY_PROGRESS_ID);

/**
 * Leprogress_HistoryFilterForm
**/
class Leprogress_HistoryFilterForm extends Leprogress_AbstractFilterForm
{
    public /*** string[] ***/ $mSortKeys = array(
        LEPROGRESS_HISTORY_SORT_KEY_PROGRESS_ID => 'progress_id',
        LEPROGRESS_HISTORY_SORT_KEY_ITEM_ID => 'item_id',
        LEPROGRESS_HISTORY_SORT_KEY_UID => 'uid',
        LEPROGRESS_HISTORY_SORT_KEY_STEP => 'step',
        LEPROGRESS_HISTORY_SORT_KEY_RESULT => 'result',
        LEPROGRESS_HISTORY_SORT_KEY_COMMENT => 'comment',
        LEPROGRESS_HISTORY_SORT_KEY_POSTTIME => 'posttime'
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
        return LEPROGRESS_HISTORY_SORT_KEY_DEFAULT;
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
    
        if (($value = $root->mContext->mRequest->getRequest('progress_id')) !== null) {
            $this->mNavi->addExtra('progress_id', $value);
            $this->_mCriteria->add(new Criteria('progress_id', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('item_id')) !== null) {
            $this->mNavi->addExtra('item_id', $value);
            $this->_mCriteria->add(new Criteria('item_id', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('uid')) !== null) {
            $this->mNavi->addExtra('uid', $value);
            $this->_mCriteria->add(new Criteria('uid', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('step')) !== null) {
            $this->mNavi->addExtra('step', $value);
            $this->_mCriteria->add(new Criteria('step', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('result')) !== null) {
            $this->mNavi->addExtra('result', $value);
            $this->_mCriteria->add(new Criteria('result', $value));
        }
    
        if (($value = $root->mContext->mRequest->getRequest('posttime')) !== null) {
            $this->mNavi->addExtra('posttime', $value);
            $this->_mCriteria->add(new Criteria('posttime', $value));
        }
    
        foreach(array_keys($this->mSort) as $k){
            $this->_mCriteria->addSort($this->getSort($k), $this->getOrder($k));
        }
    }
}

?>

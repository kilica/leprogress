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
 * Leprogress_AbstractFilterForm
**/
abstract class Leprogress_AbstractFilterForm
{
    public /*** Enum[] ***/ $mSort = array();

    public /*** string[] ***/ $mSortKeys = array();

    public /*** XCube_PageNavigator ***/ $mNavi = null;

    protected /*** XoopsObjectGenericHandler ***/ $_mHandler = null;

    protected /*** Criteria ***/ $_mCriteria = null;

    /**
     * _getId
     * 
     * @param   void
     * 
     * @return  int
    **/
    protected function _getId()
    {
    }

    /**
     * &_getHandler
     * 
     * @param   void
     * 
     * @return  XoopsObjectGenericHandler
    **/
    protected function &_getHandler()
    {
    }

    /**
     * __construct
     * 
     * @param   void
     * 
     * @return  void
    **/
    public function __construct()
    {
        $this->_mCriteria = new CriteriaCompo();
    }

    /**
     * prepare
     * 
     * @param   XCube_PageNavigator  &$navi
     * @param   XoopsObjectGenericHandler  &$handler
     * 
     * @return  void
    **/
    public function prepare(/*** XCube_PageNavigator ***/ &$navi,/*** XoopsObjectGenericHandler ***/ &$handler)
    {
        $this->mNavi =& $navi;
        $this->_mHandler =& $handler;
    
        $this->mNavi->mGetTotalItems->add(array(&$this, 'getTotalItems'));
    }

    /**
     * getTotalItems
     * 
     * @param   int  &$total
     * 
     * @return  void
    **/
    public function getTotalItems(/*** int ***/ &$total)
    {
        $total = $this->_mHandler->getCount($this->getCriteria());
    }

    /**
     * fetchSort
     * 
     * @param   void
     * 
     * @return  void
    **/
    protected function fetchSort()
    {
        $root =& XCube_Root::getSingleton();
        $sortReq = $root->mContext->mRequest->getRequest($this->mNavi->mPrefix . 'sort');
        $sortArr = (is_array($sortReq)) ? $sortReq : array($sortReq);
        foreach($sortArr as $sort){
        	if(! is_null($sort)){
	            $this->mSort[] = intval($sort);
	        }
        }
    
        if(count($this->mSort)==0)
        {
            if(is_array($this->getDefaultSortKey())){
                $this->mSort = $this->getDefaultSortKey();
            }
            else{
                $this->mSort[] = $this->getDefaultSortKey();
            }
        }
    
        foreach(array_keys($this->mSort) as $k){
            $this->mNavi->mSort[$this->mNavi->mPrefix . 'sort' . $k] = $this->mSort[$k];
        }
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
        $this->mNavi->fetch();
        $this->fetchSort();
    }

    /**
     * getSort
     * 
     * @param   int $k
     * 
     * @return  Enum
    **/
    public function getSort(/*** int ***/ $k)
    {
        $sortkey = abs($this->mSort[$k]);
        return $this->mSortKeys[$sortkey];
    }

    /**
     * getOrder
     * 
     * @param   int $k
     * 
     * @return  Enum
    **/
    public function getOrder($k)
    {
        return ($this->mSort[$k] < 0) ? 'desc' : 'asc';
    }

    /**
     * &getCriteria
     * 
     * @param   int  $start
     * @param   int  $limit
     * 
     * @return  Criteria
    **/
    public function &getCriteria(/*** int ***/ $start = null,/*** int ***/ $limit = null)
    {
        $t_start = ($start === null) ? $this->mNavi->getStart() : intval($start);
        $t_limit = ($limit === null) ? $this->mNavi->getPerpage() : intval($limit);
    
        $criteria = $this->_mCriteria;
    
        $criteria->setStart($t_start);
        $criteria->setLimit($t_limit);
        return $criteria;
    }
}

?>

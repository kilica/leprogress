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

require_once LEPROGRESS_TRUST_PATH . '/class/AbstractEditAction.class.php';

/**
 * Leprogress_AbstractDeleteAction
**/
abstract class Leprogress_AbstractDeleteAction extends Leprogress_AbstractEditAction
{
    /**
     * _isEnableCreate
     * 
     * @param   void
     * 
     * @return  bool
    **/
    protected function _isEnableCreate()
    {
        return false;
    }

    /**
     * _getActionName
     * 
     * @param   void
     * 
     * @return  string
    **/
    protected function _getActionName()
    {
        return _DELETE;
    }

    /**
     * prepare
     * 
     * @param   void
     * 
     * @return  bool
    **/
    public function prepare()
    {
        return parent::prepare() && is_object($this->mObject);
    }

    /**
     * _doExecute
     * 
     * @param   void
     * 
     * @return  Enum
    **/
    protected function _doExecute()
    {
        if($this->mObjectHandler->delete($this->mObject))
        {
            return LEPROGRESS_FRAME_VIEW_SUCCESS;
        }
    
        return LEPROGRESS_FRAME_VIEW_ERROR;
    }
}

?>

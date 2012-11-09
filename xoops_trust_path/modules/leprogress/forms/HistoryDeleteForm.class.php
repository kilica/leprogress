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

require_once XOOPS_ROOT_PATH . '/core/XCube_ActionForm.class.php';
require_once XOOPS_MODULE_PATH . '/legacy/class/Legacy_Validator.class.php';

/**
 * Leprogress_HistoryDeleteForm
**/
class Leprogress_HistoryDeleteForm extends XCube_ActionForm
{
    /**
     * getTokenName
     * 
     * @param   void
     * 
     * @return  string
    **/
    public function getTokenName()
    {
        return "module.leprogress.HistoryDeleteForm.TOKEN";
    }

    /**
     * prepare
     * 
     * @param   void
     * 
     * @return  void
    **/
    public function prepare()
    {
        //
        // Set form properties
        //
        $this->mFormProperties['progress_id'] = new XCube_IntProperty('progress_id');
    
        //
        // Set field properties
        //
        $this->mFieldProperties['progress_id'] = new XCube_FieldProperty($this);
        $this->mFieldProperties['progress_id']->setDependsByArray(array('required'));
        $this->mFieldProperties['progress_id']->addMessage('required', _MD_LEPROGRESS_ERROR_REQUIRED, _MD_LEPROGRESS_LANG_PROGRESS_ID);
    }

    /**
     * load
     * 
     * @param   XoopsSimpleObject  &$obj
     * 
     * @return  void
    **/
    public function load(/*** XoopsSimpleObject ***/ &$obj)
    {
        $this->set('progress_id', $obj->get('progress_id'));
    }

    /**
     * update
     * 
     * @param   XoopsSimpleObject  &$obj
     * 
     * @return  void
    **/
    public function update(/*** XoopsSimpleObject ***/ &$obj)
    {
        $obj->set('progress_id', $this->get('progress_id'));
    }
}

?>

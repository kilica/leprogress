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
 * Leprogress_ApprovalDeleteForm
**/
class Leprogress_ApprovalDeleteForm extends XCube_ActionForm
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
        return "module.leprogress.ApprovalDeleteForm.TOKEN";
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
        $this->mFormProperties['approval_id'] = new XCube_IntProperty('approval_id');
    
        //
        // Set field properties
        //
        $this->mFieldProperties['approval_id'] = new XCube_FieldProperty($this);
        $this->mFieldProperties['approval_id']->setDependsByArray(array('required'));
        $this->mFieldProperties['approval_id']->addMessage('required', _MD_LEPROGRESS_ERROR_REQUIRED, _MD_LEPROGRESS_LANG_APPROVAL_ID);
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
        $this->set('approval_id', $obj->get('approval_id'));
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
        $obj->set('approval_id', $this->get('approval_id'));
    }
}

?>

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
 * Leprogress_ItemEditForm
**/
class Leprogress_ItemEditForm extends XCube_ActionForm
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
        return "module.leprogress.ItemEditForm.TOKEN";
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
        $this->mFormProperties['item_id'] = new XCube_IntProperty('item_id');
        $this->mFormProperties['title'] = new XCube_StringProperty('title');
        $this->mFormProperties['dirname'] = new XCube_StringProperty('dirname');
        $this->mFormProperties['dataname'] = new XCube_StringProperty('dataname');
        $this->mFormProperties['target_id'] = new XCube_IntProperty('target_id');
        $this->mFormProperties['uid'] = new XCube_IntProperty('uid');
        $this->mFormProperties['step'] = new XCube_IntProperty('step');
        $this->mFormProperties['status'] = new XCube_IntProperty('status');
        $this->mFormProperties['url'] = new XCube_StringProperty('url');
        $this->mFormProperties['posttime'] = new XCube_IntProperty('posttime');
        $this->mFormProperties['deletetime'] = new XCube_IntProperty('deletetime');
    
        //
        // Set field properties
        //
        $this->mFieldProperties['item_id'] = new XCube_FieldProperty($this);
        $this->mFieldProperties['item_id']->setDependsByArray(array('required'));
        $this->mFieldProperties['item_id']->addMessage('required', _MD_LEPROGRESS_ERROR_REQUIRED, _MD_LEPROGRESS_LANG_ITEM_ID);
    
        $this->mFieldProperties['dirname'] = new XCube_FieldProperty($this);
        $this->mFieldProperties['dirname']->setDependsByArray(array('required'));
        $this->mFieldProperties['dirname'] = new XCube_FieldProperty($this);
        $this->mFieldProperties['dirname']->setDependsByArray(array('required','maxlength'));
        $this->mFieldProperties['dirname']->addMessage('required', _MD_LEPROGRESS_ERROR_REQUIRED, _MD_LEPROGRESS_LANG_DIRNAME, '45');
        $this->mFieldProperties['dirname']->addMessage('maxlength', _MD_LEPROGRESS_ERROR_MAXLENGTH, _MD_LEPROGRESS_LANG_DIRNAME, '45');
        $this->mFieldProperties['dirname']->addVar('maxlength', '45');
    
        $this->mFieldProperties['dataname'] = new XCube_FieldProperty($this);
        $this->mFieldProperties['dataname']->setDependsByArray(array('required','maxlength'));
        $this->mFieldProperties['dataname']->addMessage('required', _MD_LEPROGRESS_ERROR_REQUIRED, _MD_LEPROGRESS_LANG_DATANAME, '45');
        $this->mFieldProperties['dataname']->addMessage('maxlength', _MD_LEPROGRESS_ERROR_MAXLENGTH, _MD_LEPROGRESS_LANG_DATANAME, '45');
        $this->mFieldProperties['dataname']->addVar('maxlength', '45');
    
        $this->mFieldProperties['target_id'] = new XCube_FieldProperty($this);
        $this->mFieldProperties['target_id']->setDependsByArray(array('required'));
        $this->mFieldProperties['target_id']->addMessage('required', _MD_LEPROGRESS_ERROR_REQUIRED, _MD_LEPROGRESS_LANG_TARGET_ID);
    
        $this->mFieldProperties['uid'] = new XCube_FieldProperty($this);
        $this->mFieldProperties['uid']->setDependsByArray(array('required'));
        $this->mFieldProperties['uid']->addMessage('required', _MD_LEPROGRESS_ERROR_REQUIRED, _MD_LEPROGRESS_LANG_UID);
    
        $this->mFieldProperties['step'] = new XCube_FieldProperty($this);
        $this->mFieldProperties['step']->setDependsByArray(array('required'));
        $this->mFieldProperties['step']->addMessage('required', _MD_LEPROGRESS_ERROR_REQUIRED, _MD_LEPROGRESS_LANG_STEP);
    
        $this->mFieldProperties['status'] = new XCube_FieldProperty($this);
        $this->mFieldProperties['status']->setDependsByArray(array('required'));
        $this->mFieldProperties['status']->addMessage('required', _MD_LEPROGRESS_ERROR_REQUIRED, _MD_LEPROGRESS_LANG_STATUS);
    
        $this->mFieldProperties['deletetime'] = new XCube_FieldProperty($this);
        $this->mFieldProperties['deletetime']->setDependsByArray(array('required'));
        $this->mFieldProperties['deletetime']->addMessage('required', _MD_LEPROGRESS_ERROR_REQUIRED, _MD_LEPROGRESS_LANG_DELETETIME);
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
        $this->set('item_id', $obj->get('item_id'));
        $this->set('title', $obj->get('title'));
        $this->set('dirname', $obj->get('dirname'));
        $this->set('dataname', $obj->get('dataname'));
        $this->set('target_id', $obj->get('target_id'));
        $this->set('uid', $obj->get('uid'));
        $this->set('step', $obj->get('step'));
        $this->set('status', $obj->get('status'));
        $this->set('url', $obj->get('url'));
        $this->set('posttime', $obj->get('posttime'));
        $this->set('deletetime', $obj->get('deletetime'));
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
        $obj->set('item_id', $this->get('item_id'));
        $obj->set('title', $this->get('title'));
        $obj->set('dirname', $this->get('dirname'));
        $obj->set('dataname', $this->get('dataname'));
        $obj->set('target_id', $this->get('target_id'));
        $obj->set('uid', $this->get('uid'));
        $obj->set('step', $this->get('step'));
        $obj->set('status', $this->get('status'));
        $obj->set('url', $this->get('url'));
        $obj->set('deletetime', $this->get('deletetime'));
    }
}

?>

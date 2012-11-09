<?php
/**
 * @file
 * @package legacy
 * @version $Id$
**/

if(!defined('XOOPS_ROOT_PATH'))
{
    exit();
}

/**
 * Interface of workflow delegate
**/
abstract class Legacy_AbstractWorkflowDelegate implements Legacy_iWorkflowDelegateInterface
{
    /**
     * addItem
     *
     * @param string $dirname
     * @param string $target
     * @param int    $id
     *
     * @return  void
     */ 
    abstract public function addItem(/*** string ***/ $dirname, /*** string ***/ $target, /*** int ***/ $id);

    /**
     * deleteItem
     *
     * @param string $dirname
     * @param string $target
     * @param int    $id
     *
     * @return  void
     */ 
    abstract public function deleteItem(/*** string ***/ $dirname, /*** string ***/ $target, /*** int ***/ $id);

    /**
     * getHistory
     *
     * @param XoopsSimpleObject[] &$historyArr
     * @param string $dirname
     * @param string $target
     * @param int    $id
     *
     * @return  void
     */ 
    abstract public function getHistory(/*** bool ***/ &$response, /*** string ***/ $dirname, /*** string ***/ $target, /*** int ***/ $id);


}

?>

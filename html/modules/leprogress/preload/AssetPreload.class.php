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

require_once XOOPS_TRUST_PATH . '/modules/leprogress/preload/AssetPreload.class.php';
Leprogress_AssetPreloadBase::prepare(basename(dirname(dirname(__FILE__))));

?>

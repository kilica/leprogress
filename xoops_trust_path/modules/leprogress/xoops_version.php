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

if(!defined('LEPROGRESS_TRUST_PATH'))
{
	define('LEPROGRESS_TRUST_PATH',XOOPS_TRUST_PATH . '/modules/leprogress');
}

require_once LEPROGRESS_TRUST_PATH . '/class/LeprogressUtils.class.php';

//
// Define a basic manifesto.
//
$modversion['name'] = _MI_LEPROGRESS_LANG_LEPROGRESS;
$modversion['version'] = 0.2;
$modversion['description'] = _MI_LEPROGRESS_DESC_LEPROGRESS;
$modversion['author'] = _MI_LEPROGRESS_LANG_AUTHOR;
$modversion['credits'] = _MI_LEPROGRESS_LANG_CREDITS;
$modversion['help'] = 'help.html';
$modversion['license'] = 'GPL';
$modversion['official'] = 0;
$modversion['image'] = 'images/leprogress.png';
$modversion['dirname'] = $myDirName;
$modversion['trust_dirname'] = 'leprogress';
$modversion['role'] = 'workflow';


$modversion['cube_style'] = true;
$modversion['legacy_installer'] = array(
	'installer'   => array(
		'class' 	=> 'Installer',
		'namespace' => 'Leprogress',
		'filepath'	=> LEPROGRESS_TRUST_PATH . '/admin/class/installer/LeprogressInstaller.class.php'
	),
	'uninstaller' => array(
		'class' 	=> 'Uninstaller',
		'namespace' => 'Leprogress',
		'filepath'	=> LEPROGRESS_TRUST_PATH . '/admin/class/installer/LeprogressUninstaller.class.php'
	),
	'updater' => array(
		'class' 	=> 'Updater',
		'namespace' => 'Leprogress',
		'filepath'	=> LEPROGRESS_TRUST_PATH . '/admin/class/installer/LeprogressUpdater.class.php'
	)
);
$modversion['disable_legacy_2nd_installer'] = false;

$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'] = array(
	'{prefix}_{dirname}_approval',
	'{prefix}_{dirname}_history',
	'{prefix}_{dirname}_item',
##[cubson:tables]
##[/cubson:tables]
);

//
// Templates. You must never change [cubson] chunk to get the help of cubson.
//
$modversion['templates'] = array(
/*
	array(
		'file'		  => '{dirname}_xxx.html',
		'description' => _MI_LEPROGRESS_TPL_XXX
	),
*/
##[cubson:templates]
	array('file' => '{dirname}_approval_list.html','description' => _MI_LEPROGRESS_TPL_APPROVAL_LIST),
	array('file' => '{dirname}_approval_edit.html','description' => _MI_LEPROGRESS_TPL_APPROVAL_EDIT),
	array('file' => '{dirname}_approval_delete.html','description' => _MI_LEPROGRESS_TPL_APPROVAL_DELETE),
	array('file' => '{dirname}_item_list.html','description' => _MI_LEPROGRESS_TPL_ITEM_LIST),
	array('file' => '{dirname}_item_view.html','description' => _MI_LEPROGRESS_TPL_ITEM_VIEW),
	array('file' => '{dirname}_history_list.html','description' => _MI_LEPROGRESS_TPL_HISTORY_LIST),
	array('file' => '{dirname}_history_delete.html','description' => _MI_LEPROGRESS_TPL_HISTORY_DELETE),
	array('file' => '{dirname}_history_edit.html','description' => _MI_LEPROGRESS_TPL_HISTORY_EDIT),
	array('file' => '{dirname}_history_view.html','description' => _MI_LEPROGRESS_TPL_HISTORY_VIEW),
	array('file' => '{dirname}_inc_menu.html','description' => 'menu'),
##[/cubson:templates]
);

//
// Admin panel setting
//
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/index.php?action=Index';
$modversion['adminmenu'] = array(
/*
	array(
		'title'    => _MI_LEPROGRESS_LANG_XXXX,
		'link'	   => 'admin/index.php?action=xxx',
		'keywords' => _MI_LEPROGRESS_KEYWORD_XXX,
		'show'	   => true,
		'absolute' => false
	),
*/
##[cubson:adminmenu]
##[/cubson:adminmenu]
);

//
// Public side control setting
//
$modversion['hasMain'] = 1;
$modversion['hasSearch'] = 0;
$modversion['sub'] = array(
/*
	array(
		'name' => _MI_LEPROGRESS_LANG_SUB_XXX,
		'url'  => 'index.php?action=XXX'
	),
*/
##[cubson:submenu]
##[/cubson:submenu]
);

//
// Config setting
//
$modversion['config'] = array(
/*
	array(
		'name'			=> 'xxxx',
		'title' 		=> '_MI_LEPROGRESS_TITLE_XXXX',
		'description'	=> '_MI_LEPROGRESS_DESC_XXXX',
		'formtype'		=> 'xxxx',
		'valuetype' 	=> 'xxx',
		'options'		=> array(xxx => xxx,xxx => xxx),
		'default'		=> 0
	),
*/
##[cubson:config]
	array(
		'name'			=> 'revert_to',
		'title' 		=> '_MI_LEPROGRESS_LANG_REVERT_TO',
		'description'	=> '_MI_LEPROGRESS_DESC_REVERT_TO',
		'formtype'		=> 'select' ,
		'valuetype' 	=> 'string' ,
		'default'		=> '0',
		'options'		=> array(_MI_LEPROGRESS_REVERTTO_ZERO=>Leprogress_RevertTo::ZERO, _MI_LEPROGRESS_REVERTTO_FORMER=>Leprogress_RevertTo::FORMER)
	),
    array(
        'name'			=> 'css_file',
        'title' 		=> '_MI_LEPROGRESS_LANG_CSS_FILE',
        'description'	=> '_MI_LEPROGRESS_DESC_CSS_FILE',
        'formtype'		=> 'textbox' ,
        'valuetype' 	=> 'text' ,
        'default'		=> '/modules/'.$myDirName.'/style.css',
        'options'		=> array()
    ),
##[/cubson:config]
);

//
// Block setting
//
$modversion['blocks'] = array(
/*
	x => array(
		'func_num'			=> x,
		'file'				=> 'xxxBlock.class.php',
		'class' 			=> 'xxx',
		'name'				=> _MI_LEPROGRESS_BLOCK_NAME_xxx,
		'description'		=> _MI_LEPROGRESS_BLOCK_DESC_xxx,
		'options'			=> '',
		'template'			=> '{dirname}_block_xxx.html',
		'show_all_module'	=> true,
		'visible_any'		=> true
	),
*/
##[cubson:block]
##[/cubson:block]
);

?>

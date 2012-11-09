<?php
/**
 * @package leprogress
 * @version $Id: DelegateFunctions.class.php,v 1.1 2007/05/15 02:35:07 minahito Exp $
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

class Leprogress_WorkflowDelegate implements Legacy_iWorkflowDelegate
{
	/**
	 * addItem
	 *
	 * @param string $title
	 * @param string $dirname
	 * @param string $dataname
	 * @param int	 $data_id
	 * @param string $url
	 *
	 * @return	void
	 */ 
	public static function addItem(/*** string ***/ $title, /*** string ***/ $dirname, /*** string ***/ $dataname, /*** int ***/ $data_id, /*** string ***/ $url)
	{
		$handler = Legacy_Utils::getModuleHandler('item', self::_getDirname());
		$objs = $handler->getObjects(self::_getItemCriteria($dirname, $dataname, $data_id));
		if(count($objs)==0){
			$obj = $handler->create();
			$obj->set('title', $title);
			$obj->set('dirname', $dirname);
			$obj->set('dataname', $dataname);
			$obj->set('target_id', $data_id);
			$obj->set('url', $url);
			$obj->set('uid', Legacy_Utils::getUid());
			$obj->setFirstStep();
			$handler->insert($obj);
		}
		elseif(count($objs)==1){
			$obj = array_shift($objs);
			$obj->set('title', $title);
			$obj->set('status', Lenum_WorkflowStatus::PROGRESS);
            $obj->set('url', $url);
			$obj->set('updatetime', time());
			$obj->setFirstStep();
			$obj->incrementRevision();
			$handler->insert($obj);
		}
	}

	/**
	 * deleteItem
	 *
	 * @param string $dirname
	 * @param string $dataname
	 * @param int	 $data_id
	 *
	 * @return	void
	 */ 
	public static function deleteItem(/*** string ***/ $dirname, /*** string ***/ $dataname, /*** int ***/ $data_id)
	{
		$handler = Legacy_Utils::getModuleHandler('item', self::_getDirname());
		$objs = $handler->getObjects(self::_getItemCriteria($dirname, $dataname, $data_id));
		if(count($objs)==1){
			$handler->delete(array_shift($objs));
		}
	}

	/**
	 * getHistory
	 *
	 * @param mix[] &$historyArr
	 * @param string $dirname
	 * @param string $dataname
	 * @param int	 $data_id
	 *
	 * @return	void
	 */ 
	public static function getHistory(/*** mix[] ***/ &$historyArr, /*** string ***/ $dirname, /*** string ***/ $dataname, /*** int ***/ $data_id)
	{
		$handler = Legacy_Utils::getModuleHandler('item', self::_getDirname());
		$objs = $handler->getObjects(self::_getItemCriteria($dirname, $dataname, $data_id));
		if(count($objs)==1){
			$obj = array_shift($objs);
			$obj->loadHistory();
			foreach($obj->mHistory as $history){
				$hisotryArr['step'][] = $history->get('step');
				$hisotryArr['uid'][] = $history->get('uid');
				$hisotryArr['result'][] = $history->get('result');
				$hisotryArr['comment'][] = $history->get('comment');
				$hisotryArr['posttime'][] = $history->get('posttime');
			}
		}
	}

	/**
	 * _getDirname
	 *
	 * @param void
	 *
	 * @return	string
	 */ 
	protected function _getDirname()
	{
		return LEGACY_WORKFLOW_DIRNAME;
	}


	/**
	 * _getItemCriteria
	 *
	 * @param string $dirname
	 * @param string $dataname
	 * @param int	 $id
	 *
	 * @return	
	 */ 
	protected function _getItemCriteria(/*** string ***/ $dirname, /*** string ***/ $dataname, /*** int ***/ $data_id)
	{
		$cri = new CriteriaCompo();
		$cri->add(new Criteria('dirname', $dirname));
		$cri->add(new Criteria('dataname', $dataname));
		$cri->add(new Criteria('target_id', $data_id));
		$cri->add(new Criteria('deletetime', 0));
	
		return $cri;
	}

}


class Leprogress_CoolUriDelegate
{
	/**
	 * getNormalUri
	 *
	 * @param string	$uri
	 * @param string	$dirname
	 * @param string	$dataname
	 * @param int		$data_id
	 * @param string	$action
	 * @param string	$query
	 *
	 * @return	void
	 */ 
	public static function getNormalUri(/*** string ***/ &$uri, /*** string ***/ $dirname, /*** string ***/ $dataname=null, /*** int ***/ $data_id=0, /*** string ***/ $action=null, /*** string ***/ $query=null)
	{
		$sUri = '/%s/index.php?action=%s%s';
		$lUri = '/%s/index.php?action=%s%s&%s=%d';
		switch($dataname){
			case 'history':	$key = 'progress_id';break;
			default:		$key = $dataname.'_id';break;
		}
	
		$table = isset($dataname) ? $dataname : 'player';
	
		if(isset($dataname)){
			if($data_id>0){
				if(isset($action)){
					$uri = sprintf($lUri, $dirname, ucfirst($dataname), ucfirst($action), $key, $data_id);
				}
				else{
					$uri = sprintf($lUri, $dirname, ucfirst($dataname), 'View', $key, $data_id);
				}
			}
			else{
				if(isset($action)){
					$uri = sprintf($sUri, $dirname, ucfirst($dataname), ucfirst($action));
				}
				else{
					$uri = sprintf($sUri, $dirname, ucfirst($dataname), 'List');
				}
			}
			$uri = isset($query) ? $uri.'&'.$query : $uri;
		}
		else{
			if($data_id>0){
				if(isset($action)){
					die();
				}
				else{
					$handler = Legacy_Utils::getModuleHandler($table, $dirname);
					$key = $handler->mPrimary;
					$uri = sprintf($lUri, $dirname, ucfirst($table), 'View', $key, $data_id);
				}
				$uri = isset($query) ? $uri.'&'.$query : $uri;
			}
			else{
				if(isset($action)){
					die();
				}
				else{
					$uri = sprintf('/%s/', $dirname);
					$uri = isset($query) ? $uri.'index.php?'.$query : $uri;
				}
			}
		}
	}
}


?>

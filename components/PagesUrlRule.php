<?php

class PagesUrlRule extends CBaseUrlRule {

	public function createUrl($manager, $route, $params, $ampersand)
	{
		$pathsMap = Yii::app()->getModule('pages')->getPathsMap();

		if ($route === 'pages/default/view' && isset($params['id'], $pathsMap[$params['id']]))
			if(isset($params['Page_page']))
                            return $pathsMap[$params['id']] ."/p".$params['Page_page']. $manager->urlSuffix;
                        else
                          return $pathsMap[$params['id']] . $manager->urlSuffix;
		else
			return false;
	}

	public function parseUrl($manager, $request, $pathInfo, $rawPathInfo)
	{  // dd($request);
            preg_match('/^(.*)?\/p(\d+)\/?$/', $pathInfo, $res);
            //var_dump($pathInfo);
            //dd($res[1]);
            
           // exit();
		$pathsMap = Yii::app()->getModule('pages')->getPathsMap();
                //if we have pag param
                if(isset($res[1])) $pathInfo = $res[1];
		$id = array_search($pathInfo, $pathsMap);

		if ($id === false)	return false;

		$_GET['id'] = $id;
                $_GET['Page_page'] = $res[2];
		return 'pages/default/view';
	}

}
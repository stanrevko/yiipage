<?php

class PagesModule extends CWebModule {

    /**
     * @var string идентификатор, по которому доступна закешированная карта путей
     */
    public $cacheId = 'pagesPathsMap';
    public $templatesDirAlias = 'pages.views.default.templates';
    public $templatesDir = '';
    public function init() {
        $this->templatesDir = Yii::getPathOfAlias($this->templatesDirAlias);
        if (Yii::app()->cache->get($this->cacheId) === false)
            $this->updatePathsMap();

        $this->setImport(array(
            'pages.models.*',
            'pages.components.*',
        ));
    }

    /**
     * Возвращает карту путей из кеша.
     * @return mixed
     */
    public function getPathsMap() {
        $pathsMap = Yii::app()->cache->get($this->cacheId);

        return $pathsMap === false ? $this->updatePathsMap() : $pathsMap;
    }
    
    public function getPathById($id){
        
          $pathMap = $this->getPathsMap();
          return $pathMap[$id];
    }

    /**
     * Сохраняет в кеш актуальную на момент вызова карту путей.
     * @return void
     */
    public function updatePathsMap() {
        $map = $this->generatePathsMap();
        $dependency = new CDbCacheDependency('SELECT MAX(updated) FROM {{pages}}');
        Yii::app()->cache->set($this->cacheId, $map);
        return $map;
    }
    
    public function clearPathMap(){
         Yii::app()->cache->set($this->cacheId, false);
    }

    /**
     * Генерация карты страниц.
     * Используется при разборе и создании URL.
     * @return array ID узла => путь до узла
     */
    public function generatePathsMap() {
        $nodes = Yii::app()->db->createCommand()
                ->select('id, level, slug')
                ->from('pages')
                ->order('root, lft')
                ->queryAll();

        $pathsMap = array();
        $depths = array();

        foreach ($nodes as $node) {
            if ($node['level'] > 1)
                $path = $depths[$node['level'] - 1];
            else
                $path = '';

            $path .= $node['slug'];
            $depths[$node['level']] = $path . '/';
            $pathsMap[$node['id']] = $path;
        }

        return $pathsMap;
    }

    
    public function getTemplates(){
        $templates = array();
        if ($handle = opendir($this->templatesDir)) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != "..") {
                    $file = str_replace('.php', '', $file);
                    $templates[$file] = $file;
                }
            }        
            closedir($handle);
        }
        return $templates;
    }
}

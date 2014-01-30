
<?php

class DefaultController extends Controller {

    public function actionIndex() {
        $this->render('index');
    }

    public function actionView($id) {
        $page = $this->loadModel($id);
        ///CEO
        $this->pageTitle = $page->page_title;
        $this->metaTitle = $page->meta_title;
        $this->metaDescription = $page->meta_description;
        $this->metaKeywords = $page->meta_keywords;
        $this->breadcrumbs = $page->breadcrumbs;

        $templateFile = $this->module->templatesDir . "/$page->template.php";
        if (!file_exists($templateFile)) {
            $page->template = "default";
        }
        //echo $template;
        //echo "<br/>", exit( $this->module->templatesDirAlias.".".$template);
        $this->render($this->module->templatesDirAlias . "." . $page->template, array(
            'page' => $page,
        ));
    }

    public function loadModel($id) {
        $model = Page::model()->published()->findByPk($id);

        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая страница не существует.');


        return $model;
    }

}
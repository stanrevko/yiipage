<?php

class AdminController extends Controller {

    public $layout = '//layouts/main';

    public function actionCreate() {
        $model = new Page;

        $this->performAjaxValidation($model);

        if (isset($_POST['Page'])) {
            $model->attributes = $_POST['Page'];

            if ($model->parent_id) {
                $parent = Page::model()->findByPk($model->parent_id);
                if ($parent !== null)
                    $model->appendTo($parent);
            }

            if ($model->saveNode()) {
                Yii::app()->user->setFlash('success', "Страница «{$model->page_title}» успешно создана.");
                if(isset($_POST['yt1']))                 $this->redirect(array('create'));
                if(isset($_POST['yt2']))                 $this->redirect(array('admin'));
                $this->redirect(array('update', 'id' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
                        'templates'=>Yii::app()->getModule($this->module->id)->getTemplates()

        ));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        $this->performAjaxValidation($model);
        
//получение списка шаблонов
        if (isset($_POST['Page'])) {
            $model->attributes = $_POST['Page'];

            if ((int) $model->parent_id !== (int) $model->_parent_id) {
                if (empty($model->parent_id))
                    $result = $model->moveAsRoot();
                else {
                    $parent = Page::model()->findByPk($model->parent_id);
                    if ($parent !== null)
                        $result = $model->moveAsFirst($parent);
                }
            }

            if ($model->saveNode()) {
                Yii::app()->user->setFlash('success', "Страница «{$model->page_title}» успешно изменена.");
                if(isset($_POST['yt1']))                 $this->redirect(array('create'));
                if(isset($_POST['yt2']))                 $this->redirect(array('admin'));
                $this->redirect(array('index'));
            }
        }



        $this->render('update', array(
            'model' => $model,
            'templates'=>Yii::app()->getModule($this->module->id)->getTemplates()
        ));
    }

    public function actionDelete($id) {

        $this->loadModel($id)->deleteNode();

        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    public function actionIndex() {
        $model = new Page('search');
        $model->unsetAttributes();
        if (isset($_GET['Page']))
            $model->attributes = $_GET['Page'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionToggle($id, $attribute) {
        if (Yii::app()->request->isPostRequest) {
            $model = $this->loadModel($id);
            $model->$attribute = ($model->$attribute == 0) ? 1 : 0;
            $model->saveNode(false);

            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function loadModel($id) {
        $model = Page::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'page-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}

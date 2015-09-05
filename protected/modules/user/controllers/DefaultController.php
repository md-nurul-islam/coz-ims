<?php

class DefaultController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('changePassword'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionChangePassword() {

        $model = new User;
        $model = $model->findByPk(Yii::app()->user->id);
        $model->setScenario('changePassword');

        $this->performAjaxValidation($model);

        if (isset($_POST['User'])) {

            $model->attributes = $_POST['User'];
            if ($model->validate()) {
                $model->salt = $model->getPasswordSalt();
                $model->hashed_password = $model->getPassword($model->salt, $model->new_password);

                if ($model->save()) {
                    Yii::app()->user->setFlash('success', 'New Password successfully set.');
//                    $this->redirect(array('print', 'sales_id' => $model->sales_id));
                    $this->redirect('changePassword');
                }
            }
        }

        $this->render('_change_pwd', array(
            'model' => $model
        ));
    }

    /**
     * Performs the AJAX validation.
     * @param ProductDetails $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'change-password-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}

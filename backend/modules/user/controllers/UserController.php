<?php

namespace backend\modules\user\controllers;

use Yii;
use backend\modules\user\models\User;
use backend\modules\user\models\ActivityHistory;
use backend\modules\user\models\ActivityHistorySearch;
use backend\modules\user\models\UserSearch;
use backend\modules\user\models\SignupForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\user\models\AuthItem;
use \backend\controllers\GlobalFunctionController;
// use common\models\User;

/**
 * UserController implements the CRUD actions for User model.
 */
// error_reporting(-1);
class UserController extends GlobalFunctionController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionConnection(){
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->searchUserConnection(Yii::$app->request->queryParams);
        
        $model = new ActivityHistory();
        
        return $this->render('connection', [
            // 'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            // 'model' => $model
        ]);
    }


    public function actionKick($id)
    {
        $this->findModel($id)->updateCounters(['flag_login' => -1]);

        return $this->redirect(['connection']);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SignupForm();
        $modelAuthItem = new AuthItem;
        if ($model->load(Yii::$app->request->post())) {            
            if ($user = $model->signup()) {                                      
                echo 1;
                GlobalFunctionController::activity_user("[CREATE USER] Username : {$model->username} ,Email : {$model->email}, Allowed IP {model->ip}, Multiple Login {$model->flag_login}");            
            }
        }

        return $this->renderAjax('signup', [
            'model' => $model,
            'roles' => $modelAuthItem->getRoles(),
        ]);
        
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldModel = $this->findModel($id);
        
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->updateRecord($id)) {                                      
                GlobalFunctionController::activity_user("[UPDATE USER] Username : {$oldModel->username} to {$model->username},Email : {$oldModel->email} to {$model->email}, Allowed IP {$oldModel->ip} to {$model->ip}, Multiple Login {$oldModel->flag_login} to {$model->flag_login}");
                Yii::$app->Controllers->historyUserWithData($model,'update');
                echo 1; 
            }
            else{
                echo " hasil balikan null";
            }
                
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }
    /*public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldModel = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())&& $model->save()) {
            // echo "masuk ".$model->password;die();
            GlobalFunctionController::activity_user("[UPDATE USER] Username : {$oldModel->username} to {$model->username},Email : {$oldModel->email} to {$model->email}, Allowed IP {$oldModel->ip} to {$model->ip}, Multiple Login {$oldModel->flag_login} to {$model->flag_login}");
            Yii::$app->Controllers->historyUserWithData($model,'update');
            echo 1; 
                
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }*/

    /**
    * Show activity user
    */
    public function actionLog(){
        
        $searchModel = new ActivityHistorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new ActivityHistory();
        return $this->render('log', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if($this->findModel($id)->delete()){
            // echo 1;
            $this->redirect(['index']);
            GlobalFunctionController::activity_user("[CREATE USER] Username : {$model->username} ,Email : {$model->email}, Allowed IP {$model->ip}, Multiple Login {$model->flag_login}");            
        }
        
    }

    

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

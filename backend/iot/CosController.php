<?php

namespace backend\controllers;

use Yii;
use backend\models\Cos;
use backend\models\Virtual;
use backend\models\CosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\JSON;

/**
 * CosController implements the CRUD actions for Cos model.
 */
class CosController extends GlobalFunctionController
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
     * Lists all Cos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Cos model.
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
     * Creates a new Cos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Cos();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            GlobalFunctionController::activity_user("[CREATE COS] Name : {$model->name} ,Description : {$model->desc}, FORWARD_ON_RNA_enabled : {$model->FORWARD_ON_RNA_enabled}, FORWARD_ON_RNA_number : {$model->FORWARD_ON_RNA_number},FORWARD_ON_BUSY_enabled : {$model->FORWARD_ON_BUSY_enabled}, FORWARD_ON_BUSY_number : {$model->FORWARD_ON_BUSY_number}, FORWARD_UNC_enabled : {$model->FORWARD_UNC_enabled}, FORWARD_UNC_number : {$model->FORWARD_UNC_number}, clip : {$model->clip}, clir : {$model->clir}, mwi : {$model->mwi}, call_hunting : {$model->call_hunting}, call_hunting_type : {$model->call_hunting_type}");
            Yii::$app->Controllers->historyUserWithData($model);            
            echo 1;
            
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Cos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model    = $this->findModel($id);
        $oldModel =  $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            GlobalFunctionController::activity_user("[UPDATE COS] Name : {$oldModel->name} to {$model->name} ,Description : {$oldModel->desc} to {$model->desc}, FORWARD_ON_RNA_enabled : {$oldModel->FORWARD_ON_RNA_enabled} to {$model->FORWARD_ON_RNA_enabled}, FORWARD_ON_RNA_number : {$oldModel->FORWARD_ON_RNA_number} to {$model->FORWARD_ON_RNA_number},FORWARD_ON_BUSY_enabled : {$oldModel->FORWARD_ON_BUSY_enabled} to {$model->FORWARD_ON_BUSY_enabled}, FORWARD_ON_BUSY_number : {$oldModel->FORWARD_ON_BUSY_number} to {$model->FORWARD_ON_BUSY_number}, FORWARD_UNC_enabled : {$oldModel->FORWARD_UNC_enabled} to {$model->FORWARD_UNC_enabled}, FORWARD_UNC_number : {$oldModel->FORWARD_UNC_number} to {$model->FORWARD_UNC_number}, clip : {$oldModel->clip} to {$model->clip}, clir : {$oldModel->clir} to {$model->clir}, mwi : {$oldModel->mwi} to {$model->mwi}, call_hunting : {$oldModel->call_hunting} to {$model->call_hunting}, call_hunting_type : {$oldModel->call_hunting_type} to {$model->call_hunting_type}");
            Yii::$app->Controllers->historyUserWithData($model,'update');
            
            echo 1;
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionLists($id){
        $virtual = Virtual::find()
                    ->where(['id'=>$id])
                    ->all();
        foreach ($virtual as $key ) {
            echo "<option value='{$key->id}'>{$key->name}</option>";
        }
    }

    /**
     * Deletes an existing Cos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        GlobalFunctionController::activity_user("[DELETE COS] Name : {$model->name} to {$model->name} ,Description : {$model->desc} to {$model->desc}, FORWARD_ON_RNA_enabled : {$model->FORWARD_ON_RNA_enabled} to {$model->FORWARD_ON_RNA_enabled}, FORWARD_ON_RNA_number : {$model->FORWARD_ON_RNA_number} to {$model->FORWARD_ON_RNA_number},FORWARD_ON_BUSY_enabled : {$model->FORWARD_ON_BUSY_enabled} to {$model->FORWARD_ON_BUSY_enabled}, FORWARD_ON_BUSY_number : {$model->FORWARD_ON_BUSY_number} to {$model->FORWARD_ON_BUSY_number}, FORWARD_UNC_enabled : {$model->FORWARD_UNC_enabled} to {$model->FORWARD_UNC_enabled}, FORWARD_UNC_number : {$model->FORWARD_UNC_number} to {$model->FORWARD_UNC_number}, clip : {$model->clip} to {$model->clip}, clir : {$model->clir} to {$model->clir}, mwi : {$model->mwi} to {$model->mwi}, call_hunting : {$model->call_hunting} to {$model->call_hunting}, call_hunting_type : {$model->call_hunting_type} to {$model->call_hunting_type}");
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Cos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cos::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use common\models\LoginForm;
use backend\models\Antrian;
use backend\models\AntrianSearch;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Session;
use common\models\User;

/**
 * Site controller
 */
class SiteController extends Controller
{
    protected   $serv_time = 4;
    public      $time_of_arrival = 0;
    public      $start_service;
    public      $end_service = 0;
    protected   $int_arrv_time;
    protected   $time_in_queue = 0;
    /**
     * @inheritdoc
     */
    // public $layout = 'login2';
    public function behaviors() 
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['change-password', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = Antrian::find()->asArray()->all();
        #echo "<pre>";
        #print_r($searchModel);
        foreach ($searchModel as $key => $value) {
            $tmp[] = $value['int_arrival_time'];
        }
        #print_r($tmp);
        return $this->render('index',['data' => $tmp]);
    }

    /**
     * [actionChangePassword Ubah password jika change password date null]
     * @return url
     */
    public function actionChangePassword(){
        // $this->layout='login';
        $model = new LoginForm(['scenario' => 'changePassword']);

        $session = new Session;                
        $username = $session->get('user_id');
        if ($model->load(Yii::$app->request->post()) && $model->updatePassword()) {  
            $user = User::find()->where(['username'=>$model->username])->one();
            $user->setPassword($model->new_password);
            $user->change_pass_date = date('Y-m-d H:i:s');
            $user->generateAuthKey();
            if ($user->save()) {
                return $this->goHome();
            }
            
        } else {
            Yii::$app->user->logout();
            return $this->render('change-password', [
                'model' => $model,'username'=>$username
            ]);
        }
    }
    public function actionLogin()
    {
        // error_reporting(0);
        $model = new LoginForm();
        $model->scenario='login';
        
        if ($model->load(Yii::$app->request->post()) && $model->login()) {  
            // check change password date
            if (Yii::$app->user->ChangePassDate=="") {       
                $session = new Session;
                $session->set('user_id', $model->username);

                return $this->redirect(array('site/change-password'));
            }
            self::updateLastAction();                    
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function updateFlagLogin($status){
        $user = User::findOne(Yii::$app->user->id);
        $user->flag_login = $status;
        $user->update();
    }

    public function updateLastAction(){
        $user = User::findOne(Yii::$app->user->id);
        $user->last_action = date('Y-m-d H:i:s');
        $user->update();
    }

    public function actionLogout()
    {
        self::updateFlagLogin(0);
        GlobalFunctionController::activity_user('LOG OUT');
        Yii::$app->user->logout();

        return $this->goHome();
    }
}

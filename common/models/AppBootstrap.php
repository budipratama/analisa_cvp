<?php
namespace backend\bootstraps;
use yii\base\BootstrapInterface;

class AppBootstrap implements BootstrapInterface{

   public function bootstrap($app){
      $app->user->on(\yii\web\User::EVENT_BEFORE_LOGIN,['app\models\user\User', 'beforeLogin']);
      $app->user->on(\yii\web\User::EVENT_AFTER_LOGIN,['app\models\user\User', 'afterLogin']);
      $app->user->on(\yii\web\User::EVENT_BEFORE_LOGOUT,['app\models\user\User', 'beforeLogout']);
   }
}
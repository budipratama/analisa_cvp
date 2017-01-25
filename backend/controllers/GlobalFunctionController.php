<?php

namespace backend\controllers;

use common\models\User;
use Yii;
// use yii\web\Controller;
class GlobalFunctionController extends \yii\web\Controller{	

	/**
	 * [setLastAction untuk men set nilai aksi terakhir user]
	 * 
	 */
	
	public function setLastActionUser(){
		// nilai authtimeout user
		Yii::$app->user->authTimeout;

		$user = User::findOne(Yii::$app->user->id);
		$user->last_action = date('Y-m-d H:i:s');
		$user->update();
	}



	public function beforeAction($action){
		$session = Yii::$app->getSession();
		$user = new User;
		
		// set last action user
		self::setLastActionUser();

		// untuk keperluan kick user
		if (!Yii::$app->user->getFlagLogin()) {
			$session->destroy();
			$this->activity_user('KICK OUT');
			return $this->goBack();
		}
				
		// cek expire user jika habis maka tulis di log
		if ($session['__expire']=="") {
			$this->activity_user('SESSOIN TIME OUT');
		}

		//self::whatAreYouDoing($this->action->id);

		return true;
	}

	public function activityUserWithData(){

	}

	/**
	 * [whatAreYouDoing cek user lagi ngapain dengan data]
	 * @param  $model_1 [description]
	 * @param  $model_2 [description]
	 *
	 * di pakai di action delete,update,create
	 */
	
	public function whatAreYouDoing($model_1,$model_2 = null){
		$action = $this->action->id;
		$berita = "";
		$table = str_replace("tbl_", "", $model_1->tableName());
		$counter = 1;
		if ($action=='create') {
			
			$berita = "CREATE $table";
			$model_1->first_ip = $_SERVER['REMOTE_ADDR'];
			$model_1->first_user = Yii::$app->user->getUsername();
			$model_1->first_update = date('Y-m-d H:i:s');
			$model_1->last_ip = $_SERVER['REMOTE_ADDR'];
			$model_1->last_user = Yii::$app->user->getUsername();
			$model_1->last_update = date('Y-m-d H:i:s');
			$model_1->update();

			foreach ($model_1 as $key => $value) {
					if ($key!='id')
						$berita .= " $value";
										
			}

			self::activity_user($berita);
		}
		// untuk di action update harus 2 parameter
		if ($action=='update') {
			$berita = "UPDATE $table";
			
			foreach ($model_1 as $key => $value) {
				if ($value != $model_2[$key]) {
					$berita .= " {$model_2[$key]} to $value";
				}
			}

			$model_1->last_ip = $_SERVER['REMOTE_ADDR'];
			$model_1->last_user = Yii::$app->user->getUsername();
			$model_1->last_update = date('Y-m-d H:i:s');
			$model_1->update();

			self::activity_user($berita);
		}
		// untuk action hanya satu param
		if ($action=='delete') {
			$berita = "DELETE $table";

			foreach ($model_1 as $key => $value) {
				
					$berita .= " {$model_2[$key]} to $value";
				if ($counter=3) 
					break;
				$counter++;
			}
		}		
	}

	public function activity_user($berita)
    {
        $connection = Yii::$app->db;
        $id_user    = Yii::$app->user->getId();
        $name_user  = Yii::$app->user->getUsername();
        
        $connection->createCommand()->insert('tbl_activity_history', [
				                                        'iduser'    => $id_user,
				                                        'username'  => $name_user,
				                                        'berita'    => $berita,
				                                        'date'      => date('Y-m-d H:i:s'),
				                                        'ip'        => $_SERVER['REMOTE_ADDR'],
				                                    ])->execute();
    }	
}
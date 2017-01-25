<?php
namespace common\components;
 
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
 
class Controllers extends Component { 	
  
  public function createMenuOperation($params){

        $menuO = "";
        $list = "";   
        $defaultPage = Yii::$app->params['defaultPage'][$params['page']]; 
        if (isset($params['aksi'])) {
          // echo "masuk";die();
          foreach($params['aksi'] as $key => $value){
              $defaultPage[$key] = $key; 
          } 
        }
                
        foreach($defaultPage as $k => $v){
            $label = "";
            $url = "";
            $options = "";
            if($this->checkAuthorizedUser($v)){
                if(isset($params['aksi'][$v])){
                    $aksi = $params['aksi'][$v];
                    $flagShow = true;
                    if(isset($aksi['fungsi'])){
                        if(!$aksi['fungsi']){
                            $flagShow = false;
                        }
                    }
                    
                    if($flagShow){
                        $options = ['class'=>'btn'];
                        
                        if(isset($aksi['label'])){
                            $label = $aksi['label'];
                        }
                        else{
                            $defaultIcon = Yii::$app->params['defaultIcon'][$v];
                            $label = "<i class='".$defaultIcon['icon']."'></i> ".$defaultIcon['label'];
                        }
                        
                        if(isset($aksi['params'])){
                            if(isset($aksi['params'][0])){
                                $url = '#';
                            }
                            else{
                                $url = [$v];
                            
                                foreach($aksi['params'] as $k2 => $v2){
                                    $url[$k2] = $v2; 
                                }
                            }
                        }
                        else{
                            $url = [$v];
                        }
                       
                        if($v == 'delete'){
                            $confirm = "Are you sure you want to delete ";      
                            $text = "this item";  
                            $event = [];
                            if(isset($aksi['msg'])){
                                if(isset($aksi['msg']['confirm'])){
                                    $confirm = $aksi['msg']['confirm'];
                                }
                                else{
                                    $confirm = "Are you sure you want to delete ";                                 
                                }

                                if(isset($aksi['msg']['text'])){
                                    $text = $aksi['msg']['text'];
                                }
                                else{
                                    $text = "this item";
                                }
                            }
                        
                            $options = [
                                    'data' => [
                                        'confirm' => $confirm.$text.' ?',
                                        'method' => 'post',
                                    ],
                                ];
                        }
                                              
                        if(isset($aksi['options'])){
                            foreach($aksi['options'] as $k3 => $v3){
                               $options[$k3] = $v3;
                            }
                        }
                        
                        $list .= '<li>'.Html::a($label,$url,$options).'</li>';    
                    }
                }
                else{
                    $defaultIcon = Yii::$app->params['defaultIcon'][$v];
                    $label = "<i class='".$defaultIcon['icon']."'></i> ".$defaultIcon['label'];
                    // $list .= '<li onclick="create(\''.Yii::$app->controller->id.'\')">'.$label.'</li>'; 
                    $list .= '<li>'.Html::a($label,$defaultIcon['url'],['class'=>'btn']).'</li>';
                }
            }
        }
        
        if(strlen($list) > 15){
            $menuO = '<div class="operatorRight btn-group" role="group">
                        <button data-toggle="dropdown" class="btn btn-primary-budi dropdown-toggle" type="button" aria-haspopup="true" aria-expanded="false"><i class="glyphicon glyphicon-cog"></i> Operation List&nbsp;&nbsp;<span class="caret"></span></button>
                        <ul class="dropdown-menu right-menu">'; 

            $list .="</ul></div>";
        }
        
        return $menuO.$list;
    }

	public function anakTiri($status){
		if ($status) {
			return false;
		}
		else
			return true;
	}

  public function operationDateTime($ymdhis,$seconds){

    $date = strtotime("+$seconds second",strtotime($ymdhis));
    return date('Y-m-d H:i:s',$date);
  }

  public function checkAuthorizedUser($action,$function = true){
      if (!$function) {
       return false;
      }
      
      // current contoller
      $controller = Yii::$app->controller->id;
      $role = Yii::$app->user->usermode;
      
      // jika role nya developer atau admin harus true
      if ($role  == 'developer' || $role == 'admin') 
        return true;
      
      $rows = (new \yii\db\Query())
          ->select(["REPLACE(child, '/$controller/', '') as child"])
          ->from('auth_item_child')
          ->where('parent=:parent',[':parent' => $role])
          ->andWhere(['like','child',$controller])        
          ->all();

      $bunda = [];
      foreach ($rows as $key => $value) 
        $bunda[$value['child']] = $value['child'];    

      if (!empty($bunda[$action])) 
        return true;
    
  }

  /**
   * [checkMultipleLogin Cek user multiple login]
   * @return boolean
   */
  public function checkMultipleLogin(){
    // compare last_action sm timeout user    
  }

  public function historyUserWithData($model,$action='create'){
      if ($action == 'create') {
        $model->first_ip = $_SERVER['REMOTE_ADDR'];
        $model->first_user = Yii::$app->user->getUsername();
        $model->first_update = date('Y-m-d H:i:s');
      }
      
      $model->last_ip = $_SERVER['REMOTE_ADDR'];
      $model->last_user = Yii::$app->user->getUsername();
      $model->last_update = date('Y-m-d H:i:s');
      
      $model->update();
  }

  public function isAdmin($type=1){
        if(Yii::$app->user->usermode == 'admin'){
            if($type == '1'){
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return true;
        }
  }
  
}
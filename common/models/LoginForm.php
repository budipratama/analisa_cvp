<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\web\Controller;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $new_password;
    public $old_password;
    public $repeat_password;
    public $error;
    private $data_user;
    // public $rememberMe = true;

    private $_user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username','password'], 'required','on'=>'login'],
            [['username','repeat_password','old_password','new_password'], 'required','on'=>'changePassword'],
            ['repeat_password', 'compare','compareAttribute'=>'new_password','on'=>'changePassword'],
            // ['repeat_password', 'compare','compareAttribute'=>'new_password','message'=>'Repeat Password Not same with Password'],
            // rememberMe must be a boolean value
            // ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
            //['flag_multiple', 'checkMultipleLogin'],
            ['old_password', 'validateOldPassword','on'=>'changePassword'],
            // ['']
        ];
    }


    public function scenarios(){
        $scenarios = parent::scenarios();
        $scenarios['login'] = ['username','password'];
        
        return $scenarios;
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            $this->data_user = $user;
            
            if (isset($user)) {
                if ($user->status==20) {
                    $this->addError('error',"Your account has blocked. Please contact your administrator");
                }
                // check multiple login
                if (self::checkMultipleLogin()) 
                    $this->addError('error', 'You Can not double login.');
                
                // check akses ip user
                if (self::checkAllowedIpUser()) 
                    $this->addError('error', "You don't have access with ip {$this->data_user->accepted_ip}" );

                if (!$user->rtries_count_use) {
                    $this->addError('error', "You don't have access with ip {$this->data_user->accepted_ip}" );
                }
                
            }
            
            if (!$user || !$user->validatePassword($this->password)) {      
                // jika username tsb salah password maka rtries_count akan di potong
                // jika retries_count habis maka account akan di  block
                if (isset($user)) {
                    // belum selesai pikirkan lagi
                    $user->updateCounters(['rtries_count_use' => -1]);
                    $this->addError('error', "You can try use wrong password" );
                }
                        
                $this->addError($attribute, 'Incorrect username or password.');
            }
            
            /*if ($this->resetPassword())
                return Yii::$app->getResponse()->redirect('site/about');*/
        }
    }
    /**
     * [checkAllowedIpUser cek ip yang di bolehkan login]
     * @return boolean
     */
    public function checkAllowedIpUser()
    {
        $allowedIpUser = $this->data_user->accepted_ip;
        $currentIpUser = Yii::$app->user->ipUser;
        $allowedIpUserEx = explode(".",$allowedIpUser);
        $currentIpUserEx = explode(".",$currentIpUser);
        $i = 0;
        $ip = [];
        
        foreach ($allowedIpUserEx as $key => $value) {
            if ($value=="*") 
                $ip[] = true;
            else{
                if ($value == $currentIpUserEx[$i]) 
                    $ip[] = true;
                else
                    $ip[] = false;
            }
            $i++;
        }
        
        foreach ($ip as $key => $value) {
            if ($value == false) 
                return true;            
        }

        return false;
    }

    /**
     * [checkMultipleLogin Check user yang boleh login lebih dari satu]
     * @return boolean
     */
    public function checkMultipleLogin(){
        $last_action = $this->data_user->last_action;
        $flag_login = $this->data_user->flag_login;
        $flag_multiple = $this->data_user->flag_multiple;
        $authTimeout = Yii::$app->user->authTimeout;
        
        $authTimeoutUser = Yii::$app->Controllers->operationDateTime($last_action,$authTimeout);
        
        if ($flag_multiple): 
            return false;
        else:
            if (!$flag_login) 
                return false;
            else{
                if (date('Y-m-d H:i:s') > $authTimeoutUser) 
                    return false;                
                else
                    return true;
            }           
        endif;
              
    }

    public function validateOldPassword($attribute, $params)
    {
        
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            
            if (!$user || !$user->validatePassword($this->old_password)) 
                $this->addError($attribute, 'Incorrect password.');  
            
            /*if ($this->resetPassword())
                return Yii::$app->getResponse()->redirect('site/about');*/
        }
    }
       

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    { 
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(),0);
        } else {
            return false;
        }
    }

    public function updatePassword(){
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(),0);
        } else {
            return false;
        }
    }    

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}

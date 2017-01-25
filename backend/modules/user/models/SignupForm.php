<?php
namespace backend\modules\user\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $rtries_count;
    public $rtries_count_use;
    public $passage1;
    public $passage2;
    public $usermode;
    public $flag_multiple;
    public $last_action;
    public $ip;
    public $password_repeat;
    public $active_date;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            [['username','usermode','passage1','ip','passage2','flag_multiple','rtries_count','active_date'], 'required'],
            // ['usermode', 'required'],
            // ['passage1', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
          
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
            ['password', 'string', 'min' => 6],
        ];
    }

    public function attributeLabels()
    {
        return [            
            'passage1' => 'Password Expired 1',
            'passage2' => 'Password Expired 2',
            'ip' => 'IP',
            'usermode' => 'Role',
            'rtries_count' => 'Retries Count',
            'flag_multiple' => 'Multiple Login',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {            
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->usermode = $this->usermode;
            $user->flag_multiple = $this->flag_multiple;
            $user->rtries_count = $this->rtries_count;
            $user->passage1 = $this->passage1;
            $user->passage2 = $this->passage2;            
            $user->ip = $this->ip;           
            $user->accepted_ip = $this->ip;           
            $user->active_date = $this->active_date;           
                       
            if ($user->save()) {
                return $user;
            }
        }
        return null;
    }
}

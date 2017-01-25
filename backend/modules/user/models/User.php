<?php

namespace backend\modules\user\models;
// use common\models\User;
use Yii;
// use common\models\User;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $first_user
 * @property string $first_ip
 * @property string $first_update
 * @property string $last_user
 * @property string $last_ip
 * @property string $last_update
 * @property string $active_date
 * @property integer $rtries_count
 * @property integer $rtries_count_use
 * @property string $change_pass_date
 * @property integer $passage1
 * @property integer $passage2
 * @property integer $usermode
 * @property integer $flag_multiple
 * @property string $last_action
 * @property string $ip
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash','usermode','passage1','passage2','flag_multiple', 'email', 'created_at', 'updated_at', 'active_date'], 'required'],
            [['id','status', 'created_at', 'updated_at', 'rtries_count', 'rtries_count_use', 'passage1', 'passage2', 'flag_multiple'], 'integer'],
            [['first_update', 'last_update', 'active_date', 'change_pass_date', 'last_action'], 'safe'],
            [['username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique']
        ];
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function updateRecord($id){
        $user = User::findOne($id);
        /*echo $this->password_hash;
        $user->setPassword($this->password_hash);
        $user->generateAuthKey();*/
        
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password_hash);
        $user->generateAuthKey();
        $user->usermode = $this->usermode;
        $user->flag_multiple = $this->flag_multiple;
        $user->rtries_count = $this->rtries_count;
        $user->passage1 = $this->passage1;
        $user->passage2 = $this->passage2;            
        $user->ip = $this->ip;           
        $user->accepted_ip = $this->ip;           
        $user->active_date = $this->active_date; 
        
        if ($this->validate()) {
            
            if ($user->update()) {
                return $user;
            }
        }

        return null;
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
            
            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }

    

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'first_user' => 'First User',
            'first_ip' => 'First Ip',
            'first_update' => 'First Update',
            'last_user' => 'Last User',
            'last_ip' => 'Last Ip',
            'last_update' => 'Last Update',
            'active_date' => 'Active Date',
            'rtries_count' => 'Rtries Count',
            'rtries_count_use' => 'Rtries Count Use',
            'change_pass_date' => 'Change Pass Date',
            'passage1' => 'Passage1',
            'passage2' => 'Passage2',
            'usermode' => 'Usermode',
            'flag_multiple' => 'Multiple Login',
            'last_action' => 'Last Action',
            'ip' => 'Ip',
        ];
    }
}

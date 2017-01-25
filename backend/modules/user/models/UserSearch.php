<?php

namespace backend\modules\user\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\user\models\User;

/**
 * UserSearch represents the model behind the search form about `backend\modules\user\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at', 'rtries_count', 'rtries_count_use', 'passage1', 'passage2', 'usermode', 'flag_multiple'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'first_user', 'first_ip', 'first_update', 'last_user', 'last_ip', 'last_update', 'active_date', 'change_pass_date', 'last_action', 'ip'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    { 
        if(Yii::$app->user->usermode == 'admin'){
            $query = User::find()->where(['not in','usermode','Developer']);;
        }
        else{
            $query = User::find();
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

       
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'first_update' => $this->first_update,
            'last_update' => $this->last_update,
            'active_date' => $this->active_date,
            'rtries_count' => $this->rtries_count,
            'rtries_count_use' => $this->rtries_count_use,
            'change_pass_date' => $this->change_pass_date,
            'passage1' => $this->passage1,
            'passage2' => $this->passage2,
            'usermode' => $this->usermode,
            'flag_multiple' => $this->flag_multiple,
            'last_action' => $this->last_action,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'first_user', $this->first_user])
            ->andFilterWhere(['like', 'first_ip', $this->first_ip])
            ->andFilterWhere(['like', 'last_user', $this->last_user])
            ->andFilterWhere(['like', 'last_ip', $this->last_ip])
            ->andFilterWhere(['like', 'ip', $this->ip]);

        return $dataProvider;
    }

    public function searchUserConnection($params)
    {
        if (Yii::$app->user->usermode != 'developer') 
          $query = User::find()->where(['not like','usermode','developer'])->andWhere('flag_login=1');
        else
          $query = User::find()->where('flag_login=1');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'first_update' => $this->first_update,
            'last_update' => $this->last_update,
            'active_date' => $this->active_date,
            'rtries_count' => $this->rtries_count,
            'rtries_count_use' => $this->rtries_count_use,
            'change_pass_date' => $this->change_pass_date,
            'passage1' => $this->passage1,
            'passage2' => $this->passage2,
            'usermode' => $this->usermode,
            'flag_multiple' => $this->flag_multiple,
            'last_action' => $this->last_action,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'first_user', $this->first_user])
            ->andFilterWhere(['like', 'first_ip', $this->first_ip])
            ->andFilterWhere(['like', 'last_user', $this->last_user])
            ->andFilterWhere(['like', 'last_ip', $this->last_ip])
            ->andFilterWhere(['like', 'ip', $this->ip]);
        /*$query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'first_update' => $this->first_update,
            'last_update' => $this->last_update,
            'active_date' => $this->active_date,
            'rtries_count' => $this->rtries_count,
            'rtries_count_use' => $this->rtries_count_use,
            'change_pass_date' => $this->change_pass_date,
            'passage1' => $this->passage1,
            'passage2' => $this->passage2,
            'usermode' => $this->usermode,
            'flag_multiple' => $this->flag_multiple,
            'last_action' => $this->last_action,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
              ->andFilterWhere(['like', 'auth_key', $this->auth_key])
              ->andFilterWhere(['like', 'password_hash', $this->password_hash])
              ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
              ->andFilterWhere(['like', 'email', $this->email])
              ->andFilterWhere(['like', 'first_user', $this->first_user])
              ->andFilterWhere(['like', 'first_ip', $this->first_ip])
              ->andFilterWhere(['like', 'last_user', $this->last_user])
              ->andFilterWhere(['like', 'last_ip', $this->last_ip])
              ->andFilterWhere(['like', 'ip', $this->ip]);*/

        return $dataProvider;
    }

     /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchConnection($params)
    {
        $query = User::find()->where(['flag_login' => 1]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
          // echo "masuk";die();
        //     // uncomment the following line if you do not want to return any records when validation fails
        //     // $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;
    }

    
}

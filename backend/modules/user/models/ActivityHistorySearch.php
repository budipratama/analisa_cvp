<?php

namespace backend\modules\user\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use backend\modules\user\models\ActivityHistory;
use common\models\User;

/**
 * ActivityHistorySearch represents the model behind the search form about `backend\modules\user\models\ActivityHistory`.
 */
class ActivityHistorySearch extends ActivityHistory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'iduser'], 'integer'],
            [['username', 'berita', 'date','start_date','end_date', 'ip'], 'safe'],
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
        
    
        $date='';
        if (Yii::$app->user->usermode!='developer'){ 
            $usernames = User::find('username')->where(['not in','usermode',['developer']])->asArray()->all();
            $query        = ActivityHistory::find()->where(['in','username',ArrayHelper::map($usernames,'username','username')]);
        }
        else
            $query        = ActivityHistory::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        if (isset($params['ActivityHistorySearch'])) {
            $date = $params['ActivityHistorySearch']['start_date'];
            $params['ActivityHistorySearch']['start_date'] = substr($date, 0,10).' 00:00';
            $params['ActivityHistorySearch']['end_date']   = substr($date, 13,10).' 23:59';
        }
        $this->load($params);
        $query->andFilterWhere(['like', 'username', $this->username])->andFilterWhere(['between', 'date', $this->start_date==""?date('Y-m-d'):$this->start_date,$this->end_date==""?date('Y-m-d'):$this->end_date]);
        $this->start_date = $date;
        
        return $dataProvider;
    }
}

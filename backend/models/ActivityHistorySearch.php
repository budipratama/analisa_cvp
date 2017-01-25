<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ActivityHistory;

/**
 * ActivityHistorySearch represents the model behind the search form about `backend\models\ActivityHistory`.
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
            [['username', 'berita', 'date', 'ip'], 'safe'],
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
        $query = ActivityHistory::find();

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
            'iduser' => $this->iduser,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'berita', $this->berita])
            ->andFilterWhere(['like', 'ip', $this->ip]);

        return $dataProvider;
    }
}

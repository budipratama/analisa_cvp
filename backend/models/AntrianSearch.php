<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Antrian;

/**
 * AntrianSearch represents the model behind the search form about `backend\models\Antrian`.
 */
class AntrianSearch extends Antrian
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'int_arrival_time'], 'integer'],
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
        $query = Antrian::find();

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
            'int_arrival_time' => $this->int_arrival_time,
        ]);

        return $dataProvider;
    }
}
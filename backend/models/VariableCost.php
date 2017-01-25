<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_variable_cost".
 *
 * @property integer $id_variable_cost
 * @property string $date
 * @property string $name
 * @property string $description
 * @property integer $price
 */
class VariableCost extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_variable_cost';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['price'], 'integer'],
            [['name', 'description'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_variable_cost' => 'Id Variable Cost',
            'date' => 'Date',
            'name' => 'Name',
            'description' => 'Description',
            'price' => 'Price',
        ];
    }
}

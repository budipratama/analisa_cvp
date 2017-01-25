<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_fixed_cost".
 *
 * @property integer $id_fixed_cost
 * @property string $date
 * @property string $name
 * @property string $description
 * @property string $price
 */
class FixedCost extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_fixed_cost';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['name', 'description', 'price'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_fixed_cost' => 'Id Fixed Cost',
            'date' => 'Date',
            'name' => 'Name',
            'description' => 'Description',
            'price' => 'Price',
        ];
    }
}

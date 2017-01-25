<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "antrian".
 *
 * @property integer $id
 * @property integer $int_arrival_time
 */
class Antrian extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'antrian';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['int_arrival_time'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'int_arrival_time' => 'Int Arrival Time',
        ];
    }
}

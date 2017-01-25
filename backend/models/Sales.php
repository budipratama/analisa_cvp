<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_sales".
 *
 * @property integer $id_sales
 * @property string $date
 * @property integer $unit
 */
class Sales extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_sales';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['unit'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_sales' => 'Id Sales',
            'date' => 'Date',
            'unit' => 'Unit',
        ];
    }
}

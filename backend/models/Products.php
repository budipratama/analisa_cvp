<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_products".
 *
 * @property integer $id_products
 * @property string $name
 * @property string $price
 */
class Products extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_products';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'price'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_products' => 'Id Products',
            'name' => 'Name',
            'price' => 'Price',
        ];
    }
}

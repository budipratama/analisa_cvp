<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_activity_history".
 *
 * @property integer $id
 * @property integer $iduser
 * @property string $username
 * @property resource $berita
 * @property string $date
 * @property string $ip
 */
class ActivityHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_activity_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['iduser', 'username', 'berita', 'date', 'ip'], 'required'],
            [['iduser'], 'integer'],
            [['berita'], 'string'],
            [['date'], 'safe'],
            [['username'], 'string', 'max' => 20],
            [['ip'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'iduser' => 'Iduser',
            'username' => 'Username',
            'berita' => 'Berita',
            'date' => 'Date',
            'ip' => 'Ip',
        ];
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bcs_code".
 *
 * @property int $id
 * @property string $name
 * @property string $search_key
 * @property string $search_code
 * @property string $status
 * @property string $req_num
 */
class Bcscode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bcs_code';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['search_key','name', 'search_code', 'status','req_num'], 'required'],
            [['status'], 'string'],
            [['search_key','name', 'search_code'], 'string', 'max' => 255],
            [['search_key','search_code'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'search_key' => Yii::t('app', 'Search Key'),
            'search_code' => Yii::t('app', 'Search Code'),
            'status' => Yii::t('app', 'Status'),
            'req_num' => Yii::t('app', 'Requset Number'),
        ];
    }

    /**
     * @inheritdoc
     * @return BcscodeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BcscodeQuery(get_called_class());
    }
}

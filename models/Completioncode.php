<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "completion_code".
 *
 * @property int $id
 * @property string $code
 * @property string $status
 */
class Completioncode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'completion_code';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code'], 'required'],
            [['status'], 'string'],
            [['code'], 'string', 'max' => 255],
            [['code'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'code' => Yii::t('app', 'Code'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @inheritdoc
     * @return CompletioncodeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompletioncodeQuery(get_called_class());
    }
}

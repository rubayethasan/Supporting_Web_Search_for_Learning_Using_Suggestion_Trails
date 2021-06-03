<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "completion".
 *
 * @property int $id
 * @property int $user_id
 * @property int $topic_id
 * @property string $topic_name
 * @property string $completion_code
 * @property string $create_date
 */
class Completion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'completion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'topic_id', 'topic_name', 'create_date', 'completion_code'], 'required'],
            [['user_id', 'topic_id'], 'integer'],
            [['create_date'], 'safe'],
            [['topic_name','completion_code'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'topic_id' => Yii::t('app', 'Topic ID'),
            'topic_name' => Yii::t('app', 'Topic Name'),
            'completion_code' => Yii::t('app', 'Completion Code'),
            'create_date' => Yii::t('app', 'Create Date'),
        ];
    }

    /**
     * @inheritdoc
     * @return CompletionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompletionQuery(get_called_class());
    }
}

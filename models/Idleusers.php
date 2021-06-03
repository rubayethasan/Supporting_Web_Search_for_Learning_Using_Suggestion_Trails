<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "idle_users".
 *
 * @property int $id
 * @property int $worker_id
 * @property int $topic_id
 * @property string $topic_subject
 * @property string $create_date
 */
class Idleusers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'idle_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['worker_id', 'topic_id', 'topic_subject', 'create_date'], 'required'],
            [['worker_id', 'topic_id'], 'integer'],
            [['create_date'], 'safe'],
            [['topic_subject'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'worker_id' => Yii::t('app', 'Worker ID'),
            'topic_id' => Yii::t('app', 'Topic ID'),
            'topic_subject' => Yii::t('app', 'Topic Subject'),
            'create_date' => Yii::t('app', 'Create Date'),
        ];
    }

    /**
     * @inheritdoc
     * @return IdleusersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new IdleusersQuery(get_called_class());
    }
}

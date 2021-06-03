<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "topics".
 *
 * @property int $id
 * @property string $topic_subject
 * @property string $topic_description
 *
 * @property Questions[] $questions
 */
class Topics extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'topics';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['topic_subject', 'topic_description'], 'required'],
            [['topic_subject', 'topic_description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'topic_subject' => Yii::t('app', 'Topic Subject'),
            'topic_description' => Yii::t('app', 'Topic Description'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestions()
    {
        return $this->hasMany(Questions::className(), ['topic_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return TopicsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TopicsQuery(get_called_class());
    }
}

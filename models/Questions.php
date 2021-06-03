<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "questions".
 *
 * @property int $id
 * @property int $topic_id
 * @property int $topic_subject
 * @property string $question
 * @property string $answer
 *
 * @property Topics $topic
 */
class Questions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'questions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['topic_id', 'question', 'answer'], 'required'],
            [['topic_id'], 'integer'],
            [['question'], 'string'],
            [['answer'], 'string', 'max' => 255],
            [['topic_id'], 'exist', 'skipOnError' => true, 'targetClass' => Topics::className(), 'targetAttribute' => ['topic_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'topic_id' => Yii::t('app', 'Topic ID'),
            'topic_subject' => Yii::t('app', 'Topic Subject'),
            'question' => Yii::t('app', 'Question'),
            'answer' => Yii::t('app', 'Answer'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopic()
    {
        return $this->hasOne(Topics::className(), ['id' => 'topic_id']);
    }

    /**
     * @inheritdoc
     * @return QuestionsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new QuestionsQuery(get_called_class());
    }
}

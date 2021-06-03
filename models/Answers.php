<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "answers".
 *
 * @property int $id
 * @property int $worker_id
 * @property int $topic_id
 * @property string $topic_subject
 * @property string $question_answer
 * @property int $right_answer
 * @property int $wrong_answer
 * @property double $result
 * @property string $state
 * @property string $create_date
 */
class Answers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'answers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['worker_id', 'topic_id', 'topic_subject', 'question_answer', 'right_answer', 'wrong_answer', 'result', 'state', 'create_date'], 'required'],
            [['worker_id','topic_id', 'right_answer', 'wrong_answer'], 'integer'],
            [['question_answer', 'state'], 'string'],
            [['result'], 'number'],
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
            'question_answer' => Yii::t('app', 'Question Answer'),
            'right_answer' => Yii::t('app', 'Right Answer'),
            'wrong_answer' => Yii::t('app', 'Wrong Answer'),
            'result' => Yii::t('app', 'Result'),
            'state' => Yii::t('app', 'State'),
            'create_date' => Yii::t('app', 'Create Date'),
        ];
    }

    /**
     * @inheritdoc
     * @return AnswersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AnswersQuery(get_called_class());
    }
}

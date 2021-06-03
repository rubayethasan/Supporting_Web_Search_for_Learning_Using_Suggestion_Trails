<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "observation".
 *
 * @property int $id
 * @property int $user_id
 * @property int $topic_id
 * @property string $topic_name
 * @property int $observation_1
 * @property int $observation_2
 * @property int $observation_3
 * @property string $create_date
 */
class Observation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'observation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'topic_id', 'topic_name', 'observation_1', 'observation_2', 'observation_3','create_date'], 'required'],
            [['user_id', 'topic_id', 'observation_1', 'observation_2', 'observation_3'], 'integer'],
            [['topic_name'], 'string', 'max' => 255],
            [['create_date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'topic_id' => 'Topic ID',
            'topic_name' => 'Topic Name',
            'observation_1' => 'Observation 1',
            'observation_2' => 'Observation 2',
            'observation_3' => 'Observation 3',
            'create_date' => 'Create Date',
        ];
    }

    /**
     * @inheritdoc
     * @return ObservationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ObservationQuery(get_called_class());
    }
}

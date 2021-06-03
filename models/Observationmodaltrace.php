<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "observation_modal_trace".
 *
 * @property int $id
 * @property int $user_id
 * @property int $topic_id
 * @property string $topic_name
 * @property int $iteration
 * @property double $active_time
 * @property string $create_date
 */
class Observationmodaltrace extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'observation_modal_trace';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'topic_id', 'topic_name', 'iteration', 'active_time', 'create_date'], 'required'],
            [['user_id', 'topic_id', 'iteration'], 'integer'],
            [['active_time'], 'number'],
            [['create_date'], 'safe'],
            [['topic_name'], 'string', 'max' => 255],
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
            'iteration' => 'Iteration',
            'active_time' => 'Active Time',
            'create_date' => 'Create Date',
        ];
    }

    /**
     * @inheritdoc
     * @return ObservationmodaltraceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ObservationmodaltraceQuery(get_called_class());
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "modal_trace".
 *
 * @property int $id
 * @property int $user_id
 * @property int $topic_id
 * @property string $topic_name
 * @property int $iteration
 * @property double $active_time
 * @property string $copied_string
 * @property string $pasted_string
 * @property string $create_date
 */
class Modaltrace extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'modal_trace';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'topic_id', 'topic_name', 'iteration', 'active_time', 'copied_string', 'pasted_string', 'create_date'], 'required'],
            [['user_id', 'topic_id', 'iteration'], 'integer'],
            [['active_time'], 'number'],
            [['copied_string', 'pasted_string'], 'string'],
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
            'copied_string' => 'Copied String',
            'pasted_string' => 'Pasted String',
            'create_date' => 'Create Date',
        ];
    }

    /**
     * @inheritdoc
     * @return ModaltraceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ModaltraceQuery(get_called_class());
    }
}

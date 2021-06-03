<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%suggestion}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $topic_id
 * @property string $topic_name
 * @property string $suggestion
 * @property int $thumbs_up
 * @property int $thumbs_down
 * @property string $thumbs_up_user_list
 * @property string $thumbs_down_user_list
 * @property double $rating
 * @property string $create_date
 */
class Suggestion extends \yii\db\ActiveRecord
{
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%suggestion}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'topic_id','topic_name', 'suggestion','create_date'], 'required'],
            [['suggestion','thumbs_up_user_list','thumbs_down_user_list'], 'string'],
            [['topic_id','thumbs_up', 'thumbs_down','user_id'], 'integer'],
            [['rating'], 'number'],
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
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'topic_name' => Yii::t('app', 'Topic Name'),
            'topic_id' => Yii::t('app', 'Topic Id'),
            'suggestion' => Yii::t('app', 'Suggestion'),
            'thumbs_up' => Yii::t('app', 'Thumbs Up'),
            'thumbs_down' => Yii::t('app', 'Thumbs Down'),
            'thumbs_up_user_list' => Yii::t('app', 'Thumbs Up User List'),
            'thumbs_down_user_list' => Yii::t('app', 'Thumbs Down User List'),
            'rating' => Yii::t('app', 'Rating'),
        ];
    }

    /**
     * @inheritdoc
     * @return SuggestionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SuggestionQuery(get_called_class());
    }
}

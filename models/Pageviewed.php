<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "page_viewed".
 *
 * @property int $id
 * @property string $page_url
 * @property string $referrer
 * @property int $topic_id
 * @property int $worker_id
 * @property int $topic_name
 * @property string $time_viewed
 * @property string $time_clicked
 * @property double $stay_time
 * @property double $active_time
 * @property string $create_date
 */
class Pageviewed extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page_viewed';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['page_url', 'worker_id','create_date','time_viewed','topic_id','topic_name'], 'required'],
            [['page_url', 'referrer','topic_name'], 'string'],
            [['worker_id','topic_id'], 'integer'],
            [['stay_time','active_time'], 'number'],
            [['time_viewed','time_clicked','create_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'page_url' => Yii::t('app', 'Page Url'),
            'referrer' => Yii::t('app', 'Referrer'),
            'worker_id' => Yii::t('app', 'Worker ID'),
            'topic_id' => Yii::t('app', 'Topic ID'),
            'topic_name' => Yii::t('app', 'Topic Name'),
            'time_viewed' => Yii::t('app', 'Time Viewed'),
            'time_clicked' => Yii::t('app', 'Time Clicked'),
            'stay_time' => Yii::t('app', 'Stay Time'),
            'active_time' => Yii::t('app', 'Active Time'),
        ];
    }

    /**
     * @inheritdoc
     * @return PageviewedQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PageviewedQuery(get_called_class());
    }
}

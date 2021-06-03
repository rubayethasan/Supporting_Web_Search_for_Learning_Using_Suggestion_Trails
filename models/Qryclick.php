<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "qry_click".
 *
 * @property int $id
 * @property int $worker_id
 * @property int $topic_id
 * @property int $topic_name
 * @property int $query_id
 * @property string $query_term
 * @property string $query_time
 * @property string $click_time
 * @property double $serp_rank
 * @property string $page_url
 * @property string $page_title
 * @property string $page_description
 * @property string $create_date
 */
class Qryclick extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'qry_click';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['worker_id', 'query_id', 'query_term', 'query_time','topic_id','topic_name','create_date'], 'required'],
            [['worker_id','topic_id'], 'integer'],
            [['query_time', 'click_time','create_date'], 'safe'],
            [['serp_rank'], 'number'],
            [['query_term','page_url', 'page_title', 'page_description','topic_name'], 'string'],
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
            'topic_name' => Yii::t('app', 'Topic Name'),
            'query_id' => Yii::t('app', 'Query ID'),
            'query_term' => Yii::t('app', 'Query Term'),
            'query_time' => Yii::t('app', 'Query Time'),
            'click_time' => Yii::t('app', 'Click Time'),
            'serp_rank' => Yii::t('app', 'Serp Rank'),
            'page_url' => Yii::t('app', 'Page Url'),
            'page_title' => Yii::t('app', 'Page Title'),
            'page_description' => Yii::t('app', 'Page Description'),
        ];
    }

    /**
     * @inheritdoc
     * @return QryclickQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new QryclickQuery(get_called_class());
    }
}

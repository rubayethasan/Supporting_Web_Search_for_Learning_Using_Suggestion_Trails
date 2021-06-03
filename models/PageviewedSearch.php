<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pageviewed;

/**
 * PageviewedSearch represents the model behind the search form of `app\models\Pageviewed`.
 */
class PageviewedSearch extends Pageviewed
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'worker_id','topic_id'], 'integer'],
            [['page_url', 'referrer', 'time_viewed', 'time_clicked','create_date','topic_name'], 'safe'],
            [['stay_time','active_time'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Pageviewed::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'worker_id' => $this->worker_id,
            'topic_id' => $this->topic_id,
            'time_viewed' => $this->time_clicked,
            'time_clicked' => $this->time_clicked,
            'stay_time' => $this->stay_time,
            'active_time' => $this->active_time,
        ]);

        $query->andFilterWhere(['like', 'page_url', $this->page_url])
            ->andFilterWhere(['like', 'topic_name', $this->topic_name])
            ->andFilterWhere(['like', 'referrer', $this->referrer])
            ->andFilterWhere(['like', 'create_date', $this->create_date]);

        return $dataProvider;
    }
}

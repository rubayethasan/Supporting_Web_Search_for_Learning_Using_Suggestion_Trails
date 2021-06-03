<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Qryclick;

/**
 * QryclickSearch represents the model behind the search form of `app\models\Qryclick`.
 */
class QryclickSearch extends Qryclick
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'worker_id', 'topic_id'], 'integer'],
            [['query_id','query_term', 'query_time', 'click_time', 'page_url', 'page_title', 'page_description','topic_name'], 'safe'],
            [['serp_rank'], 'number'],
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
        $query = Qryclick::find();

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
            'query_id' => $this->query_id,
            'query_time' => $this->query_time,
            'click_time' => $this->click_time,
            'serp_rank' => $this->serp_rank,
        ]);

        $query->andFilterWhere(['like', 'topic_name', $this->topic_name])
            ->andFilterWhere(['like', 'query_term', $this->query_term])
            ->andFilterWhere(['like', 'page_url', $this->page_url])
            ->andFilterWhere(['like', 'page_title', $this->page_title])
            ->andFilterWhere(['like', 'page_description', $this->page_description]);

        return $dataProvider;
    }
}

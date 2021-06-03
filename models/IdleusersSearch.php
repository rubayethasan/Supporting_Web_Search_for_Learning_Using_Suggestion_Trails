<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Idleusers;

/**
 * IdleusersSearch represents the model behind the search form of `app\models\Idleusers`.
 */
class IdleusersSearch extends Idleusers
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'worker_id', 'topic_id'], 'integer'],
            [['topic_subject', 'create_date'], 'safe'],
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
        $query = Idleusers::find();

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
            'topic_id' => $this->topic_id
        ]);

        $query->andFilterWhere(['like', 'topic_subject', $this->topic_subject])
            ->andFilterWhere(['like', 'create_date', $this->create_date]);

        return $dataProvider;
    }
}

<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Observationmodaltrace;

/**
 * ObservationmodaltraceSearch represents the model behind the search form of `app\models\Observationmodaltrace`.
 */
class ObservationmodaltraceSearch extends Observationmodaltrace
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'topic_id', 'iteration'], 'integer'],
            [['topic_name', 'create_date'], 'safe'],
            [['active_time'], 'number'],
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
        $query = Observationmodaltrace::find();

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
            'user_id' => $this->user_id,
            'topic_id' => $this->topic_id,
            'iteration' => $this->iteration,
            'active_time' => $this->active_time,
            'create_date' => $this->create_date,
        ]);

        $query->andFilterWhere(['like', 'topic_name', $this->topic_name]);

        return $dataProvider;
    }
}

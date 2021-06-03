<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Answers;

/**
 * AnswersSearch represents the model behind the search form of `app\models\Answers`.
 */
class AnswersSearch extends Answers
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','worker_id', 'topic_id', 'right_answer', 'wrong_answer'], 'integer'],
            [['topic_subject', 'question_answer', 'state', 'create_date'], 'safe'],
            [['result'], 'number'],
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
        $query = Answers::find();

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
            'topic_id' => $this->topic_id,
            'right_answer' => $this->right_answer,
            'wrong_answer' => $this->wrong_answer,
            'result' => $this->result,
            'create_date' => $this->create_date,
        ]);

        $query->andFilterWhere(['like', 'worker_id', $this->worker_id])
            ->andFilterWhere(['like', 'topic_subject', $this->topic_subject])
            ->andFilterWhere(['like', 'question_answer', $this->question_answer])
            ->andFilterWhere(['like', 'state', $this->state]);

        return $dataProvider;
    }
}

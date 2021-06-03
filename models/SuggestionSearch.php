<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Suggestion;

/**
 * SuggestionSearch represents the model behind the search form of `app\models\Suggestion`.
 */
class SuggestionSearch extends Suggestion
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','topic_id', 'thumbs_up', 'thumbs_down'], 'integer'],
            [['user_id','topic_name', 'suggestion','thumbs_up_user_list','thumbs_down_user_list'], 'safe'],
            [['rating'], 'number'],
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
        $query = Suggestion::find();

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
            'thumbs_up' => $this->thumbs_up,
            'thumbs_down' => $this->thumbs_down,
            'rating' => $this->rating,
        ]);

        $query->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'topic_name', $this->topic_name])
            ->andFilterWhere(['like', 'topic_id', $this->topic_id])
            ->andFilterWhere(['like', 'suggestion', $this->suggestion])
            ->andFilterWhere(['like', 'thumbs_up_user_list', $this->thumbs_up_user_list])
            ->andFilterWhere(['like', 'thumbs_down_user_list', $this->thumbs_down_user_list]);

        return $dataProvider;
    }
}

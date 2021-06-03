<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Bcscode;

/**
 * BcscodeSearch represents the model behind the search form of `app\models\Bcscode`.
 */
class BcscodeSearch extends Bcscode
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','req_num'], 'integer'],
            [['search_key', 'search_code', 'status','name'], 'safe'],
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
        $query = Bcscode::find();

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
            'req_num' => $this->req_num,
        ]);

        $query->andFilterWhere(['like', 'search_key', $this->search_key])
            ->andFilterWhere(['like', 'search_code', $this->search_code])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}

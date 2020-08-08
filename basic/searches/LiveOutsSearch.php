<?php

namespace app\searches;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LiveOuts;

/**
 * LiveOutsSearch represents the model behind the search form of `app\models\LiveOuts`.
 */
class LiveOutsSearch extends LiveOuts
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'game_id', 'team_id', 'type', 'status', 'create_time'], 'integer'],
            [['content', 'image'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = LiveOuts::find();

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
            'game_id' => $this->game_id,
            'team_id' => $this->team_id,
            'type' => $this->type,
            'status' => $this->status,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'image', $this->image]);

        return $dataProvider;
    }
}

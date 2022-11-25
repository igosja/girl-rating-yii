<?php
declare(strict_types=1);

namespace backend\search;

use common\models\Vote;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class VoteSearch
 * @package backend\search
 */
class VoteSearch extends Vote
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['id', 'girl_id_one', 'girl_id_two', 'girl_id_winner'], 'integer'],
        ];
    }

    /**
     * @return array
     */
    public function scenarios(): array
    {
        return Model::scenarios();
    }

    /**
     * @return string
     */
    public function formName(): string
    {
        return '';
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query
            ->andFilterWhere(['id' => $this->id])
            ->andFilterWhere(['girl_id_one' => $this->girl_id_one])
            ->andFilterWhere(['girl_id_two' => $this->girl_id_two])
            ->andFilterWhere(['girl_id_winner' => $this->girl_id_winner]);
        return $dataProvider;
    }
}
<?php
declare(strict_types=1);

namespace backend\search;

use common\models\Girl;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class GirlSearch
 * @package backend\search
 */
class GirlSearch extends Girl
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['id'], 'integer'],
            [['name'], 'string', 'max' => 255],
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
            ->andFilterWhere(['like', 'name', $this->name]);
        return $dataProvider;
    }
}
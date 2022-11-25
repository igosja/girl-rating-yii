<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Vote
 * @package app\models
 *
 * @property int $id
 * @property int $created_at
 * @property int $girl_id_one
 * @property int $girl_id_two
 * @property int $girl_id_winner
 * @property int $updated_at
 *
 * @property Girl $girlOne
 * @property Girl $girlTwo
 * @property Girl $girlWinner
 */
class Vote extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%votes}}';
    }

    /**
     * @return string[]
     */
    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['girl_id_one', 'girl_id_two'], 'required'],
            [['created_at', 'girl_id_one', 'girl_id_two', 'girl_id_winner', 'updated_at'], 'integer'],
            [
                ['girl_id_one', 'girl_id_two', 'girl_id_winner'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Girl::class,
                'targetAttribute' => 'id',
            ],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getGirlOne(): ActiveQuery
    {
        return $this->hasOne(Girl::class, ['id' => 'girl_id_one']);
    }

    /**
     * @return ActiveQuery
     */
    public function getGirlTwo(): ActiveQuery
    {
        return $this->hasOne(Girl::class, ['id' => 'girl_id_two']);
    }

    /**
     * @return ActiveQuery
     */
    public function getGirlWinner(): ActiveQuery
    {
        return $this->hasOne(Girl::class, ['id' => 'girl_id_winner']);
    }
}

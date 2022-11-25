<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * Class Girl
 * @package app\models
 *
 * @property int $id
 * @property int $created_at
 * @property int $created_by
 * @property string $name
 * @property int $rating
 * @property int $votes
 * @property int $updated_at
 *
 * @property int $imageFile
 *
 * @property User $createdBy
 */
class Girl extends ActiveRecord
{
    /**
     * @var UploadedFile|string|null $imageFile
     */
    public string|null|UploadedFile $imageFile = null;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%girls}}';
    }

    /**
     * @return string[]
     */
    public function behaviors(): array
    {
        return [
            [
                'class' => BlameableBehavior::class,
                'updatedByAttribute' => false,
            ],
            TimestampBehavior::class,
        ];
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['created_at', 'created_by', 'rating', 'votes', 'updated_at'], 'integer'],
            [
                ['created_by'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::class,
                'targetAttribute' => 'id',
            ],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => ['jpg', 'jpeg']],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getCreatedBy(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * @return bool
     */
    public function beforeDelete()
    {
        if (file_exists($this->getFilePath())) {
            unlink($this->getFilePath());
        }
        return parent::beforeDelete();
    }

    /**
     * @return string
     */
    public function getFilePath(): string
    {
        return Yii::getAlias('@frontend') . '/web/upload/' . $this->id . '.jpg';
    }

    /**
     * @return string
     */
    public function getFileUrl(): string
    {
        if (!file_exists($this->getFilePath())) {
            return '';
        }

        return '/upload/' . $this->id . '.jpg?v=' . filemtime($this->getFilePath());
    }
}
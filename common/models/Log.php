<?php
declare(strict_types=1);

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Log
 * @package common\models\db
 *
 * @property int $id
 * @property int $level
 * @property string $category
 * @property float $log_time
 * @property string $prefix
 * @property string $message
 */
class Log extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%log}}';
    }
}

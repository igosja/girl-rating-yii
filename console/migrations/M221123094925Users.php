<?php
declare(strict_types=1);

namespace console\migrations;

use Yii;
use yii\base\Exception;
use yii\db\Migration;

/**
 * Class M221123094925Users
 * @package console\migrations
 */
class M221123094925Users extends Migration
{
    private const TABLE = '{{%users}}';

    /**
     * @return bool
     * @throws Exception
     */
    public function safeUp(): bool
    {
        $this->createTable(self::TABLE, [
            'id' => $this->primaryKey(),
            'auth_key' => $this->string()->notNull(),
            'created_at' => $this->integer()->defaultValue(0),
            'password' => $this->string()->notNull(),
            'updated_at' => $this->integer()->defaultValue(0),
            'username' => $this->string()->notNull(),
        ]);

        $this->insert(self::TABLE, [
            'auth_key' => Yii::$app->security->generateRandomString(),
            'created_at' => time(),
            'password' => Yii::$app->security->generatePasswordHash('gfhjkm'),
            'updated_at' => time(),
            'username' => 'igosja',
        ]);

        return true;
    }

    /**
     * @return bool
     */
    public function safeDown(): bool
    {
        $this->dropTable(self::TABLE);

        return true;
    }
}

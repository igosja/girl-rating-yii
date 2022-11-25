<?php
declare(strict_types=1);

namespace console\migrations;

use yii\db\Migration;

/**
 * Class M221123113624Girls
 * @package console\migrations
 */
class M221123113624Girls extends Migration
{
    private const TABLE = '{{%girls}}';
    private const USER_TABLE = '{{%users}}';

    /**
     * @return bool
     */
    public function safeUp(): bool
    {
        $this->createTable(self::TABLE, [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer()->defaultValue(0),
            'created_by' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'rating' => $this->integer()->defaultValue(1000),
            'votes' => $this->integer()->defaultValue(0),
            'updated_at' => $this->integer()->defaultValue(0),
        ]);

        $this->addForeignKey('girls_to_users', self::TABLE, 'created_by', self::USER_TABLE, 'id');

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

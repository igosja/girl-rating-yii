<?php

namespace console\migrations;

use yii\db\Migration;

/**
 * Class M221124093954Votes
 * @package console\migrations
 */
class M221124093954Votes extends Migration
{
    private const TABLE = '{{%votes}}';
    private const GIRLS_TABLE = '{{%girls}}';

    /**
     * @return bool
     */
    public function safeUp(): bool
    {
        $this->createTable(self::TABLE, [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer()->defaultValue(0),
            'girl_id_one' => $this->integer()->notNull(),
            'girl_id_two' => $this->integer()->notNull(),
            'girl_id_winner' => $this->integer(),
            'updated_at' => $this->integer()->defaultValue(0),
        ]);

        $this->addForeignKey('votes_to_girls_one', self::TABLE, 'girl_id_one', self::GIRLS_TABLE, 'id');
        $this->addForeignKey('votes_to_girls_two', self::TABLE, 'girl_id_two', self::GIRLS_TABLE, 'id');
        $this->addForeignKey('votes_to_girls_winner', self::TABLE, 'girl_id_winner', self::GIRLS_TABLE, 'id');

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

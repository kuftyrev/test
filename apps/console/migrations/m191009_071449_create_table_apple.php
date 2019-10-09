<?php

use yii\db\Migration;

/**
 * Class m191009_071449_create_table_apple
 */
class m191009_071449_create_table_apple extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('apples', [
            'id'          => $this->primaryKey(),
            'color'       => $this->string(50)->notNull(),
            'created_at'  => $this->timestamp()->notNull(),
            'fall_at'     => $this->timestamp()->defaultValue(null),
            'status'      => $this->boolean()->notNull()->defaultValue(0),
            'percent_eat' => $this->tinyInteger()->notNull()->defaultValue(100),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('apples');
    }
}

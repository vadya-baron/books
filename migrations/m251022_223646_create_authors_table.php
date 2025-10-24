<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%authors}}`.
 */
class m251022_223646_create_authors_table extends Migration
{
    public function safeUp(): void
    {
        $this->createTable('{{%authors}}', [
            'id' => $this->primaryKey(),
            'full_name' => $this->string(255)->notNull(),
            'key' => $this->string(255)->notNull(),
        ]);

        $this->createIndex(
            'idx_authors_key', '{{%authors}}', ['key'],
            true
        );
    }

    public function safeDown(): void
    {
        if ($_ENV['YII_ENV'] == 'dev') {
            $this->dropTable('{{%authors}}');
        }
    }
}

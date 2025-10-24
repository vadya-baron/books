<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subscriptions}}`.
 */
class m251022_224648_create_subscriptions_table extends Migration
{
    public function safeUp(): void
    {
        $this->createTable('{{%subscriptions}}', [
            'author_id' => $this->integer()->notNull(),
            'phone' => $this->string(15)->notNull(),
        ]);

        $this->createIndex(
            'idx_subscriptions_user_author', '{{%subscriptions}}', ['author_id', 'phone'],
            true
        );

        $this->addForeignKey(
            'fk_subscriptions_author',
            '{{%subscriptions}}',
            'author_id',
            '{{%authors}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown(): void
    {
        if ($_ENV['YII_ENV'] == 'dev') {
            $this->dropTable('{{%subscriptions}}');
        }
    }
}

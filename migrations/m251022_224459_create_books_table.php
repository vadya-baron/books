<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%books}}`.
 */
class m251022_224459_create_books_table extends Migration
{
    public function safeUp(): void
    {
        $this->createTable('{{%books}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(150)->notNull(),
            'pub_year' => $this->integer()->notNull(),
            'description' => $this->text()->notNull(),
            'isbn' => $this->string(17)->notNull()->unique(),
            'image_url' => $this->string(255)->null(),
        ]);

        $this->createIndex('idx_books_pub_year', '{{%books}}', 'pub_year');
        $this->createIndex('idx_books_title', '{{%books}}', 'title');
    }

    public function safeDown(): void
    {
        if ($_ENV['YII_ENV'] == 'dev') {
            $this->dropTable('{{%books}}');
        }
    }
}

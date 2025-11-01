<?php

use yii\db\Migration;

class m231201_000002_create_post_table extends Migration
{
  public function safeUp()
  {
    $this->createTable('{{%post}}', [
      'id' => $this->primaryKey(),
      'title' => $this->string(128)->notNull(),
      'content' => $this->text()->notNull(),
      'status' => $this->smallInteger()->notNull()->defaultValue(1),
      'author_id' => $this->integer()->notNull(),
      'created_at' => $this->integer()->notNull(),
      'updated_at' => $this->integer()->notNull(),
    ]);

    $this->createIndex('idx-post-author_id', '{{%post}}', 'author_id');
    $this->addForeignKey(
      'fk-post-author_id',
      '{{%post}}',
      'author_id',
      '{{%user}}',
      'id',
      'CASCADE'
    );
  }

  public function safeDown()
  {
    $this->dropForeignKey('fk-post-author_id', '{{%post}}');
    $this->dropTable('{{%post}}');
  }
}

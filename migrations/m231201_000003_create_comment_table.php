<?php

use yii\db\Migration;

class m231201_000003_create_comment_table extends Migration
{
  public function safeUp()
  {
    $this->createTable('{{%comment}}', [
      'id' => $this->primaryKey(),
      'content' => $this->text()->notNull(),
      'author_id' => $this->integer()->notNull(),
      'post_id' => $this->integer()->notNull(),
      'created_at' => $this->integer()->notNull(),
      'updated_at' => $this->integer()->notNull(),
    ]);

    $this->createIndex('idx-comment-author_id', '{{%comment}}', 'author_id');
    $this->createIndex('idx-comment-post_id', '{{%comment}}', 'post_id');

    $this->addForeignKey(
      'fk-comment-author_id',
      '{{%comment}}',
      'author_id',
      '{{%user}}',
      'id',
      'CASCADE'
    );

    $this->addForeignKey(
      'fk-comment-post_id',
      '{{%comment}}',
      'post_id',
      '{{%post}}',
      'id',
      'CASCADE'
    );
  }

  public function safeDown()
  {
    $this->dropForeignKey('fk-comment-author_id', '{{%comment}}');
    $this->dropForeignKey('fk-comment-post_id', '{{%comment}}');
    $this->dropTable('{{%comment}}');
  }
}

<?php

use yii\db\Migration;

class m231201_000004_create_tag_table extends Migration
{
  public function safeUp()
  {
    $this->createTable('{{%tag}}', [
      'id' => $this->primaryKey(),
      'name' => $this->string(64)->notNull()->unique(),
      'frequency' => $this->integer()->defaultValue(1),
    ]);

    // Таблица для связи многие-ко-многим между постами и тегами
    $this->createTable('{{%post_tag}}', [
      'post_id' => $this->integer()->notNull(),
      'tag_id' => $this->integer()->notNull(),
    ]);

    $this->addPrimaryKey('pk-post_tag', '{{%post_tag}}', ['post_id', 'tag_id']);

    $this->addForeignKey(
      'fk-post_tag-post_id',
      '{{%post_tag}}',
      'post_id',
      '{{%post}}',
      'id',
      'CASCADE'
    );

    $this->addForeignKey(
      'fk-post_tag-tag_id',
      '{{%post_tag}}',
      'tag_id',
      '{{%tag}}',
      'id',
      'CASCADE'
    );
  }

  public function safeDown()
  {
    $this->dropTable('{{%post_tag}}');
    $this->dropTable('{{%tag}}');
  }
}

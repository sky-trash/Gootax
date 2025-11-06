<?php

use yii\db\Migration;

class m231201_000003_create_review_table extends Migration
{
  public function safeUp()
  {
    $this->createTable('{{%review}}', [
      'id' => $this->primaryKey(),
      'id_city' => $this->integer(),
      'title' => $this->string(100)->notNull(),
      'text' => $this->string(255)->notNull(),
      'rating' => $this->smallInteger()->notNull(),
      'img' => $this->string(255),
      'id_author' => $this->integer()->notNull(),
      'date_create' => $this->integer()->notNull(),
    ]);

    $this->createIndex('idx-review-id_city', '{{%review}}', 'id_city');
    $this->createIndex('idx-review-id_author', '{{%review}}', 'id_author');
    $this->createIndex('idx-review-rating', '{{%review}}', 'rating');

    $this->addForeignKey(
      'fk-review-id_city',
      '{{%review}}',
      'id_city',
      '{{%city}}',
      'id',
      'SET NULL'
    );

    $this->addForeignKey(
      'fk-review-id_author',
      '{{%review}}',
      'id_author',
      '{{%user}}',
      'id',
      'CASCADE'
    );
  }

  public function safeDown()
  {
    $this->dropForeignKey('fk-review-id_city', '{{%review}}');
    $this->dropForeignKey('fk-review-id_author', '{{%review}}');
    $this->dropTable('{{%review}}');
  }
}

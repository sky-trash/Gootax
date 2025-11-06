<?php

use yii\db\Migration;

class m231201_000004_add_indexes extends Migration
{
  public function safeUp()
  {
    // Добавляем индексы для улучшения производительности
    $this->createIndex('idx-city-date_create', '{{%city}}', 'date_create');
    $this->createIndex('idx-user-date_create', '{{%user}}', 'date_create');
    $this->createIndex('idx-review-date_create', '{{%review}}', 'date_create');
    $this->createIndex('idx-review-status', '{{%review}}', 'rating');
  }

  public function safeDown()
  {
    $this->dropIndex('idx-city-date_create', '{{%city}}');
    $this->dropIndex('idx-user-date_create', '{{%user}}');
    $this->dropIndex('idx-review-date_create', '{{%review}}');
    $this->dropIndex('idx-review-status', '{{%review}}');
  }
}

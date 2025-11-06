<?php

use yii\db\Migration;

class m231201_000001_create_city_table extends Migration
{
  public function safeUp()
  {
    $this->createTable('{{%city}}', [
      'id' => $this->primaryKey(),
      'name' => $this->string(255)->notNull()->unique(),
      'date_create' => $this->integer()->notNull(),
    ]);

    $this->createIndex('idx-city-name', '{{%city}}', 'name');
  }

  public function safeDown()
  {
    $this->dropTable('{{%city}}');
  }
}

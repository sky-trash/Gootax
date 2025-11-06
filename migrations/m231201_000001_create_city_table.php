<?php

use yii\db\Migration;

class m231201_000001_create_city_table extends Migration
{
  public function safeUp()
  {
    $tableName = $this->db->schema->getRawTableName('{{%city}}');

    if ($this->db->schema->getTableSchema('{{%city}}') === null) {
      $this->createTable('{{%city}}', [
        'id' => $this->primaryKey(),
        'name' => $this->string(255)->notNull()->unique(),
        'date_create' => $this->integer()->notNull(),
      ]);

      $this->createIndex('idx-city-name', '{{%city}}', 'name');
      echo "Таблица city создана успешно.\n";
    } else {
      echo "Таблица city уже существует.\n";
    }
  }

  public function safeDown()
  {
    $this->dropTable('{{%city}}');
  }
}

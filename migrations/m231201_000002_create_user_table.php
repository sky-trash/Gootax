<?php

use yii\db\Migration;

class m231201_000002_create_user_table extends Migration
{
  public function safeUp()
  {
    // Проверяем, существует ли таблица
    if ($this->db->schema->getTableSchema('{{%user}}') === null) {
      $this->createTable('{{%user}}', [
        'id' => $this->primaryKey(),
        'fio' => $this->string(255)->notNull(),
        'email' => $this->string(255)->notNull()->unique(),
        'phone' => $this->string(20),
        'password_hash' => $this->string(255)->notNull(),
        'auth_key' => $this->string(32),
        'email_confirm_token' => $this->string(255),
        'status' => $this->smallInteger()->notNull()->defaultValue(0),
        'date_create' => $this->integer()->notNull(),
      ]);

      $this->createIndex('idx-user-email', '{{%user}}', 'email');
      $this->createIndex('idx-user-status', '{{%user}}', 'status');
      echo "Таблица user создана успешно.\n";
    } else {
      echo "Таблица user уже существует.\n";
    }
  }

  public function safeDown()
  {
    $this->dropTable('{{%user}}');
  }
}

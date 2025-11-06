<?php

use yii\db\Migration;

class m231201_000002_create_user_table extends Migration
{
  public function safeUp()
  {
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
  }

  public function safeDown()
  {
    $this->dropTable('{{%user}}');
  }
}

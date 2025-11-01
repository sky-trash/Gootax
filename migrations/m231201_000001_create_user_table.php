<?php

use yii\db\Migration;

class m231201_000001_create_user_table extends Migration
{
  public function safeUp()
  {
    $this->createTable('{{%user}}', [
      'id' => $this->primaryKey(),
      'username' => $this->string(128)->notNull()->unique(),
      'password' => $this->string(128)->notNull(),
      'email' => $this->string(128)->notNull()->unique(),
      'created_at' => $this->integer()->notNull(),
      'updated_at' => $this->integer()->notNull(),
    ]);

    $this->createIndex('idx-user-username', '{{%user}}', 'username');
    $this->createIndex('idx-user-email', '{{%user}}', 'email');
  }

  public function safeDown()
  {
    $this->dropTable('{{%user}}');
  }
}

<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $content
 * @property int $author_id
 * @property int $post_id
 * @property int $created_at
 * @property int $updated_at
 * 
 * @property User $author
 * @property Post $post
 */
class Comment extends ActiveRecord
{
  public static function tableName()
  {
    return '{{%comment}}';
  }

  public function rules()
  {
    return [
      [['content', 'author_id', 'post_id'], 'required'],
      [['content'], 'string'],
      [['author_id', 'post_id', 'created_at', 'updated_at'], 'integer'],
    ];
  }

  public function attributeLabels()
  {
    return [
      'id' => 'ID',
      'content' => 'Content',
      'author_id' => 'Author',
      'post_id' => 'Post',
      'created_at' => 'Created At',
      'updated_at' => 'Updated At',
    ];
  }

  public function getAuthor()
  {
    return $this->hasOne(User::class, ['id' => 'author_id']);
  }

  public function getPost()
  {
    return $this->hasOne(Post::class, ['id' => 'post_id']);
  }

  public function beforeSave($insert)
  {
    if (parent::beforeSave($insert)) {
      if ($this->isNewRecord) {
        $this->created_at = time();
      }
      $this->updated_at = time();
      return true;
    }
    return false;
  }
}

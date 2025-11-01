<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $title
 * @property string $content
 * @property int $status
 * @property int $author_id
 * @property int $created_at
 * @property int $updated_at
 * 
 * @property User $author
 * @property Comment[] $comments
 * @property Tag[] $tags
 */
class Post extends ActiveRecord
{
  const STATUS_DRAFT = 0;
  const STATUS_PUBLISHED = 1;

  public static function tableName()
  {
    return '{{%post}}';
  }

  public function rules()
  {
    return [
      [['title', 'content', 'author_id'], 'required'],
      [['content'], 'string'],
      [['status', 'author_id', 'created_at', 'updated_at'], 'integer'],
      [['title'], 'string', 'max' => 128],
      ['status', 'default', 'value' => self::STATUS_PUBLISHED],
      ['status', 'in', 'range' => [self::STATUS_DRAFT, self::STATUS_PUBLISHED]],
    ];
  }

  public function attributeLabels()
  {
    return [
      'id' => 'ID',
      'title' => 'Title',
      'content' => 'Content',
      'status' => 'Status',
      'author_id' => 'Author',
      'created_at' => 'Created At',
      'updated_at' => 'Updated At',
    ];
  }

  public function getAuthor()
  {
    return $this->hasOne(User::class, ['id' => 'author_id']);
  }

  public function getComments()
  {
    return $this->hasMany(Comment::class, ['post_id' => 'id']);
  }

  public function getTags()
  {
    return $this->hasMany(Tag::class, ['id' => 'tag_id'])
      ->viaTable('{{%post_tag}}', ['post_id' => 'id']);
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

  public function getStatusLabel()
  {
    $statuses = [
      self::STATUS_DRAFT => 'Draft',
      self::STATUS_PUBLISHED => 'Published',
    ];
    return $statuses[$this->status] ?? 'Unknown';
  }

  public static function find()
  {
    return new \app\models\query\PostQuery(get_called_class());
  }
}

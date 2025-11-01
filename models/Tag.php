<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $name
 * @property int $frequency
 * 
 * @property Post[] $posts
 */
class Tag extends ActiveRecord
{
  public static function tableName()
  {
    return '{{%tag}}';
  }

  public function rules()
  {
    return [
      [['name'], 'required'],
      [['name'], 'string', 'max' => 64],
      [['frequency'], 'integer'],
      [['name'], 'unique'],
    ];
  }

  public function attributeLabels()
  {
    return [
      'id' => 'ID',
      'name' => 'Name',
      'frequency' => 'Frequency',
    ];
  }

  public function getPosts()
  {
    return $this->hasMany(Post::class, ['id' => 'post_id'])
      ->viaTable('{{%post_tag}}', ['tag_id' => 'id']);
  }
}

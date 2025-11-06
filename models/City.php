<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class City extends ActiveRecord
{
  public static function tableName()
  {
    return '{{%city}}';
  }

  public function rules()
  {
    return [
      [['name', 'date_create'], 'required'],
      [['date_create'], 'integer'],
      [['name'], 'string', 'max' => 255],
      [['name'], 'unique'],
    ];
  }

  public function attributeLabels()
  {
    return [
      'id' => 'ID',
      'name' => 'Название города',
      'date_create' => 'Дата создания',
    ];
  }

  public function getReviews()
  {
    return $this->hasMany(Review::class, ['id_city' => 'id']);
  }

  public function beforeSave($insert)
  {
    if (parent::beforeSave($insert)) {
      if ($this->isNewRecord) {
        $this->date_create = time();
      }
      return true;
    }
    return false;
  }
}

<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

class Review extends ActiveRecord
{
  public $imageFile;

  public static function tableName()
  {
    return '{{%review}}';
  }

  public function rules()
  {
    return [
      [['title', 'text', 'rating', 'id_author', 'date_create'], 'required'],
      [['id_city', 'id_author', 'date_create', 'rating'], 'integer'],
      [['text'], 'string', 'max' => 255],
      [['title'], 'string', 'max' => 100],
      [['img'], 'string', 'max' => 255],
      ['rating', 'integer', 'min' => 1, 'max' => 5],
      [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
      [['id_city'], 'exist', 'skipOnError' => true, 'targetClass' => City::class, 'targetAttribute' => ['id_city' => 'id']],
      [['id_author'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_author' => 'id']],
    ];
  }

  public function attributeLabels()
  {
    return [
      'id' => 'ID',
      'id_city' => 'Город',
      'title' => 'Название отзыва',
      'text' => 'Текст отзыва',
      'rating' => 'Рейтинг',
      'img' => 'Изображение',
      'id_author' => 'Автор',
      'date_create' => 'Дата создания',
      'imageFile' => 'Загрузить фото',
    ];
  }

  public function getCity()
  {
    return $this->hasOne(City::class, ['id' => 'id_city']);
  }

  public function getAuthor()
  {
    return $this->hasOne(User::class, ['id' => 'id_author']);
  }

  public function upload()
  {
    if ($this->validate() && $this->imageFile) {
      $fileName = Yii::$app->security->generateRandomString(12) . '.' . $this->imageFile->extension;
      $filePath = 'uploads/reviews/' . $fileName;

      if (!is_dir(dirname($filePath))) {
        mkdir(dirname($filePath), 0755, true);
      }

      if ($this->imageFile->saveAs($filePath)) {
        $this->img = $fileName;
        return true;
      }
    }
    return false;
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

  public function getCityName()
  {
    return $this->city ? $this->city->name : 'Все города';
  }
}

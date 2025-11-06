<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_EMAIL_CONFIRMED = 2;

    public static function tableName()
    {
        return '{{%user}}';
    }

    public function rules()
    {
        return [
            [['fio', 'email', 'password_hash', 'date_create'], 'required'],
            [['date_create', 'status'], 'integer'],
            [['fio', 'email', 'password_hash', 'email_confirm_token'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 20],
            [['auth_key'], 'string', 'max' => 32],
            [['email'], 'email'],
            [['email'], 'unique'],
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_INACTIVE, self::STATUS_ACTIVE, self::STATUS_EMAIL_CONFIRMED]],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fio' => 'ФИО',
            'email' => 'Email',
            'phone' => 'Телефон',
            'password_hash' => 'Пароль',
            'status' => 'Статус',
            'date_create' => 'Дата создания',
        ];
    }

    public function getReviews()
    {
        return $this->hasMany(Review::class, ['id_author' => 'id']);
    }

    // IdentityInterface methods
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_EMAIL_CONFIRMED]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function generateEmailConfirmToken()
    {
        $this->email_confirm_token = Yii::$app->security->generateRandomString();
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->date_create = time();
                $this->generateAuthKey();
            }
            return true;
        }
        return false;
    }

    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }
}

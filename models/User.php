<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property int $created_at
 * @property int $updated_at
 * 
 * @property Post[] $posts
 * @property Comment[] $comments
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_ACTIVE = 1;

    public static function tableName()
    {
        return '{{%user}}';
    }

    public function rules()
    {
        return [
            [['username', 'password', 'email'], 'required'],
            [['username', 'email'], 'unique'],
            [['username', 'password', 'email'], 'string', 'max' => 128],
            ['email', 'email'],
            [['created_at', 'updated_at'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Имя пользователя',
            'password' => 'Пароль',
            'email' => 'Email',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлен',
        ];
    }

    public function getPosts()
    {
        return $this->hasMany(Post::class, ['author_id' => 'id']);
    }

    public function getComments()
    {
        return $this->hasMany(Comment::class, ['author_id' => 'id']);
    }

    // IdentityInterface methods
    public static function findIdentity($id)
    {
        return static::findOne($id);
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
        return null;
    }

    public function validateAuthKey($authKey)
    {
        return false;
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

    // Метод для поиска по имени пользователя
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    // Метод для проверки пароля
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }
}

<?php

namespace app\models;

use app\models\Users;

class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
{
    public $id;
    public $fio;
    public $username;
    public $password;
    public $date_start;
    public $date_end;
    public $approved;
    public $role;
    public $authKey;
    public $accessToken;

 
    public static $users = [];

    public static function initial(){
		$query = Users::find();
		$users = $query->orderBy('id')->all();
		foreach ($users as $user){
			self::$users[$user->id] = array(
				'id' => $user->id,
				'fio' => $user->fio,
				'username' => $user->username,
				'password' => $user->password,
				'date_start' => $user->date_start,
				'date_end' => $user->date_end,
				'approved' => $user->approved,
				'role' => $user->role,
				'authKey' => 'test'.$user->id.'key',
				'accessToken' => $user->id.'-token',				
			);
		}
	}

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === md5($password);
    }
	
    /**
     * Validates role
     *
     * @param string $role role to validate
     * @return bool if role provided is valid for current user
     */
    public function isRole($role)
    {
        return $this->role === $role;
    }	
	
	public static function getUsers(){
        return self::$users;
    }	
}

User::initial();
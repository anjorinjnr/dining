<?php

namespace Chefme\Models;

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Cartalyst\Sentry\Users\Eloquent\User as SentryUser;

class User extends SentryUser implements UserInterface, RemindableInterface {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password','permissions'];

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier() {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword() {
        return $this->password;
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken() {
        return $this->remember_token;
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string  $value
     * @return void
     */
    public function setRememberToken($value) {
        $this->remember_token = $value;
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName() {
        return 'remember_token';
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail() {
        return $this->email;
    }

    public function getEmail() {
        return $this->email;
    }
	
	public function outbox() {
        return $this->hasMany('Chefme\Models\Message', 'id', 'id');
    }


    public function getFullName() {
        return ucfirst($this->first_name . " " . $this->last_name);
    }

    public function getId() {
        return $this->id;
    }

    public static function boot() {
        self::$hasher = new \Cartalyst\Sentry\Hashing\NativeHasher;
    }

}

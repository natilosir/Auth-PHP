<?php

namespace natilosir\auth;

use natilosir\cookie\cookie;
use natilosir\orm\db;

function hash($password) {
    $hashedPassword = md5($password);
    return substr($hashedPassword, 5, 15);
}

class Auth extends cookie
{
    protected static $table;    

    public static function attempt($username, $password)
    {
        $user = db::table("users")->where('email', $username)->where('username','=' ,$username,'OR')->first();
        
        if ($user && hash($password) === $user->password) {
            cookie::set('user', $username);
            return $user;
        }
        
        return false;
    }
    

    public static function register($username, $password)
{
    $userExists = db::table("users")->where('email', $username)->where('username','=' ,$username,'OR')->first();

    if ($userExists) {
        return ['status' => 3, 'error' => 'نام کاربری یا ایمیل تکراری است'];
    }

    if (strlen($password) < 5) {
        return ['status' => 2, 'error' => 'کلمه عبور کمتر از 5 است'];
    }

    $hashedPassword = hash($password);
    $field = filter_var($username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    
    db::table("users")->insert([$field => $username, 'password' => $hashedPassword]);
    cookie::set('user', $username);
    return ['status' => 1, 'message' => 'ثبت نام با موفقیت انجام شد'];
}


    public static function logout()
    {
        cookie::delete('user');
    }

    public static function check()
    {
        $user=urldecode(cookie::get('user'));
        $field = filter_var($user, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $user = db::table("users")->where($field, $user)->get();
        
        return $user;
    }

    public static function getUserFromCookie()
    {
        $getCookie = urldecode(cookie::get('user'));
        return isset($getCookie) ? $getCookie : null; 
    }

    public static function getAllUsers()
    {
        return db::table("users")->get();
    }

    public static function user()
    {
        return self::getUserFromCookie();
    }

    public static function id()
    {
        $user = self::getUserFromCookie();
        if ($user) {
            $field = filter_var($user, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
            $userRecord = db::table("users")->where($field, $user)->first();
            return $userRecord ? $userRecord->id : null;
        }
        return null;
    }

    public static function login($user)
    {
        cookie::set('user', $user);
    }

    public static function guard($guard)
    {
        // Implement guard logic if needed
    }

    public static function loginUsingId($id)
    {
        $user = db::table("users")->where('id', $id)->first();
        if ($user) {
            self::login($user);
        }
    }
}

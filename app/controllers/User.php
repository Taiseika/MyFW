<?php

namespace app\controllers;


use app\model\UserModel;

class User extends \vendor\core\base\Controller
{
    public function authAction ()
    {
        $token = UserModel::createToken();
        echo $token;
    }
}

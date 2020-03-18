<?php

namespace app\controllers\store;

use app\models\UserModel;

class Product extends \vendor\core\base\Controller
{
    public function createAction ()
    {

        $token = UserModel::createToken();
        echo $token;
        echo 'controller Product';
    }
}


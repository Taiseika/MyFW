<?php

namespace app\controllers;

class Page extends \vendor\core\base\Controller
{
  public function testAction ()
  {
      debug($_GET);
      echo ($_GET['date']).'<br>';
      echo 'Page:test';
  }

}

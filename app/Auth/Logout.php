<?php

require_once(__DIR__.'/../Session/Session.php');

use App\Session\Session;

$session = new Session();

$cook = $session->getCookie('id');
if ($cook){
  $session->removeCookie('id');
}
header('Location: ../templates/index.php');
<?php

session_start();


require_once(__DIR__ . '/../Database/DBConnection.php');
require_once(__DIR__.'/../Validate/Validate.php');
require_once(__DIR__.'/../Session/Session.php');
require_once(__DIR__.'/../Captcha/Captcha.php');

use App\Database\DBConnection;
use App\Validate\Validate;
use App\Session\Session;
use App\Captcha\Captcha;

class Authentication {

    private $db;
    private $postData;
    private $validate;

    public function __construct(DBConnection $db, Validate $validate, array $postData)
    {
        $this->db = $db;
        $this->validate=$validate;
        $this->postData = $postData;
    }

    public function validateErr($err){
        $_SESSION['err']=$err;
        header('Location: ../templates/auth.php');
        exit;
    }

    public function validateForm()
    {
        $validateEmpty = $this->validate->validateNotEmpty($this->postData);
        $validateMail = $this->validate->validateEmail($this->postData['login']);
        $validatePhone = $this->validate->validatePhone($this->postData['login']);

        if(!$validateEmpty)
            $this->validateErr('Заполните все поля и пройдите Captcha!');
        if (!$validateMail && !$validatePhone)
            $this->validateErr('Введен некорректный логин!');
    }

    public function validatePassAndLogin()
    {
        $sql = 'select * from users where phone = $1 or email = $1';
        $params = [$this->postData['login']];
        $result = $this->db->query($sql, $params);
        $resultRow = $this->db->getRow($result);
        $passwordHash = $resultRow[4];
        if (password_verify($this->postData['password'], $passwordHash ))
            return $resultRow;
        return false;
    }

}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new DBConnection();
    $validate = new Validate();
    $session = new Session();
    $authentication = new Authentication($db,$validate, $_POST);
    $authentication->validateForm();
    $result = $authentication->validatePassAndLogin();
    if ($result)
    {
        $session->setCookie('id', $result[0]);
    }
    $token = $_POST['smart-token'];

    if (Captcha::check_captcha($token)) {
        header('Location: ../templates/profile.php');
    } else {
        header('Location: /app/Auth/Logout.php');
    }

}
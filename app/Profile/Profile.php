<?php

session_start();

require_once(__DIR__ . '/../Database/DBConnection.php');
require_once(__DIR__.'/../Validate/Validate.php');
require_once(__DIR__.'/../Session/Session.php');
require_once(__DIR__.'/../Profile/ProfileCrud.php');

use App\Database\DBConnection;
use App\Validate\Validate;
use App\Session\Session;
use App\Profile\ProfileCrud;

class Profile {

    private $db;
    private $pc;
    private $validate;
    private $session;
    private $postData;

    public function __construct(DBConnection $db, Validate $validate, ProfileCrud $pc, Session $session, array $postData)
    {
        $this->db = $db;
        $this->pc = $pc;
        $this->validate = $validate;
        $this->session = $session;
        $this->postData = $postData;
    }

    public function validateErr($err){
        $_SESSION['err']=$err;
        header('Location: ../templates/profile.php');
        exit;
    }

    public function validateForm()
    {
        $validateName = $this->validate->validateName($this->postData['name']);
        $validateMail = $this->validate->validateEmail($this->postData['email']);
        $validatePhone = $this->validate->validatePhone($this->postData['phone']);
        $validatePassword = !empty($this->postData['confirmPassword']) && $this->validate->validatePassword($this->postData['confirmPassword']);

        if (!$validateName)
            $this->validateErr('Введите имя пользователя!');
        if (!$validateMail)
            $this->validateErr('Введите корректный email!');
        if (!$validatePhone)
            $this->validateErr('Введите корректный номер телефона!');
        if (!empty($this->postData['confirmPassword']) && !$validatePassword)
            $this->validateErr('Слишком простой пароль!');
    }

    public function updatePassword()
    {

        if (empty($this->postData['confirmPassword'])) {
            return false;
        }

        $sql = 'select * from users where id = $1';
        $params = [$this->session->getCookie('id')];
        $result = $this->db->query($sql, $params);
        $resultRow = $this->db->getRow($result);
        $passwordHash = $resultRow[4];

        if (password_verify($this->postData['password'], $passwordHash)) {
            $this->pc->updateData($resultRow['id'], password_hash($this->postData['confirmPassword'], PASSWORD_DEFAULT), 'password');
            $this->validateErr('Пароль успешно обновлен!');
            return true;
        } else {
            $this->validateErr('Старый пароль введен неверно!');
            return false;
        }
    }

    public function updateName()
    {
        $result = $this->pc->updateData($this->session->getCookie('id'), $this->postData['name'], 'name' );
        if ($result) {
            return true;
        }
        return false;
    }

    public function updatePhone()
    {
        $result = $this->pc->updateData($this->session->getCookie('id'), $this->postData['phone'], 'phone' );
        if ($result) {
            return true;
        }
        return false;
    }

    public function updateEmail()
    {
        $result = $this->pc->updateData($this->session->getCookie('id'), $this->postData['email'], 'email' );
        if ($result) {
            return true;
        }
        return false;
    }

    public function processUpdates()
    {
        $this->validateForm();
        $this->updateName();
        $this->updatePhone();
        $this->updateEmail();
        $this->updatePassword();
        header('Location: ../templates/profile.php');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $session = new Session();
    $db = new DBConnection();
    $pc = new ProfileCrud($db);
    $validate = new Validate();
    $profile = new Profile($db, $validate, $pc, $session, $_POST);
    $profile->processUpdates();
}

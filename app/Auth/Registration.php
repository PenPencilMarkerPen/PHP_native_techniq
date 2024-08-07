<?php
session_start();

require_once(__DIR__ . '/../Database/DBConnection.php');
require_once(__DIR__.'/../Validate/Validate.php');

use App\Database\DBConnection;
use App\Validate\Validate;

class Registration {

    private $db;
    private $validate;
    private $postData;

    public function __construct(DBConnection $db, Validate $validate, array $postData) {
        $this->db = $db;
        $this->validate=$validate;
        $this->postData = $postData;
    }

    public function validateErr($err){
        $_SESSION['err']=$err;
        header('Location: ../templates/reg.php');
        exit;
    }

    public function validatePasswords(){
        if (isset($this->postData['password'], $this->postData['confirmPassword'])) {
            return $this->postData['password'] === $this->postData['confirmPassword'];
        }
        return false;
    }

    public function validateForm()
    {
        $validateEmpty = $this->validate->validateNotEmpty($this->postData);
        $validateName = $this->validate->validateName($this->postData['name']);
        $validateMail = $this->validate->validateEmail($this->postData['email']);
        $validatePhone = $this->validate->validatePhone($this->postData['phone']);
        $validatePassword = $this->validate->validatePassword($this->postData['password']);
        
        if(!$validateEmpty)
            $this->validateErr('Заполните все поля!');
        if (!$validateName)
            $this->validateErr('Введите имя пользователя!');
        if(!$validateMail)
            $this->validateErr('Введите корректный email!');
        if(!$validatePhone)
            $this->validateErr('Введите корректный номер телефона!');
        if(!$validatePassword)
            $this->validateErr('Слишком простой пароль!');
    }

    public function registerUser() {
        if ($this->validatePasswords()) {
            $passwordHash = password_hash($this->postData['password'], PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (name, phone, email, password) VALUES ($1, $2, $3, $4)";
            $params = [$this->postData['name'], $this->postData['phone'], $this->postData['email'], $passwordHash];
            $result =  $this->db->query($sql, $params);
            if (!$result)
            {
                $this->validateErr('Данная почта или номер телефона уже используется!');
            }
            header('Location: ../templates/auth.php');
            return true;
        } else {
            $this->validateErr('Пароли не совпадают!');
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new DBConnection();
    $validate = new Validate();
    $registration = new Registration($db,$validate, $_POST);
    $registration->validateForm();
    $registration->registerUser();
}
?>

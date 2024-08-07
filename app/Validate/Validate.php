<?php

namespace App\Validate;

require_once('ValidateInterface.php');

use App\Validate\ValidateInterface;

class Validate implements ValidateInterface {

    public function validateName($data): bool
    {
        return strlen($data) > 1;
    }

    public function validatePhone($data): bool
    {
        return preg_match('/^(8|\+7)\d{10}$/', $data);
    }

    public function validateEmail($data): bool
    {
        return preg_match('/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i', $data);
    }

    public function validatePassword($data): bool
    {
        return preg_match('/^(?=.*[A-Z])(?=.*[\W_]).{6,}$/', $data);
    }
    public function validateNotEmpty(array $data): bool
    {
        $filteredData = array_filter($data, function($value) {
            return !empty($value);
        });
        return count($filteredData) === count($data);
    }
}

// $test = new Validate();
// var_dump($test->validatePassword('1234FWq*'));

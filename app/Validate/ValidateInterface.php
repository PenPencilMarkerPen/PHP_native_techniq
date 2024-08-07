<?php

namespace App\Validate;

interface ValidateInterface{

    public function validateName($data):bool;
    public function validateEmail($data):bool;
    public function validatePhone($data):bool;
    public function validatePassword($data):bool;
    public function validateNotEmpty(array $data):bool;
}
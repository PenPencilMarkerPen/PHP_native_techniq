<?php


namespace App\Models;

require_once(__DIR__.'/../Database/DBConnection.php');


use App\Database\DBConnection;

class UserDB {

    private $db; 

    function __construct()
    {
        $this->db= new DBConnection();
    }

    function createTableUser()
    {
        $table = 'create table users(
            id serial primary key,
            name varchar(30) not null,
            phone varchar(12) not null unique,
            email varchar(50) not null unique,
            password varchar(255) not null
        );';
        $result=$this->db->query($table);
        if ($result)
            return true;
        return false;
    }
}


$test = new UserDB();

$test->createTableUser();

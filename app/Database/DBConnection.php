<?php

namespace App\Database;

class DBConnection {

    private $db;
    function __construct()
    {
        $config = parse_ini_file(__DIR__.'/../../config.ini', true);
        $this->db= pg_connect("host={$config['db']['host']} dbname={$config['db']['name']} user={$config['db']['username']} password={$config['db']['password']}");
        if (!$this->db)
        {
            echo "Произошла ошибка подключения к БД.\n";
            exit;
        }
    }

    function query($sql, $params=[])
    {
        $result = pg_query_params($this->db, $sql, $params);
        if (!$result) {
            // echo "Ошибка выполнения запроса: " . pg_last_error($this->db);
            return false;
        }
        return $result;
    }

    function getRow($result){
        return pg_fetch_row($result);
    }

    function getAll($result){
        return pg_fetch_all($result);
    }

    function getNumRows($result)
    {
        return pg_num_rows($result);
    }
    function closeDB()
    {
        pg_close($this->db);
    }
}

$config = parse_ini_file(__DIR__.'/../../config.ini', true);

$test = new DBConnection($config);
$res=$test->query('select * from example where col = $1', array('3'));
var_dump($test->getNumRows($res));


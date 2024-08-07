<?php

namespace App\Profile;

require_once(__DIR__ . '/../Database/DBConnection.php');

use App\Database\DBConnection;

class ProfileCrud {

    private $db;

    public function __construct(DBConnection $db)
    {
        $this->db = $db;
    }

    public function updateData($id, $data, $field)
    {
        $sql = "update users set $field = $1 where id = $2";
        $params = [$data, $id];
        $result = $this->db->query($sql, $params);
        if ($result)
            return true;
        return false;
    }

}


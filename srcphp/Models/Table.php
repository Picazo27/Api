<?php

namespace proyecto\Models;

use PDO;
use proyecto\Conexion;
use Dotenv\Dotenv;

class Table
{
    public static $pdo = null;
    public function __construct()
    {

    }
    static  function getDataconexion(){




}
    static function query($query)
    {
        $cc = new  Conexion("gimnasioda", "localhost", "root", "");
        self::$pdo = $cc->getPDO();
        $stmt = self::$pdo->query($query);
        $resultados = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $resultados;
    }

    static function queryParams($query,$params = [])
    {
        $cc = new  Conexion("gimnasioda", "localhost", "root", "");
        self::$pdo = $cc->getPDO();

        $stmt = self::$pdo->prepare($query);
        $stmt -> execute($params);

        $resultados = $stmt ->fetchAll(PDO::FETCH_OBJ);
        return $resultados;
    }

}

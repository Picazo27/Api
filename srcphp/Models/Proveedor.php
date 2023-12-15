<?php

namespace proyecto\Models;


use PDO;
use proyecto\Auth;
use function json_encode;

class proveedor extends Models
{
    public $id;
    public $nombre_proveedor;
    public $direccion;
    public $corre_electronico;

    protected  $table = "proveedores";
    /**
     * @var array
     */
    protected $filleable = [
        "nombre_proveedor","direccion","corre_electronico"
    ];

}
?>
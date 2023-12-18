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
    public $correo_electronico;
    public $telefono;

    protected  $table = "proveedores";
    /**
     * @var array
     */
    protected $filleable = [
        "nombre_proveedor","direccion","correo_electronico","telefono"
    ];

}
?>
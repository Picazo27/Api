<?php

namespace proyecto\Models;


use PDO;
use proyecto\Auth;
use function json_encode;

class producto extends Models
{

public $id;
 public $nombre_producto;
 public $imagen;
 public $descripcion;
 public $precio;
 public $categoria;
 public $existencia;
 public $proveedor;
 
    protected  $table = "productos";
    /**
     * @var array
     */
    protected $filleable = [
        "nombre_producto","imagen","descripcion","categoria","precio","existencia","proveedor"
    ];

    public function registrarProducto($data)
    {
        $this->create($data);
    }

}

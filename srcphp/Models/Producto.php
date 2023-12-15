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
 public $id_categoria;
 public $existencia;

 
    protected  $table = "productos";
    /**
     * @var array
     */
    protected $filleable = [
        "nombre_producto","imagen","descripcion","id_categoria","precio","existencia"
    ];

    public function registrarProducto($data)
    {
        $this->create($data);
    }

}

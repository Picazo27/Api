<?php

use proyecto\Models\Models;

class orden_compra extends Models
{
    public $id;
    public $fecha;
    public $proveedor;


    protected  $table = "orden_compra";
    /**
     * @var array
     */
    protected $filleable = [
        "fecha","proveedor"
    ];

}
?>
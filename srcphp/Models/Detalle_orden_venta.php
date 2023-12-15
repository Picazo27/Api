<?php

use proyecto\Models\Models;

class detalle_orden_venta extends Models
{
    public $id;
    public $orden;
    public $producto;
    public $cantidad;
    public $precio;

    protected  $table = "detalle_orden_venta";
    /**
     * @var array
     */
    protected $filleable = [
        "orden","producto","cantidad","precio"
    ];

}
?>
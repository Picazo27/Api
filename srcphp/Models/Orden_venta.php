<?php

use proyecto\Models\Models;

class orden_venta extends Models
{
    public $id;
    public $fecha;
    public $hora_recibida;
    public $hora_estimada;
    public $direccion_entrega;
    public $forma_pago;
    public $cliente;
    public $empleado;
    public $estatus;


    protected  $table = "orden_venta";
    /**
     * @var array
     */
    protected $filleable = [
        "fecha","hora_recibida","hora_estimada","direccion_entrega","forma_pago","cliente","empleado","estatus"
    ];

}
?>
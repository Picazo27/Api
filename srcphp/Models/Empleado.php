<?php

namespace proyecto\Models;

class empleado extends Models
{
    public $id;
    public $id_usuario;
    public $RFC;
    public $estatus;
    public $salario_mensual;

    protected  $table = "empleados";
    /**
     * @var array
     */
    protected $filleable = [
        "id_usuario","RFC","estatus","salario_mensual"
    ];

}
?>
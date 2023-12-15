<?php

use proyecto\Models\Models;

class empleado extends Models
{
    public $id;
    public $id_usuario;
    public $RFC;
    public $estatus;

    protected  $table = "empleados";
    /**
     * @var array
     */
    protected $filleable = [
        "id_usuario","RFC","estatuss"
    ];

}
?>
<?php
namespace proyecto\Models;
class Direccion extends Models
{
    public $id;
    public $calle;
    public $numero;
    public $colonia;
    public $codigo_postal;

    protected  $table = "direcciones";
    /**
     * @var array
     */
    protected $filleable = [
        "calle","numero","colonia","codigo_postal"
    ];

}
?>
?>
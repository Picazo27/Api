<?php
namespace proyecto\Models;
class direccion_user extends Models
{
    public $id;
    public $id_user;
    public $id_direccion;

    protected  $table = "direccion_user";
    /**
     * @var array
     */
    protected $filleable = [
        "id_user","id_direccion"
    ];

}
?>
?>
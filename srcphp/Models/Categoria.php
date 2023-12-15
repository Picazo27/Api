<?php

namespace proyecto\Models;
class categoria extends Models
{
    public $id;
    public $nombre_categoria;
    public $slug;

    protected  $table = "categorias";
    /**
     * @var array
     */
    protected $filleable = [
        "nombre_categoria","slug"
    ];

}
?>
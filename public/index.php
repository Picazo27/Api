<?php

namespace proyecto;
require("../vendor/autoload.php");
use proyecto\Controller\HomeController;
use proyecto\Controller\UserController;
use proyecto\Controller\crearPersonaController;
use proyecto\Models\User;
use proyecto\Response\Failure;
use proyecto\Response\Success;

Router::headers();

Router::get("/", function () {
    echo "Bienvenido";
});



Router::get("/mostrar",[HomeController::class,"mostrarproducto"]);
Router::get("/proteina",[HomeController::class,"mostrarProteina"]);
Router::get("/cretina",[HomeController::class,"mostrarCreatina"]);
Router::get("/aminoacidos",[HomeController::class,"mostrarAminoacidos"]);
Router::get("/preentreno",[HomeController::class,"mostrarPre"]);
Router::get("/suplemento",[HomeController::class,"mostrarSuplemento"]);


Router::get('/proveedores', [HomeController::class, "prov"]);

Router::get('/proveedore', [HomeController::class,"prov"]);
Router::get("/categorias",[HomeController::class,"cate"]);

Router::post("/insertarproducto",[HomeController::class,"Insertarproducto"]);


Router::post('/registro', [UserController::class, 'registro']);
Router::post('/login', [UserController::class, "login"]);

Router::post('/registrarempleado',[UserController::class, 'registrarEmpleado']);
Router::post('/registroproveedor',[UserController::class, 'registroproveedor']);
?>



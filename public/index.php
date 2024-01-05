<?php

namespace proyecto;
require("../vendor/autoload.php");
use proyecto\Controller\HomeController;
use proyecto\Controller\UserController;
use proyecto\Controller\VentaController;
use proyecto\Controller\crearPersonaController;
use proyecto\Models\User;
use proyecto\Response\Failure;
use proyecto\Response\Success;

Router::headers();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


Router::get("/", function () {
    echo "Bienvenido";
});

Router::get("/mostrarp",[HomeController::class,"mostrarP"]);


Router::get("/mostrar",[HomeController::class,"mostrarproducto"]);
Router::get("/proteina",[HomeController::class,"mostrarProteina"]);
Router::get("/cretina",[HomeController::class,"mostrarCreatina"]);
Router::get("/aminoacidos",[HomeController::class,"mostrarAminoacidos"]);
Router::get("/preentreno",[HomeController::class,"mostrarPre"]);
Router::get("/suplemento",[HomeController::class,"mostrarSuplemento"]);
Router::get("/ordenes", [HomeController::class, "ordenes"]);
Router::get("/empleados",[HomeController::class,"empleados"]);


Router::get('/proveedores', [HomeController::class, "prov"]);
Router::get('/proveedor', [HomeController::class, "proveedor"]);

Router::get('/proveedore', [HomeController::class,"prov"]);
Router::get("/categorias",[HomeController::class,"cate"]);

Router::post("/insertarproducto",[HomeController::class,"Insertarproducto"]);


Router::post('/registro', [UserController::class, 'registro']);
Router::post('/login', [UserController::class, "login"]);

Router::post('/registrarempleado',[UserController::class, 'registrarEmpleado']);
Router::post('/registroproveedor',[UserController::class, 'registroproveedor']);

Router::post('/eliminarempleado',[HomeController::class,"eliminarempleado"]);
Router::post('/auth',[UserController::class,"auth"]);

Router::post('/ordenventa',[HomeController::class,"ordenventa"]);

Router::get('/cliente',[UserController::class,"cliente"]);
Router::get('/direcciones',[HomeController::class,"direcciones"]);

?>



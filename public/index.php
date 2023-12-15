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

Router::get("/mostrar",[HomeController::class,"mostrarproducto"]);
Router::get('/proveedores', [HomeController::class, "prov"]);

Router::get('/proveedore', [HomeController::class,"prov"]);
Router::get("/categorias",[HomeController::class,"cate"]);

Router::get("/insertarproducto",[HomeController::class,"Insertarproducto"]);

Router::post('/registrousuario', [UserController::class, 'registrousuario']);
Router::post('/login', [UserController::class, "login"]);





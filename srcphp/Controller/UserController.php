<?php

namespace proyecto\Controller;

use proyecto\Auth;
use proyecto\Models\User;
use proyecto\Response\Failure;
use proyecto\Response\Success;
use proyecto\Models\Table;
use proyecto\Models\Direccion_user;
use proyecto\Models\direccion;

class UserController
{



    function auth()
    {
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);
            if (!property_exists($dataObject, "user") || !property_exists($dataObject, "contrasena")) {
                throw new \Exception("Faltan datos");
            }
            return User::auth($dataObject->user, $dataObject->contrasena);

        } catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }


    }


    public function registro()
{
    try {
        $JSONData = file_get_contents("php://input");
        $dataObject = json_decode($JSONData);

        // Crear y guardar la dirección
        $direccion = new Direccion();
        $direccion->calle = $dataObject->calle;
        $direccion->numero = $dataObject->numero;
        $direccion->colonia = $dataObject->colonia;
        $direccion->codigo_postal = $dataObject->codigo_postal;
        $direccion->save();

        // Crear y guardar el usuario
        $user = new User();
        $user->nombre = $dataObject->nombre;
        $user->apellido_p = $dataObject->apellido_p;
        $user->apellido_m = $dataObject->apellido_m;
        $user->user = $dataObject->correo;
        $user->contrasena = password_hash($dataObject->contrasena, PASSWORD_DEFAULT);
        $user->save();

        // Crear la relación en la tabla direccion_user
        $direccionUser = new Direccion_User();
        $direccionUser->id_user = $user->id;
        $direccionUser->id_direccion = $direccion->id;
        $direccionUser->save();

        $r = new Success($user);

        return $r->Send();
    } catch (\Exception $e) {
        $r = new Failure(401, $e->getMessage());
        return $r->Send();
    }
}

    function verificarUsuario($email_usuario, $contrasena) {
        $resultados = Table::queryParams("SELECT * FROM usuarios WHERE user = :email_usuario", ['email_usuario' => $email_usuario]);

        if(count($resultados) > 0) {
            $usuario = $resultados[0];
            if($usuario->contrasena=== $contrasena) {
                return $resultados;
            }
        }

        return false;
    }
    public function verificar() {
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $user = $dataObject->user;
            $contrasena = $dataObject->contrasena;

            $resultado = $this->verificarUsuario($user, $contrasena);


            if($resultado) {

                $response = array(
                    "message" => "Inicio de sesión exitoso",
                    "data" => $resultado
                );
                $r = new Success($response);
                return $r->send();
            } else {

                $r = new Failure(401, "No se encontró el usuario o la contraseña es incorrecta");
                return $r->send();
            }
        } catch (\Exception $e) {

            $r = new Failure(500, "Error en el servidor: ".$e->getMessage());
            return $r->Send();
        }
    }
    public function login() {
        $JSONData = file_get_contents("php://input");
        $dataObject = json_decode($JSONData);

        $email_usuario = $dataObject->user;
        $contrasena_usuario = $dataObject->contrasena;

        // Verificar credenciales y generar token si es exitoso
        $response = $this->verifyCredentials($email_usuario, $contrasena_usuario);

        // Enviar la respuesta al cliente
        echo json_encode($response);
    }
   
    private function verifyCredentials($email_usuario, $contrasena_usuario) {
        try {
            // Buscar un usuario por correo electrónico
            $user = User::where('user', '=', $email_usuario);

            if($user) {
                // Verificar la contraseña almacenada en la base de datos
                $storedPassword = $user[0]->contrasena;

                if(password_verify($contrasena_usuario, $storedPassword)) {
                    $token = auth::generateToken([$user[0]->id]); // Asegúrate de que sea la clave primaria correcta
                    return ['success' => true, 'token' => $token];
                } else {
                    return ['success' => false, 'message' => 'Credenciales incorrectas'];
                }
            } else {
                return ['success' => false, 'message' => 'Credenciales incorrectas'];
            }
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Error en el servidor: '.$e->getMessage()];
        }
    }

  
}

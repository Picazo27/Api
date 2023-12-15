<?php

namespace proyecto\Controller;

require("../vendor/autoload.php");

use proyecto\Models\Producto;
use proyecto\Models\proveedor;
use proyecto\Models\categoria;
use proyecto\Models\Table;
use proyecto\Response\Success;
use proyecto\Response\Failure;
use proyecto\Conexion;

class HomeController
{
    private $conexion;
    public function __construct()
    {
        $this->conexion = new Conexion('gimnasioda', 'localhost', 'root', '');
    }

    public function bienvenido()
    {
        echo "Bienvenido";
    }

    public function prueba()
    {
        echo "Prueba";
    }

    public function mostrarProducto()
    {
        try {
            $productos = Table::query("SELECT * FROM productos");
            $productos = new Success($productos);
            $productos->Send();
            return $productos;
        } catch (\Exception $e) {
            $s = new Failure(401, $e->getMessage());
            return $s->Send();
        }
    }

    public function prov()
    {
        try {
            $proveedores = Table::query("SELECT * FROM proveedores");
            $proveedores = new Success($proveedores);
            $proveedores->Send();
            return $proveedores;
        } catch (\Exception $e) {
            $s = new Failure(401, $e->getMessage());
            return $s->Send();
        }
    }

    public function mostrarProteina()
    {
        try {
            $productos = Table::query("SELECT * FROM productos WHERE categoria = 'Proteina'");
            $productos = new Success($productos);
            $productos->Send();
            return $productos;
        } catch (\Exception $e) {
            $s = new Failure(401, $e->getMessage());
            return $s->Send();
        }
    }

    public function mostrarCreatina()
    {
        try {
            $productos = Table::query("SELECT * FROM productos WHERE categoria = 'Creatina'");
            $productos = new Success($productos);
            $productos->Send();
            return $productos;
        } catch (\Exception $e) {
            $s = new Failure(401, $e->getMessage());
            return $s->Send();
        }
    }

    public function mostrarAminoacidos()
    {
        try {
            $productos = Table::query("SELECT * FROM productos WHERE categoria = 'Aminoacidoa'");
            $productos = new Success($productos);
            $productos->Send();
            return $productos;
        } catch (\Exception $e) {
            $s = new Failure(401, $e->getMessage());
            return $s->Send();
        }
    }

    public function mostrarPre()
    {
        try {
            $productos = Table::query("SELECT * FROM productos WHERE categoria = 'Pre-entreno'");
            $productos = new Success($productos);
            $productos->Send();
            return $productos;
        } catch (\Exception $e) {
            $s = new Failure(401, $e->getMessage());
            return $s->Send();
        }
    }

    public function mostrarSuplemento()
    {
        try {
            $productos = Table::query("SELECT * FROM productos WHERE categoria = 'Suplemento'");
            $productos = new Success($productos);
            $productos->Send();
            return $productos;
        } catch (\Exception $e) {
            $s = new Failure(401, $e->getMessage());
            return $s->Send();
        }
    }

    public function Insertarproducto()
            {
                try {
                    $JSONData = file_get_contents("php://input");
                    $dataObject = json_decode($JSONData);
                    $prod = new Producto();
                    $prod->nombre_producto = $dataObject->nombre_producto;
                    $prod->descripcion = $dataObject->descripcion;
                    $prod->precio = $dataObject->precio;
                    $prod->existencia = $dataObject->existencia;
            
                    // Poder guardar imagen
                    $imagenBase64 = $dataObject->imagen;
                    
                    // Verificar si la cadena base64 tiene el formato esperado
                    if (strpos($imagenBase64, 'data:image') !== 0) {
                        throw new \Exception('La cadena base64 no parece ser una imagen válida.');
                    }
            
                    // Eliminar el encabezado de la cadena base64
                    $base64WithoutHeader = substr($imagenBase64, strpos($imagenBase64, ',') + 1);
                    $imagenData = base64_decode($base64WithoutHeader);
            
                    // Usar getimagesize para obtener el tipo MIME
                    $imageInfo = getimagesizefromstring($imagenData);
                    if ($imageInfo === false || !isset($imageInfo['mime'])) {
                        throw new \Exception('No se pudo obtener información de la imagen.');
                    }
            
                    $mime_type = $imageInfo['mime'];
            
                    // Validar la extensión permitida
                    $extensionMap = [
                        'image/jpeg' => 'jpg',
                        'image/jpg'  => 'jpg',
                        'image/png'  => 'png',
                        'image/svg+xml' => 'svg',
                    ];
            
                    if (!array_key_exists($mime_type, $extensionMap)) {
                        throw new \Exception('Formato de imagen no permitido');
                    }
            
                    $fileExtension = $extensionMap[$mime_type];
                    $nombreImagen = uniqid() . '.' . $fileExtension;
            
                    $rutaImagen = '/var/www/html/Api/public/img/productos/' . $nombreImagen;
            
                    // Guardar la imagen en el servidor
                    if (file_put_contents($rutaImagen, $imagenData) === false) {
                        throw new \Exception('Error al guardar la imagen: ' . error_get_last()['message']);
                    }
            
                    $prod->imagen = $rutaImagen;
                    $prod->categoria = $dataObject->categoria;
                    $prod->save();
            
                    $s = new Success($prod);
            
                    return $s->Send();
                } catch (\Exception $e) {
                    $s = new Failure(401, $e->getMessage());
                    return $s->Send();
                }
            }

    public function mostrarUsuarios()
    {
        try {
            $usuarios = Table::query("SELECT * FROM users");
            $usuarios = new Success($usuarios);
            $usuarios->Send();
            return $usuarios;
        } catch (\Exception $e) {
            $s = new Failure(401, $e->getMessage());
            return $s->Send();
        }
    }

    public function mostrarUsario()
    {
        try {
            $usuario = Table::query("SELECT users.nombre,users.apellido_p,users.apellido_m,users.telefono,users.user,users.contrasena,
            direcciones.calle,direcciones.numero,direcciones.colonia,direcciones.codigo_postal
           FROM users
           inner join direccion_user on users.id = direccion_user.id_user
           inner join direcciones on direcciones.id = direccion_user.id_direccion;");
            $usuario = new Success($usuario);
            $usuario->Send();
            return $usuario;
        } catch (\Exception $e) {
            $s = new Failure(401, $e->getMessage());
            return $s->Send();
        }
    }
/*
    public function actualizarPerfil($datosPerfil)
    {
        try {
            // Suponiendo que Table tenga un método para actualizar un perfil por ID
            $perfil = Table::find($datosPerfil['id']);

            if ($perfil) {
                // Actualizar los campos del perfil con los datos recibidos desde la vista
                $perfil->nombre = $datosPerfil['nombre'];
                $perfil->apellido_paterno = $datosPerfil['apellido_paterno'];
                $perfil->apellido_materno = $datosPerfil['apellido_materno'];
                $perfil->telefono = $datosPerfil['telefono'];
                $perfil->user = $datosPerfil['user'];
                $perfil->contrasena = $datosPerfil['contrasena'];
                // Guardar los cambios en el perfil
                $perfil->save();

                $respuesta = new Success('Perfil actualizado correctamente');
                $respuesta->Send();
                return $respuesta;
            } else {
                throw new \Exception('No se encontró el perfil del usuario');
            }
        } catch (\Exception $e) {
            $error = new Failure(401, $e->getMessage());
            return $error->Send();
        }
    }
}*/

}


?>
<?php

namespace proyecto\Controller;

require("../vendor/autoload.php");

use proyecto\Models\Producto;
use proyecto\Models\Proveedor;
use proyecto\Models\categoria;
use proyecto\Models\Table;
use proyecto\Response\Success;
use proyecto\Response\Failure;
use proyecto\Models\User;
use proyecto\Models\Empleado;
use proyecto\Conexion;

class HomeController
{
    private $conexion;
    public function __construct()
    {
        $this->conexion = new Conexion("GimnasioDa", "localhost", "gimansio", "gym123");
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
            $productos = Table::query("SELECT nombre_producto,imagen,descripcion,precio,
            existencia FROM productos");
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
            $proveedores = Table::query("SELECT nombre_proveedor,direcciones.calle,
            direcciones.numero,direcciones.colonia,direcciones.codigo_postal,correo_electronico 
            FROM proveedores
            inner join direcciones on proveedores.direccion = direcciones.id");
            $proveedores = new Success($proveedores);
            $proveedores->Send();
            return $proveedores;
        } catch (\Exception $e) {
            $s = new Failure(401, $e->getMessage());
            return $s->Send();
        }
    }

    public function proveedor()
    {
        try {
            $proveedores = Table::query("SELECT id,nombre_proveedor
            FROM proveedores");
            $proveedores = new Success($proveedores);
            $proveedores->Send();
            return $proveedores;
        } catch (\Exception $e) {
            $s = new Failure(401, $e->getMessage());
            return $s->Send();
        }
    }

    public function empleados()
    {
        try {
            $proveedores = Table::query("SELECT nombre,RFC,concat(direcciones.calle,' ',direcciones.numero, ' ', direcciones.colonia, ' ' ,
            direcciones.codigo_postal) as direccion,
            user,Estatus
            FROM empleados
            inner join users on users.id = empleados.id_usuario
            inner join direccion_user on direccion_user.id_user = users.id
            inner join direcciones on direccion_user.id_direccion = direcciones.id
            ");
            $proveedores = new Success($proveedores);
            $proveedores->Send();
            return $proveedores;
        } catch (\Exception $e) {
            $s = new Failure(401, $e->getMessage());
            return $s->Send();
        }
    }

    public function eliminarempleado()
    {
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $empleado = new Empleado();

            $empleado = $dataObject->id;

            $db = Empleado::deleteby("id", "=", $empleado);

            $r = new Success($db);
            return $r->Send();

        } catch (\Exception $e) {
            $s = new Failure(401, $e->getMessage());
            return $s->Send();
        }
    }


    public function ordenes()
    {
        try {
            $proveedores = Table::query("SELECT id,users.nombre,estatus FROM orden_venta
            INNER JOIN users ON orden_venta.cliente = users.id;");
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
            $productos = Table::query("SELECT nombre_producto,imagen,descripcion,precio,
            existencia FROM productos WHERE categoria = 'Proteina'");
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
            $productos = Table::query("SELECT nombre_producto,imagen,descripcion,precio,
            existencia FROM productos WHERE categoria = 'Creatina'");
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
            $productos = Table::query("SELECT nombre_producto,imagen,descripcion,precio,
            existencia FROM productos WHERE categoria = 'Aminoacidoa'");
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
            $productos = Table::query("SELECT nombre_producto,imagen,descripcion,precio,
            existencia FROM productos WHERE categoria = 'Pre-entreno'");
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
            $productos = Table::query("SELECT nombre_producto,imagen,descripcion,precio,
            existencia FROM productos WHERE categoria = 'Suplemento'");
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
            // Obtener datos JSON directamente
            $JSONData = file_get_contents("php://input");
            echo 'JSON recibido: ' . $JSONData . PHP_EOL;
            $dataObject = json_decode($JSONData);
    
            // Verificar errores en la decodificación
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Error al decodificar JSON: ' . json_last_error_msg());
            }
    
            // Verificar la existencia de campos obligatorios en el JSON
            if (!property_exists($dataObject, 'nombre_producto') || !property_exists($dataObject, 'descripcion') || !property_exists($dataObject, 'precio')) {
                throw new \Exception('Faltan datos obligatorios en el JSON.');
            }
    
            $prod = new Producto();
            $prod->nombre_producto = $dataObject->nombre_producto;
            $prod->descripcion = $dataObject->descripcion;
            $prod->precio = $dataObject->precio;
            $prod->existencia = property_exists($dataObject, 'existencia') ? $dataObject->existencia : null;
    
            // Validar campos obligatorios
            if (empty($prod->nombre_producto) || empty($prod->descripcion) || empty($prod->precio)) {
                throw new \Exception('Campos obligatorios incompletos.');
            }
    
            // Verificar si el campo de imagen es un array
            if (!property_exists($dataObject, 'imagen') || !is_array($dataObject->imagen)) {
                throw new \Exception('El campo de imagen no es un array válido.');
            }
    
            // Verificar cada imagen en el array
            foreach ($dataObject->imagen as $imagenObj) {
                // Verificar si la propiedad "tuCampoConBase64" existe en el objeto de imagen
                if (!property_exists($imagenObj, 'imagenBase64')) {
                    throw new \Exception('Falta la propiedad "imagenBase64" en el objeto de imagen.');
                }
                
    
                $imagenBase64 = $imagenObj->tuCampoConBase64;
    
                echo 'Cadena Base64: ' . $imagenBase64 . PHP_EOL;
    
                // Verificar si la cadena base64 tiene el formato esperado
                if (strpos($imagenBase64, 'data:image') !== 0) {
                    throw new \Exception('La cadena base64 no parece ser una imagen válida.');
                }
    
                // Eliminar el encabezado de la cadena base64
                $base64WithoutHeader = substr($imagenBase64, strpos($imagenBase64, ',') + 1);
    
                // Verificar errores en la decodificación de la cadena Base64
                $imagenData = base64_decode($base64WithoutHeader);
                if ($imagenData === false) {
                    throw new \Exception('Error al decodificar la cadena Base64.');
                }
    
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
    
                $rutaImagen = '/var/www/html/apiPhp/public/img/productos/' . $nombreImagen;
    
                // Guardar la imagen en el servidor usando file_put_contents
                if (file_put_contents($rutaImagen, $imagenData) === false) {
                    throw new \Exception('Error al guardar la imagen: ' . error_get_last()['message']);
                }
    
                $prod->imagen = $rutaImagen;
            }
    
            // Verificar si el proveedor existe
            if (property_exists($dataObject, 'proveedor')) {
                $proveedorId = $dataObject->proveedor;
                $proveedorExistente = Proveedor::find($proveedorId);
    
                if (!$proveedorExistente) {
                    throw new \Exception('El proveedor seleccionado no existe.');
                }
    
                $prod->proveedor = $proveedorId;
            }
    
            // Verificar si el campo de categoría existe
            if (property_exists($dataObject, 'categoria')) {
                $prod->categoria = $dataObject->categoria;
            }
    
            // Guardar el producto después de procesar todas las imágenes
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

public function registrarEmpleado()
{
    try {
        // Obtener datos del JSON
        $JSONData = file_get_contents("php://input");
        $dataObject = json_decode($JSONData);

        // Extraer datos
        $nombre_usuario = $dataObject->nombre_usuario;
        $id_usuario = $dataObject->id_usuario;
        $RFC = $dataObject->RFC;

        $exist_user = User::where('nombre_usuario', '=', $dataObject->nombre_usuario);
            if ($exist_user) {
                throw new \Exception("El usuario ya está registrado.");
            }
        


        // Crear empleado asociado al usuario
        $empleado = new Empleado();
        $empleado->id_usuario = $id_usuario;
        $empleado->RFC = $RFC;
        $empleado->estatus = 'activo';
        $empleado->save();

        // Puedes retornar un mensaje de éxito o cualquier otro tipo de respuesta
        $response = ['mensaje' => 'Empleado registrado exitosamente'];
        $s = new Success($response);
        return $s->Send();
    } catch (\Exception $e) {
        // En caso de error, retornar un mensaje de error
        $s = new Failure(401, $e->getMessage());
        return $s->Send();
    }
}


}


?>
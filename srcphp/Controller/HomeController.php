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
use proyecto\Models\Detalle_orden_venta;
use proyecto\Models\Orden_venta;

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

    public function verordenes($clienteId)
    {
        try {
            $productos = Table::query("SELECT *
            FROM users
            INNER JOIN orden_venta ON users.id = orden_venta.cliente
            INNER JOIN detalle_orden_venta ON orden_venta.id = detalle_orden_venta.orden
            WHERE users.id = $clienteId");

            $productos = new Success($productos);
            $productos->Send();
            return $productos;
        } catch (\Exception $e) {
            $s = new Failure(401, $e->getMessage());
            return $s->Send();
        }
    }

    public function ordenventa()
    {
        try{

            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $pedidos = new Orden_venta();
            $pedidos->fecha = date('Y-m-d');             
            $pedidos->forma_pago = $dataObject->forma_pago;
            $pedidos->hora_recibida = date('H:i:s'); 
            $pedidos->estatus = "en espera";
            $pedidos->cliente= $dataObject->cliente;
            $pedidos->save();

            $detalle_pedido = new Detalle_orden_venta();
            $detalle_pedido->orden = $pedidos->id;
            $detalle_pedido->producto = $dataObject->producto;
            $detalle_pedido->cantidad = $dataObject->cantidad;
            $detalle_pedido->precio = $dataObject->precio;
            $detalle_pedido->save();
           
            $respone = array(
                'pedido' => $pedidos,
                'detalle_pedido' => $detalle_pedido
            );

            $r = new Success($respone);
            return $r->Send();
        } catch (\Exception $e) {
            $s = new Failure(401, $e->getMessage());
            return $s->Send();
        }
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

    public function mostrarP()
    {
        try {
            $productos = Table::query("SELECT nombre_producto, categoria, precio, existencia,
            precio, nombre_proveedor FROM productos
            inner join proveedores on proveedores.id = productos.proveedor");
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
            $proveedores = Table::query("SELECT orden_venta.id,users.nombre,estatus FROM orden_venta
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

    public function clientes()
    {
        try {
            $productos = Table::query("SELECT users.id, nombre, concat(apellido_p, ' ', 
            apellido_m) as apellido, concat(calle,' ',numero,' ',colonia,' ',
            codigo_postal) as direccion,user, telefono, apellido_p, apellido_m FROM users
            inner join direccion_user on users.id = direccion_user.id_user
            inner join direcciones on direcciones.id = direccion_user.id_direccion 
            WHERE roles = 'cliente'");
            $productos = new Success($productos);
            $productos->Send();
            return $productos;
        } catch (\Exception $e) {
            $s = new Failure(401, $e->getMessage());
            return $s->Send();
        }
    }

    private function validarProveedor($proveedorId, $proveedores)
{
    foreach ($proveedores as $proveedor) {
        if ($proveedor->id == $proveedorId) {
            return true;
        }
    }

    return false;
}


public function Insertarproducto()
{
    try {
        // Obtiene los datos del cuerpo de la solicitud
        $JSONData = file_get_contents("php://input");
        $dataObject = json_decode($JSONData);

        // Verifica si $dataObject es un objeto JSON válido
        if (!is_object($dataObject)) {
            throw new \Exception('Formato de datos no válido. Se esperaba un objeto JSON.');
        }

        // Verifica campos obligatorios antes de crear la instancia de Producto
        $requiredFields = ['nombre_producto', 'descripcion', 'precio', 'existencia'];
        foreach ($requiredFields as $field) {
            if (empty($dataObject->$field)) {
                throw new \Exception("El campo $field es obligatorio.");
            }
        }

        // Crea una nueva instancia de Producto
        $prod = new Producto();
        $prod->nombre_producto = $dataObject->nombre_producto;
        $prod->descripcion = $dataObject->descripcion;
        $prod->precio = $dataObject->precio;
        $prod->existencia = $dataObject->existencia;
        $prod->categoria = $dataObject->categoria;
        $prod->imagen = NULL;
/*
        if (!property_exists($dataObject, 'imagen') || !is_array($dataObject->imagen)) {
            throw new \Exception('El campo de imagen no es un array válido.');
        }

        // Verificar cada imagen en el array
        foreach ($dataObject->imagen as $imagenObj) {
            // Verificar si la propiedad "imagen" existe en el objeto de imagen
            if (!property_exists($imagenObj, 'imagen')) {
                throw new \Exception('Falta la propiedad "imagen" en el objeto de imagen.');
            }

            $imagenBase64 = $imagenObj->imagen;

            // Eliminar el encabezado de la cadena base64
            $base64WithoutHeader = substr($imagenBase64, strpos($imagenBase64, ',') + 1);

            // Verificar errores en la decodificación de la cadena Base64
            $imagenData = base64_decode($base64WithoutHeader);

            // Usar finfo para obtener el tipo MIME
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime_type = finfo_buffer($finfo, $imagenData);

            echo 'Tipo MIME: ' . $mime_type . PHP_EOL;

            if ($mime_type === false) {
                throw new \Exception('No se pudo obtener información de la imagen.');
            }

            finfo_close($finfo);

            // Validar la extensión permitida
            // Validar la extensión permitida
            $extensionMap = [
                'image/jpeg' => 'jpg',
                'image/jpg'  => 'jpg',
                'image/png'  => 'png',
                'image/svg+xml' => 'svg',
            ];
            
            // Permitir application/octet-stream como tipo MIME válido
            if (!array_key_exists($mime_type, $extensionMap) && $mime_type !== 'application/octet-stream') {
                throw new \Exception('Formato de imagen no permitido. Tipo MIME: ' . $mime_type);
            }
            
            // Obtener la extensión del archivo
            $fileExtension = $extensionMap[$mime_type] ?? 'jpg';
            
            $nombreImagen = uniqid() . '.' . $fileExtension;
            
            $rutaImagen = '/var/www/html/Api/public/img/' . $nombreImagen;
            
            // Guardar la imagen en el servidor usando file_put_contents
            if (file_put_contents($rutaImagen, $imagenData) === false) {
                throw new \Exception('Error al guardar la imagen: ' . error_get_last()['message']);
            }
            
            $prod->imagen = $rutaImagen;
        }

*/
        // Asignar la ruta de la imagen al producto
        $proveedorId = $dataObject->proveedor;

        $proveedor = Proveedor::find($proveedorId);

        if (!$proveedor) {
            throw new \Exception('El proveedor proporcionado no es válido');
        }

        // Asignar la categoría al producto
        $prod->proveedor = $proveedor->id;

        // Guarda el producto
        $prod->save();

        // Envía una respuesta exitosa
        $response = new Success(['producto_id' => $prod->nombre_producto, 'mensaje' => 'Producto guardado exitosamente']);
        return $response->Send();
    } catch (\Exception $e) {
        // Captura cualquier excepción y envía una respuesta de error
        $statusCode = ($e instanceof \InvalidArgumentException) ? 400 : 500;
        $response = new Failure($statusCode, $e->getMessage());
        return $response->Send();
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

public function direcciones()
{
    try {
        $productos = Table::query("SELECT nombre,RFC,concat(direcciones.calle,' ',direcciones.numero, ' ', direcciones.colonia, ' ' ,
        direcciones.codigo_postal) as direccion FROM direcciones
        inner join direccion_user on direcciones.id = direccion_user.id_direccion");
        $productos = new Success($productos);
        $productos->Send();
        return $productos;
    } catch (\Exception $e) {
        $s = new Failure(401, $e->getMessage());
        return $s->Send();
    }
}


}


?>
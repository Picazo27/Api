<?php

namespace proyecto\Models;


use PDO;
use proyecto\Auth;
use proyecto\Response\Failure;
use proyecto\Response\Response;
use proyecto\Response\Success;
use function json_encode;
use proyecto\Response\Conexion;

class User extends Models
{

    public $user = "";
    public $contrasena = "";
    public $nombre = "";
    public $apellido_p = "";
    public $apellido_m = "";
    public $telefono = "";
    public $id = "";

    /**
     * @var array
     */
    protected $filleable = [
        "nombre",
        "apellido_p",
        "apellido_m",
        "contrasena",
        "user",
        "telefono"
    ];
    protected    $table = "users";



    public static function auth($user, $contrasena):Response
    {
        $class = get_called_class();
        $c = new $class();
        $stmt = self::$pdo->prepare("select *  from $c->table  where  user =:user  and contrasena=:contrasena");
        $stmt->bindParam(":user", $user);
        $stmt->bindParam(":contrasena", $contrasena);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_CLASS,User::class);

        if ($resultados) {
//            Auth::setUser($resultados[0]);  pendiente
            $r=new Success(["usuario"=>$resultados[0],"_token"=>Auth::generateToken([$resultados[0]->id])]);
           return  $r->Send();
        }
        $r=new Failure(401,"Usuario o contraseña incorrectos");
        return $r->Send();

    }
    

    public function find_name($name)
    {
        $stmt = self::$pdo->prepare("select *  from $this->table  where  nombre=:name");
        $stmt->bindParam(":name", $name);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_OBJ);
        if ($resultados == null) {
            return json_encode([]);
        }
        return json_encode($resultados[0]);
    }

    public  function reportecitas(){
        $JSONData = file_get_contents("php://input");
        $dataObject = json_decode($JSONData);

        $name=$dataObject->name;
        $d=Table::query("select * from users  where name='".$name."'");
        $r=new Success($d);

    }
    public static function obtenerPerfil($usuarioId): Response
    {
        try {
            $conexion = new Conexion('gimnasioda','localhost','root','');
            $stmt = $conexion->getPDO()->prepare("SELECT * FROM users WHERE usuario_id = :usuario_id");
            $stmt->bindParam(":usuario_id", $usuarioId);
            $stmt->execute();
            $perfil = $stmt->fetch(PDO::FETCH_OBJ);

            if ($perfil) {
                $respuesta = new Success($perfil);
                return $respuesta->Send();
            } else {
                throw new \Exception('No se encontró el perfil del usuario');
            }
        } catch (\Exception $e) {
            $error = new Failure(401, $e->getMessage());
            return $error->Send();
        }
    }

    public static function actualizarPerfil($usuarioId, $nuevosDatos): Response
    {
        try {
            $conexion = new Conexion('gimnasioda','localhost','root','');
            $stmt = $conexion->getPDO()->prepare("UPDATE users SET nombre = :nombre, apellido_paterno = :apellido_paterno WHERE usuario_id = :usuario_id");
            $stmt->bindParam(":nombre", $nuevosDatos['nombre']);
            $stmt->bindParam(":apellido_paterno", $nuevosDatos['apellido_paterno']);
            $stmt->bindParam(":usuario_id", $usuarioId);
            $stmt->execute();

            $respuesta = new Success('Perfil actualizado correctamente');
            return $respuesta->Send();
        } catch (\Exception $e) {
            $error = new Failure(401, $e->getMessage());
            return $error->Send();
        }
    }
}



<?php

namespace proyecto\Controller;

use proyecto\Models\Producto;
use proyecto\Models\Proveedor;
use proyecto\Models\categoria;
use proyecto\Models\Table;
use proyecto\Response\Success;
use proyecto\Response\Failure;
use proyecto\Models\User;
use proyecto\Models\Empleado;
use proyecto\Conexion;
use proyecto\Models\orden_venta;

class UserController
{

 /*   public function ingresarpedido()
    {
        try{

            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $pedidos = new orden_venta();
            $pedidos->fecha_realizado_pedido = $fechaActual;
            $pedidos->hora_realizado_pedido = $hora_actual;
            $pedidos->hora_entrega_pedido = $dataObject->hora_entrega_pedido;
            $pedidos->info_pedido = $dataObject->info_pedido;
            $pedidos->estado_pedido = "En proceso";
            $pedidos->op_pedido = $dataObject->op_pedido;
            $pedidos->id_empleado = 1;
            $pedidos->nombre_cliente_pedido = $dataObject->nombre_cliente_pedido;
            $pedidos->total_pedido = $dataObject->total_pedido;
            $pedidos->save();

            $detalle_pedido = new detalle_pedido();
            $detalle_pedido->cantidad_producto = $dataObject->cantidad_producto;
            $detalle_pedido->precio_unitario = $dataObject->precio_unitario;
            $detalle_pedido->nombre_producto = $dataObject->nombre_producto;
            $detalle_pedido->id_producto = $dataObject->id_producto;
            $detalle_pedido->subtotal_pedido = $dataObject->subtotal_pedido;
            $detalle_pedido->id_pedido = $pedidos->id;
            $detalle_pedido->tipo_pago_pedido = "Efectivo";
            $detalle_pedido->save();

            $detalles_pedido_tipo_cafe = new detalle_pedido_tipo_cafe();
            $detalles_pedido_tipo_cafe->nom_cafe = $dataObject->nom_cafe;
            $detalles_pedido_tipo_cafe->id_detalle_pedido = $detalle_pedido->id;
            $detalles_pedido_tipo_cafe->id_tipo_cafe = $dataObject->id_tipo_cafe;
            $detalles_pedido_tipo_cafe->save();

            $detalles_pedido_pe = new detalle_pedido_pe();
            $detalles_pedido_pe->precio_pe = $dataObject->precio_pe;
            $detalles_pedido_pe->id_detalle_pedido = $detalle_pedido->id;
            $detalles_pedido_pe->id_producto_extra = $dataObject->id_producto_extra;
            $detalles_pedido_pe->save();

            $respone = array(
                'pedido' => $pedidos,
                'detalle_pedido' => $detalle_pedido,
                'detalles_pedido_tipo_cafe' => $detalles_pedido_tipo_cafe,
                'detalles_pedido' => $detalles_pedido_pe,
            );

            $r = new Success($respone);
            return $r->Send();
        } catch (\Exception $e) {
            $s = new Failure(401, $e->getMessage());
            return $s->Send();
        }
    }

    */

}

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
use proyecto\Models\detalle_orden_venta;
use proyecto\Models\detalle_orden_compra;
use proyecto\Models\orden_compra;

class VentaController
{

   public function ordenventa()
    {
        try{

            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $pedidos = new orden_venta();
            $pedidos->forma_pago = $dataObject->forma_pago;
            $pedidos->estatus = "en espera";
            $pedidos->cliente= $dataObject->cliente;
            $pedidos->save();

            $detalle_pedido = new detalle_orden_venta();
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

    public function ordencompra()
{
    try{

        $JSONData = file_get_contents("php://input");
        $dataObject = json_decode($JSONData);
        $proveedorId = $dataObject->proveedor;

        $compra = new orden_compra();
        $proveedor = Proveedor::find($proveedorId);

        if (!$proveedor) {
            throw new \Exception('El proveedor proporcionado no es válido');
        }
        $compra->proveedor = $proveedor->id;
        $compra->save();

        $detalle_compra = new detalle_orden_compra();
        $detalle_compra->orden = $compra->id;
        $detalle_compra->producto = $dataObject->producto;
        $detalle_compra->cantidad = $dataObject->cantidad;
        $detalle_compra->precio = $dataObject->precio;
        $detalle_compra->save();
       
        $respone = array(
            'compra' => $compra,
            'detalle_compra' => $detalle_compra
        );

        $r = new Success($respone);
        return $r->Send();
    } catch (\Exception $e) {
        $s = new Failure(401, $e->getMessage());
        return $s->Send();
    }
}


}

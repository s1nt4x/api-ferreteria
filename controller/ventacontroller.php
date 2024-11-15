<?php

class VentaController
{
    private $model;

    public function __construct($db)
    {
        require_once 'model/ventamodel.php';
        $this->model = new VentaModel($db);
    }

    public function listarVentas()
    {
        $datos = json_decode(file_get_contents("php://input"), true);
        $finicio = $datos['finicio'] ?? null;
        $ffin = $datos['ffin'] ?? null;

        if ($finicio && $ffin) {
            $ventas = $this->model->getVentas($finicio, $ffin);
            echo json_encode(['data' => $ventas]);
        } else {
            echo json_encode(['message' => 'Faltan datos requeridos']);
        }
    }


    public function crearVenta()
    {
        $datos = json_decode(file_get_contents("php://input"), true);

        if (isset($datos['idcliente'], $datos['idusuario'], $datos['tipo'], $datos['serie'], $datos['ncomprobante'], $datos['total'], $datos['impuesto'], $datos['porcentaje'])) {
            $idcliente = $datos['idcliente'];
            $idusuario = $datos['idusuario'];
            $tipo = $datos['tipo'];
            $serie = $datos['serie'];
            $ncomprobante = $datos['ncomprobante'];
            $total = $datos['total'];
            $impuesto = $datos['impuesto'];
            $porcentaje = $datos['porcentaje'];

            $resultado = $this->model->registrarVenta($idcliente, $idusuario, $tipo, $serie, $ncomprobante, $total, $impuesto, $porcentaje);

            if ($resultado) {
                echo json_encode(['message' => 'Venta registrada correctamente', 'id' => $resultado]);
            } else {
                echo json_encode(['message' => 'Error al registrar venta']);
            }
        } else {
            echo json_encode(['message' => 'Faltan parámetros']);
        }
    }

    public function anularVenta()
    {
        $datos = json_decode(file_get_contents("php://input"), true);
        $idventa = $datos['idventa'] ?? null;

        if ($idventa) {
            $result = $this->model->anularVenta($idventa);
            if ($result) {
                echo json_encode(['message' => 'Venta anulada correctamente']);
            } else {
                echo json_encode(['message' => 'Error al anular venta']);
            }
        } else {
            echo json_encode(['message' => 'Faltan datos requeridos']);
        }
    }

    public function listarComboCliente()
    {
        $clientes = $this->model->listarComboCliente();
        echo json_encode(['data' => $clientes]);
    }

    public function listarComboProducto()
    {
        $productos = $this->model->listarComboProducto();
        echo json_encode(['data' => $productos]);
    }

    public function numVentas()
    {
        $ventas = $this->model->numVentas();
        echo json_encode(['data' => $ventas]);
    }

    public function registrarVentaDetalle()
    {

        $datos = json_decode(file_get_contents("php://input"), true);

        if (isset($datos['id'], $datos['array_producto'], $datos['array_cantidad'], $datos['array_precio'])) {

            $id = $datos['id'];
            $array_producto = $datos['array_producto'];
            $array_cantidad = $datos['array_cantidad'];
            $array_precio = $datos['array_precio'];
            $result = $this->model->registrarVentaDetalle($id, $array_producto, $array_cantidad, $array_precio);

            if ($result) {
                echo json_encode(['message' => 'Detalles de venta registrados correctamente']);
            } else {
                echo json_encode(['message' => 'Error al registrar detalles de venta']);
            }
        } else {
            echo json_encode(['message' => 'Faltan datos requeridos']);
        }
    }
}

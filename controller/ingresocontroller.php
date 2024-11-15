<?php

class IngresoController
{
    private $model;

    public function __construct($db)
    {
        require_once 'model/ingresomodel.php';
        $this->model = new IngresoModel($db);
    }

    public function listarIngresos()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!empty($data['finicio']) && !empty($data['ffin'])) {
            $result = $this->model->getIngresos($data['finicio'], $data['ffin']);

            if ($result) {
                echo json_encode([
                    'message' => 'obtenidos correctamente',
                    'data' => $result
                ]);
            } else {
                echo json_encode(['message' => 'No se encontraron ingresos en el rango de fechas']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Faltan datos requeridos']);
        }
    }

    public function crearIngreso()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!empty($data['idproveedor']) && !empty($data['idusuario']) && !empty($data['tipo']) && !empty($data['serie']) && !empty($data['ncomprobante']) && !empty($data['total']) && !empty($data['impuesto']) && !empty($data['porcentaje'])) {

            $result = $this->model->crearIngreso(
                $data['idproveedor'],
                $data['idusuario'],
                $data['tipo'],
                $data['serie'],
                $data['ncomprobante'],
                $data['total'],
                $data['impuesto'],
                $data['porcentaje']
            );

            if ($result) {
                echo json_encode(['message' => 'Ingreso registrado correctamente', 'id_ingreso' => $result]);
            } else {
                echo json_encode(['message' => 'Error al registrar ingreso']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Faltan datos requeridos']);
        }
    }

    public function anularIngreso()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!empty($data['idingreso'])) {
            $result = $this->model->anularIngreso($data['idingreso']);

            if ($result) {
                echo json_encode(['message' => 'Ingreso anulado correctamente']);
            } else {
                echo json_encode(['message' => 'Error al anular ingreso']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Faltan datos requeridos']);
        }
    }

    public function listarComboProveedor()
    {
        $result = $this->model->listarComboProveedor();

        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(['message' => 'Error al listar proveedores']);
        }
    }

    public function listarComboProducto()
    {
        $result = $this->model->listarComboProducto();

        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode(['message' => 'Error al listar productos']);
        }
    }

    public function registrarIngresoDetalle()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!empty($data['id']) && !empty($data['array_producto']) && !empty($data['array_cantidad']) && !empty($data['array_precio'])) {

            $result = $this->model->registrarIngresoDetalle(
                $data['id'],
                $data['array_producto'],
                $data['array_cantidad'],
                $data['array_precio']
            );

            if ($result) {
                echo json_encode(['message' => 'Detalles del ingreso registrados correctamente']);
            } else {
                echo json_encode(['message' => 'Error al registrar detalles del ingreso']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Faltan datos requeridos']);
        }
    }
}

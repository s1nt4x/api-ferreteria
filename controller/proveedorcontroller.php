<?php
class ProveedorController
{
    private $model;

    public function __construct($db)
    {
        require_once 'model/proveedormodel.php';
        $this->model = new ProveedorModel($db);
    }

    public function getProveedores()
    {
        $result = $this->model->getProveedores();
        echo json_encode([
            'message' => 'Proveedores obtenidos correctamente',
            'data' => $result
        ]);
    }

    public function crearProveedor()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (
            !empty($data['nombre']) && !empty($data['apepat']) && !empty($data['apemat']) &&
            !empty($data['ndocumento']) && !empty($data['tdocumento']) &&
            !empty($data['sexo']) && !empty($data['telefono']) &&
            !empty($data['razonsocial']) && !empty($data['nomcontacto']) &&
            !empty($data['numcontacto'])
        ) {

            $result = $this->model->crearProveedores(
                $data['nombre'],
                $data['apepat'],
                $data['apemat'],
                $data['ndocumento'],
                $data['tdocumento'],
                $data['sexo'],
                $data['telefono'],
                $data['razonsocial'],
                $data['nomcontacto'],
                $data['numcontacto']
            );

            if ($result) {
                echo json_encode(['message' => 'Proveedor creado correctamente']);
            } else {
                echo json_encode(['message' => 'Error al crear proveedor']);
            }
        } else {
            echo json_encode(['message' => 'Faltan datos requeridos']);
        }
    }

    public function editarProveedor()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (
            !empty($data['idproveedor']) && !empty($data['razonsocial']) &&
            !empty($data['nomcontacto']) && !empty($data['numcontacto'])
        ) {

            $result = $this->model->editarProveedor(
                $data['idproveedor'],
                $data['razonsocial'],
                $data['nomcontacto'],
                $data['numcontacto']
            );

            if ($result) {
                echo json_encode(['message' => 'Proveedor editado correctamente']);
            } else {
                echo json_encode(['message' => 'Error al editar proveedor']);
            }
        } else {
            echo json_encode(['message' => 'Faltan datos requeridos']);
        }
    }

    public function modificarEstatusProveedor()
    {
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data->idproveedor) && !empty($data->estatus)) {
            $response = $this->model->modificarEstatusProveedor($data->idproveedor, $data->estatus);
            if ($response) {
                echo json_encode([
                    'message' => 'Estatus del proveedor modificado correctamente'
                ]);
            } else {
                echo json_encode([
                    'message' => 'Error al modificar el estatus del proveedor'
                ]);
            }
        } else {
            echo json_encode([
                'message' => 'Datos incompletos'
            ]);
        }
    }
}

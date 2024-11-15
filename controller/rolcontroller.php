<?php

class RolController
{
    private $model;

    public function __construct($db)
    {
        require_once 'model/rolmodel.php';
        $this->model = new RolModel($db);
    }
    public function getRoles()
    {
        $result = $this->model->getRoles();
        echo json_encode([
            'message' => 'Roles obtenidos correctamente',
            'data' => $result
        ]);
    }

    public function crearRol()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!empty($data['rol'])) {
            $result = $this->model->crearRol($data['rol']);

            if ($result) {
                echo json_encode(['message' => 'Rol creado correctamente']);
            } else {
                echo json_encode(['message' => 'Error al crear rol']);
            }
        } else {
            echo json_encode(['message' => 'Faltan datos requeridos']);
        }
    }

    public function editarRol()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!empty($data['id']) && !empty($data['rolactual']) && !empty($data['rolnuevo']) && isset($data['estatus'])) {
            $result = $this->model->editarRol(
                $data['id'],
                $data['rolactual'],
                $data['rolnuevo'],
                $data['estatus']
            );

            if ($result) {
                echo json_encode(['message' => 'Rol editado correctamente']);
            } else {
                echo json_encode(['message' => 'Error al editar rol']);
            }
        } else {
            echo json_encode(['message' => 'Faltan datos requeridos']);
        }
    }
}

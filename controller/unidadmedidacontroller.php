<?php

class UnidadMedidaController
{
    private $model;

    public function __construct($db)
    {
        require_once 'model/unidadmedidamodel.php';
        $this->model = new UnidadMedidaModel($db);
    }

    public function getUnidadesMedida()
    {
        $unidades = $this->model->getUnidadesMedida();
        echo json_encode($unidades);
    }

    public function crearUnidadMedida()
    {
        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->unidad) && !empty($data->abreviatura)) {
            $result = $this->model->crearUnidadMedida($data->unidad, $data->abreviatura);

            if ($result) {
                echo json_encode(['message' => 'Unidad de medida creada correctamente']);
            } else {
                echo json_encode(['message' => 'Error al crear unidad de medida']);
            }
        } else {
            echo json_encode(['message' => 'Faltan datos requeridos']);
        }
    }

    public function editarUnidadMedida()
    {
        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->id) && !empty($data->unidadactual) && !empty($data->unidadnueva) && !empty($data->abreviaturaeditar) && isset($data->estatus)) {
            $result = $this->model->editarUnidadMedida($data->id, $data->unidadactual, $data->unidadnueva, $data->abreviaturaeditar, $data->estatus);

            if ($result) {
                echo json_encode(['message' => 'Unidad de medida modificada correctamente']);
            } else {
                echo json_encode(['message' => 'Error al modificar unidad de medida']);
            }
        } else {
            echo json_encode(['message' => 'Faltan datos requeridos']);
        }
    }
}

<?php
class CategoriaController
{
    private $model;

    public function __construct($db)
    {
        require_once 'model/categoriamodel.php';
        $this->model = new CategoriaModel($db);
    }

    public function getCategorias()
    {
        $result = $this->model->getCategorias();
        echo json_encode([
            'message' => 'Categorías obtenidas correctamente',
            'data' => $result
        ]);
    }

    public function crearCategoria()
    {
        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->categoria_nombre)) {
            $response = $this->model->crearCategoria($data->categoria_nombre);
            if ($response == 1) {
                echo json_encode([
                    'message' => 'Categoría creada correctamente'
                ]);
            } elseif ($response == 2) {
                echo json_encode([
                    'message' => 'La categoría ya existe'
                ]);
            } else {
                echo json_encode([
                    'message' => 'Error al crear la categoría'
                ]);
            }
        } else {
            echo json_encode([
                'message' => 'Datos incompletos'
            ]);
        }
    }

    public function editarCategoria()
    {
        $data = json_decode(file_get_contents("php://input"));
        if (
            !empty($data->id) && !empty($data->categoria_actual)
            && !empty($data->categoria_nueva) && !empty($data->categoria_estatus)
        ) {
            $response = $this->model->editarCategoria($data->id, $data->categoria_actual, $data->categoria_nueva, $data->categoria_estatus);
            if ($response) {
                echo json_encode([
                    'message' => 'Categoría modificada correctamente'
                ]);
            } else {
                echo json_encode([
                    'message' => 'Error al modificar la categoría'
                ]);
            }
        } else {
            echo json_encode([
                'message' => 'Datos incompletos'
            ]);
        }
    }

    public function eliminarCategoria()
    {
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data->id)) {
            $response = $this->model->eliminarCategoria($data->id);
            if ($response) {
                echo json_encode([
                    'message' => 'Categoría eliminada correctamente'
                ]);
            } else {
                echo json_encode([
                    'message' => 'Error al eliminar la categoría'
                ]);
            }
        } else {
            echo json_encode([
                'message' => 'ID de categoría no proporcionado'
            ]);
        }
    }
}

<?php
class ProductoController
{
    private $model;

    public function __construct($db)
    {
        require_once 'model/productomodel.php';
        $this->model = new ProductoModel($db);
    }

    public function getProductos()
    {
        $result = $this->model->getProductos();
        if ($result) {
            echo json_encode([
                'message' => 'Productos obtenidos correctamente',
                'data' => $result
            ]);
        } else {
            echo json_encode([
                'message' => 'No se encontraron productos'
            ]);
        }
    }

    public function crearProducto()
    {
        $data = json_decode(file_get_contents("php://input"));
        if (
            !empty($data->producto) && !empty($data->presentacion) &&
            !empty($data->categoria) && !empty($data->unidad) &&
            !empty($data->precio) && !empty($data->ruta)
        ) {
            $response = $this->model->crearProductos(
                $data->producto,
                $data->presentacion,
                $data->categoria,
                $data->unidad,
                $data->precio,
                $data->ruta
            );

            if ($response) {
                echo json_encode([
                    'message' => 'Producto creado correctamente'
                ]);
            } else {
                echo json_encode([
                    'message' => 'Error al crear el producto'
                ]);
            }
        } else {
            echo json_encode([
                'message' => 'Datos incompletos'
            ]);
        }
    }

    public function editarFotoProducto()
    {
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data->id) && !empty($data->ruta)) {
            $response = $this->model->editarFotoProducto($data->id, $data->ruta);
            if ($response) {
                echo json_encode([
                    'message' => 'Foto del producto actualizada correctamente'
                ]);
            } else {
                echo json_encode([
                    'message' => 'Error al actualizar la foto del producto'
                ]);
            }
        } else {
            echo json_encode([
                'message' => 'Datos incompletos'
            ]);
        }
    }

    public function getComboCategoria()
    {
        $result = $this->model->listar_combo_categoria();
        if ($result) {
            echo json_encode([
                'message' => 'Categorías obtenidas correctamente',
                'data' => $result
            ]);
        } else {
            echo json_encode([
                'message' => 'No se encontraron categorías'
            ]);
        }
    }

    public function getComboUnidad()
    {
        $result = $this->model->listar_combo_unidad();
        if ($result) {
            echo json_encode([
                'message' => 'Unidades obtenidas correctamente',
                'data' => $result
            ]);
        } else {
            echo json_encode([
                'message' => 'No se encontraron unidades'
            ]);
        }
    }
}

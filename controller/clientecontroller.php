<?php
class ClienteController
{
    private $model;

    public function __construct($db)
    {
        require_once 'model/clientemodel.php';
        $this->model = new ClienteModel($db);
    }

    public function getClientes()
    {
        $result = $this->model->getClientes();
        echo json_encode([
            'message' => 'Clientes obtenidos correctamente',
            'data' => $result
        ]);
    }

    public function crearCliente()
    {
        $data = json_decode(file_get_contents("php://input"));

        if (
            !empty($data->nombre) && !empty($data->apepat)
            && !empty($data->apemat) && !empty($data->ndocumento)
            && !empty($data->tdocumento) && !empty($data->sexo) && !empty($data->telefono)
        ) {
            $response = $this->model->crearCliente(
                $data->nombre,
                $data->apepat,
                $data->apemat,
                $data->ndocumento,
                $data->tdocumento,
                $data->sexo,
                $data->telefono
            );

            if ($response) {
                echo json_encode([
                    'message' => 'Cliente creado correctamente'
                ]);
            } else {
                echo json_encode([
                    'message' => 'Error al crear el cliente'
                ]);
            }
        } else {
            echo json_encode([
                'message' => 'Datos incompletos'
            ]);
        }
    }

    public function editarCliente()
    {
        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->idcliente) && !empty($data->estatus)) {
            $response = $this->model->editarCliente($data->idcliente, $data->estatus);

            if ($response) {
                echo json_encode([
                    'message' => 'Cliente actualizado correctamente'
                ]);
            } else {
                echo json_encode([
                    'message' => 'Error al actualizar el cliente'
                ]);
            }
        } else {
            echo json_encode([
                'message' => 'Datos incompletos'
            ]);
        }
    }
}

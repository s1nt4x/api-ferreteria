<?php
class PersonaController
{
    private $model;

    public function __construct($db)
    {
        require_once 'model/personamodel.php';
        $this->model = new PersonaModel($db);
    }

    public function getPersonas()
    {
        $result = $this->model->getPersonas();
        echo json_encode([
            'message' => 'Personas obtenidas correctamente',
            'data' => $result
        ]);
    }

    public function crearPersona()
    {
        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->nombre) && !empty($data->apepat) && !empty($data->apemat) && !empty($data->ndocumento) && !empty($data->tdocumento) && !empty($data->sexo) && !empty($data->telefono)) {
            $response = $this->model->crearPersona(
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
                    'message' => 'Persona creada correctamente'
                ]);
            } else {
                echo json_encode([
                    'message' => 'Error al crear la persona'
                ]);
            }
        } else {
            echo json_encode([
                'message' => 'Datos incompletos'
            ]);
        }
    }

    public function editarPersona()
    {
        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->id) && !empty($data->nombre) && !empty($data->apepat) && !empty($data->apemat) && !empty($data->ndocumentoactual) && !empty($data->ndocumentonuevo) && !empty($data->tdocumento) && !empty($data->sexo) && !empty($data->telefono) && !empty($data->estatus)) {
            $response = $this->model->editarPersona(
                $data->id,
                $data->nombre,
                $data->apepat,
                $data->apemat,
                $data->ndocumentoactual,
                $data->ndocumentonuevo,
                $data->tdocumento,
                $data->sexo,
                $data->telefono,
                $data->estatus
            );

            if ($response) {
                echo json_encode([
                    'message' => 'Persona actualizada correctamente'
                ]);
            } else {
                echo json_encode([
                    'message' => 'Error al actualizar la persona'
                ]);
            }
        } else {
            echo json_encode([
                'message' => 'Datos incompletos'
            ]);
        }
    }
}

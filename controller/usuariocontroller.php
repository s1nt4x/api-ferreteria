<?php
class UsuarioController
{
    private $model;

    public function __construct($db)
    {
        require_once 'model/usuariomodel.php';
        $this->model = new UsuarioModel($db);
    }

    public function verificarUsuario()
    {
        $data = json_decode(file_get_contents("php://input"));

        if (isset($data->usuario) && isset($data->password)) {
            $usuario = $data->usuario;
            $password = $data->password;

            $resultado = $this->model->verificarUsuario($usuario, $password);
            if (!empty($resultado)) {
                echo json_encode(["message" => "Usuario verificado", "data" => $resultado]);
            } else {
                echo json_encode(["message" => "Usuario o contraseña incorrectos"]);
            }
        } else {
            echo json_encode(["message" => "Datos incompletos"]);
        }
    }

    public function getUsuarios()
    {
        $usuarios = $this->model->getUsuarios();
        echo json_encode(['data' => $usuarios]);
    }

    public function listarComboPersona()
    {
        $personas = $this->model->listarComboPersona();
        echo json_encode(['data' => $personas]);
    }

    public function listarComboRol()
    {
        $roles = $this->model->listarComboRol();
        echo json_encode(['data' => $roles]);
    }

    public function crearUsuario()
    {
        $datos = json_decode(file_get_contents("php://input"), true);

        if (isset($datos['usuario'], $datos['password'], $datos['idpersona'], $datos['email'], $datos['idrol'], $datos['ruta'])) {
            $usuario = $datos['usuario'];
            $password = password_hash($datos['password'], PASSWORD_BCRYPT);
            $idpersona = $datos['idpersona'];
            $email = $datos['email'];
            $idrol = $datos['idrol'];
            $ruta = $datos['ruta'];

            $resultado = $this->model->crearUsuario($usuario, $password, $idpersona, $email, $idrol, $ruta);

            if ($resultado) {
                echo json_encode(['message' => 'Usuario registrado']);
            } else {
                echo json_encode(['message' => 'Error al registrar usuario']);
            }
        } else {
            echo json_encode(['message' => 'Faltan parámetros']);
        }
    }

    public function editarUsuario()
    {
        $datos = json_decode(file_get_contents("php://input"), true);

        if (isset($datos['id'], $datos['idpersona'], $datos['emailnuevo'], $datos['idrol'], $datos['estatus'])) {
            $id = $datos['id'];
            $idpersona = $datos['idpersona'];
            $emailnuevo = $datos['emailnuevo'];
            $idrol = $datos['idrol'];
            $estatus = $datos['estatus'];

            $resultado = $this->model->editarUsuario($id, $idpersona, $emailnuevo, $idrol, $estatus);

            if ($resultado) {
                echo json_encode(['message' => 'Usuario editado']);
            } else {
                echo json_encode(['message' => 'Error al editar usuario']);
            }
        } else {
            echo json_encode(['message' => 'Faltan parámetros']);
        }
    }

    public function editarFoto()
    {
        $datos = json_decode(file_get_contents("php://input"), true);

        if (isset($datos['id'], $datos['ruta'])) {
            $id = $datos['id'];
            $ruta = $datos['ruta'];

            $resultado = $this->model->editarFoto($id, $ruta);

            if ($resultado) {
                echo json_encode(['message' => 'Foto actualizada']);
            } else {
                echo json_encode(['message' => 'Error al actualizar foto']);
            }
        } else {
            echo json_encode(['message' => 'Faltan parámetros']);
        }
    }

    public function traerDatosUsuario()
    {
        $datos = json_decode(file_get_contents("php://input"), true);

        if (isset($datos['id'])) {
            $id = $datos['id'];
            $resultado = $this->model->traerDatosUsuario($id);

            if ($resultado) {
                echo json_encode(['data' => $resultado]);
            } else {
                echo json_encode(['message' => 'Usuario no encontrado']);
            }
        } else {
            echo json_encode(['message' => 'Faltan parámetros']);
        }
    }

    public function traerDatosWidget()
    {
        $datos = json_decode(file_get_contents("php://input"), true);

        if (isset($datos['inicio'], $datos['fin'])) {
            $inicio = $datos['inicio'];
            $fin = $datos['fin'];

            $resultado = $this->model->traerDatosWidget($inicio, $fin);
            echo json_encode(['data' => $resultado]);
        } else {
            echo json_encode(['message' => 'Faltan parámetros']);
        }
    }

    public function traerDatosGraficoVentaWidget()
    {
        $datos = json_decode(file_get_contents("php://input"), true);

        if (isset($datos['inicio'], $datos['fin'])) {
            $inicio = $datos['inicio'];
            $fin = $datos['fin'];

            $resultado = $this->model->traerDatosGraficoVentaWidget($inicio, $fin);
            echo json_encode(['data' => $resultado]);
        } else {
            echo json_encode(['message' => 'Faltan parámetros']);
        }
    }

    public function traerDatosGraficoIngresoWidget()
    {
        $datos = json_decode(file_get_contents("php://input"), true);

        if (isset($datos['inicio'], $datos['fin'])) {
            $inicio = $datos['inicio'];
            $fin = $datos['fin'];

            $resultado = $this->model->traerDatosGraficoIngresoWidget($inicio, $fin);
            echo json_encode(['data' => $resultado]);
        } else {
            echo json_encode(['message' => 'Faltan parámetros']);
        }
    }

    public function actualizarDatosProfile()
    {
        $datos = json_decode(file_get_contents("php://input"), true);

        if (isset($datos['id'], $datos['nombre'], $datos['apepat'], $datos['apemat'], $datos['ndocumento'], $datos['tdocumento'], $datos['sexo'], $datos['telefono'])) {
            $id = $datos['id'];
            $nombre = $datos['nombre'];
            $apepat = $datos['apepat'];
            $apemat = $datos['apemat'];
            $ndocumento = $datos['ndocumento'];
            $tdocumento = $datos['tdocumento'];
            $sexo = $datos['sexo'];
            $telefono = $datos['telefono'];

            $resultado = $this->model->actualizarDatosProfile($id, $nombre, $apepat, $apemat, $ndocumento, $tdocumento, $sexo, $telefono);

            if ($resultado) {
                echo json_encode(['message' => 'Datos del perfil actualizados']);
            } else {
                echo json_encode(['message' => 'Error al actualizar datos']);
            }
        } else {
            echo json_encode(['message' => 'Faltan parámetros']);
        }
    }

    public function actualizarContra()
    {
        $datos = json_decode(file_get_contents("php://input"), true);

        if (isset($datos['id'], $datos['contranueva'])) {
            $id = $datos['id'];
            $contranueva = password_hash($datos['contranueva'], PASSWORD_BCRYPT);

            $resultado = $this->model->actualizarContra($id, $contranueva);

            if ($resultado) {
                echo json_encode(['message' => 'Contraseña actualizada']);
            } else {
                echo json_encode(['message' => 'Error al actualizar contraseña']);
            }
        } else {
            echo json_encode(['message' => 'Faltan parámetros']);
        }
    }
}

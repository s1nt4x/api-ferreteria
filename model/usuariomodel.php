<?php
class UsuarioModel
{
    private $conn;
    private $table_name = "usuario";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function verificarUsuario($usuario, $password)
    {
        $query = "CALL SP_VERIFICAR_USUARIO(:usuario)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultado && password_verify($password, $resultado['usuario_password'])) {
            return $resultado;
        }
        return false;
    }

    public function getUsuarios()
    {
        $query = "CALL SP_LISTAR_USUARIO()";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarComboPersona()
    {
        $query = "CALL SP_LISTAR_COMBO_PERSONA()";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarComboRol()
    {
        $query = "CALL SP_LISTAR_COMBO_ROL()";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crearUsuario($usuario, $pass, $idpersona, $email, $idrol, $ruta)
    {
        $query = "CALL SP_REGISTRAR_USUARIO(:usuario, :pass, :idpersona, :email, :idrol, :ruta)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':pass', $pass);
        $stmt->bindParam(':idpersona', $idpersona);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':idrol', $idrol);
        $stmt->bindParam(':ruta', $ruta);
        $stmt->execute();

        return $stmt->fetchColumn();
    }

    public function editarUsuario($id, $idpersona, $emailnuevo, $idrol, $estatus)
    {
        $query = "CALL SP_MODIFICAR_USUARIO(:id, :idpersona, :emailnuevo, :idrol, :estatus)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':idpersona', $idpersona);
        $stmt->bindParam(':emailnuevo', $emailnuevo);
        $stmt->bindParam(':idrol', $idrol);
        $stmt->bindParam(':estatus', $estatus);
        $stmt->execute();

        return $stmt->fetchColumn();
    }

    public function editarFoto($id, $ruta)
    {
        $query = "CALL SP_MODIFICAR_USUARIO_FOTO(:id, :ruta)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':ruta', $ruta);
        $stmt->execute();

        return $stmt->fetchColumn();
    }

    public function traerDatosUsuario($id)
    {
        $query = "CALL SP_TRAER_DATOS_USUARIO(:id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function traerDatosWidget($inicio, $fin)
    {
        $query = "CALL SP_TRAER_DATOS_WIDGET(:inicio, :fin)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':inicio', $inicio);
        $stmt->bindParam(':fin', $fin);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function traerDatosGraficoVentaWidget($inicio, $fin)
    {
        $query = "CALL SP_TRAER_DATOS_GRAFICO_VENTA_WIDGET(:inicio, :fin)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':inicio', $inicio);
        $stmt->bindParam(':fin', $fin);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function traerDatosGraficoIngresoWidget($inicio, $fin)
    {
        $query = "CALL SP_TRAER_DATOS_GRAFICO_INGRESO_WIDGET(:inicio, :fin)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':inicio', $inicio);
        $stmt->bindParam(':fin', $fin);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function actualizarDatosProfile($id, $nombre, $apepat, $apemat, $ndocumento, $tdocumento, $sexo, $telefono)
    {
        $query = "CALL SP_ACTUALIZAR_DATOS_PERSONA_PROFILE(:id, :nombre, :apepat, :apemat, :ndocumento, :tdocumento, :sexo, :telefono)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apepat', $apepat);
        $stmt->bindParam(':apemat', $apemat);
        $stmt->bindParam(':ndocumento', $ndocumento);
        $stmt->bindParam(':tdocumento', $tdocumento);
        $stmt->bindParam(':sexo', $sexo);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->execute();

        return $stmt->fetchColumn();
    }

    public function actualizarContra($id, $contranueva)
    {
        $query = "CALL SP_ACTUALIZAR_CONTRA_USUARIO(:id, :contranueva)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':contranueva', $contranueva);
        $stmt->execute();

        return ($stmt->rowCount() > 0);
    }
}

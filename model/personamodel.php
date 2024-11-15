<?php

class PersonaModel
{
  private $conn;
  private $table_name = "persona";

  public function __construct($db)
  {
    $this->conn = $db;
  }

  public function getPersonas()
  {
    $query = "call SP_LISTAR_PERSONA()";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function crearPersona($nombre, $apepat, $apemat, $ndocumento, $tdocumento, $sexo, $telefono)
  {
    $query = "call SP_REGISTRAR_PERSONA('$nombre','$apepat','$apemat','$ndocumento','$tdocumento','$sexo','$telefono')";
    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':apepat', $apepat);
    $stmt->bindParam(':apemat', $apemat);
    $stmt->bindParam(':ndocumento', $ndocumento);
    $stmt->bindParam(':tdocumento', $tdocumento);
    $stmt->bindParam(':sexo', $sexo);
    $stmt->bindParam(':telefono', $telefono);

    if ($stmt->execute()) {
      return $stmt->fetchColumn();
    }
    return false;
  }

  public function editarPersona($id, $nombre, $apepat, $apemat, $ndocumentoactual, $ndocumentonuevo, $tdocumento, $sexo, $telefono, $estatus)
  {
    $query = "CALL SP_EDITAR_PERSONA(:id, :nombre, :apepat, :apemat, :ndocumentoactual, :ndocumentonuevo, :tdocumento, :sexo, :telefono, :estatus)";

    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':apepat', $apepat);
    $stmt->bindParam(':apemat', $apemat);
    $stmt->bindParam(':ndocumentoactual', $ndocumentoactual);
    $stmt->bindParam(':ndocumentonuevo', $ndocumentonuevo);
    $stmt->bindParam(':tdocumento', $tdocumento);
    $stmt->bindParam(':sexo', $sexo);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':estatus', $estatus);

    if ($stmt->execute()) {
      return true;
    }
    return false;
  }
}

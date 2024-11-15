<?php

class ClienteModel
{
  private $conn;
  private $table_name = "cliente";

  public function __construct($db)
  {
    $this->conn = $db;
  }

  public function getClientes()
  {
    $query = "CALL SP_LISTAR_CLIENTE()";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function crearCliente($nombre, $apepat, $apemat, $ndocumento, $tdocumento, $sexo, $telefono)
  {
    $query = "CALL SP_REGISTRAR_CLIENTE(:nombre, :apepat, :apemat, :ndocumento, :tdocumento, :sexo, :telefono)";
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

  public function editarCliente($idcliente, $estatus)
  {
    $query = "call SP_MODIFICAR_ESTATUS_CLIENTE(:idcliente,:estatus)";

    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(':idcliente', $idcliente);
    $stmt->bindParam(':estatus', $estatus);

    if ($stmt->execute()) {
      return true;
    }
    return false;
  }
}

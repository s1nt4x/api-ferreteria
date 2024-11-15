<?php

class ProveedorModel
{
    private $conn;
    private $table_name = "proveedor";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getProveedores()
    {
        $query = "call SP_LISTAR_PROVEEDOR()";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crearProveedores($nombre, $apepat, $apemat, $ndocumento, $tdocumento, $sexo, $telefono, $razonsocial, $nomcontacto, $numcontacto)
    {
        $query = "CALL SP_REGISTRAR_PROVEEDOR(:nombre, :apepat, :apemat, :ndocumento, :tdocumento, :sexo, :telefono, :razonsocial, :nomcontacto, :numcontacto)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apepat', $apepat);
        $stmt->bindParam(':apemat', $apemat);
        $stmt->bindParam(':ndocumento', $ndocumento);
        $stmt->bindParam(':tdocumento', $tdocumento);
        $stmt->bindParam(':sexo', $sexo);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':razonsocial', $razonsocial);
        $stmt->bindParam(':nomcontacto', $nomcontacto);
        $stmt->bindParam(':numcontacto', $numcontacto);

        if ($stmt->execute()) {
            return $stmt->fetchColumn();
        }
        return false;
    }

    public function editarProveedor($idproveedor, $razonsocial, $nomcontacto, $numcontacto)
    {
        $query = "CALL SP_MODIFICAR_PROVEEDOR(:idproveedor, :razonsocial, :nomcontacto, :numcontacto)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':idproveedor', $idproveedor);
        $stmt->bindParam(':razonsocial', $razonsocial);
        $stmt->bindParam(':nomcontacto', $nomcontacto);
        $stmt->bindParam(':numcontacto', $numcontacto);

        if ($stmt->execute()) {
            return $stmt->fetchColumn();
        }
        return false;
    }

    public function modificarEstatusProveedor($idproveedor, $estatus)
    {
        $query = "CALL SP_MODIFICAR_ESTATUS_PROVEEDOR(:idproveedor, :estatus)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':idproveedor', $idproveedor);
        $stmt->bindParam(':estatus', $estatus);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}

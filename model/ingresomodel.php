<?php

class IngresoModel
{
    private $conn;
    private $table_name = "ingreso";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getIngresos($finicio, $ffin)
    {
        $query = "CALL SP_LISTAR_INGRESO(:finicio, :ffin)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':finicio', $finicio);
        $stmt->bindParam(':ffin', $ffin);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crearIngreso($idproveedor, $idusuario, $tipo, $serie, $ncomprobante, $total, $impuesto, $porcentaje)
    {
        $query = "CALL SP_REGISTRAR_INGRESO(:idproveedor, :idusuario, :tipo, :serie, :ncomprobante, :total, :impuesto, :porcentaje)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idproveedor', $idproveedor);
        $stmt->bindParam(':idusuario', $idusuario);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':serie', $serie);
        $stmt->bindParam(':ncomprobante', $ncomprobante);
        $stmt->bindParam(':total', $total);
        $stmt->bindParam(':impuesto', $impuesto);
        $stmt->bindParam(':porcentaje', $porcentaje);

        if ($stmt->execute()) {
            return $stmt->fetchColumn();
        }
        return false;
    }

    public function anularIngreso($idingreso)
    {
        $query = "CALL SP_ANULAR_INGRESO(:idingreso)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idingreso', $idingreso);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function listarComboProveedor()
    {
        $query = "CALL SP_LISTAR_COMBO_PROVEEDOR()";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarComboProducto()
    {
        $query = "CALL SP_LISTAR_COMBO_PRODUCTO()";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function registrarIngresoDetalle($id, $array_producto, $array_cantidad, $array_precio)
    {
        $query = "CALL SP_REGISTRAR_INGRESO_DETALLE(:id, :array_producto, :array_cantidad, :array_precio)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':array_producto', $array_producto);
        $stmt->bindParam(':array_cantidad', $array_cantidad);
        $stmt->bindParam(':array_precio', $array_precio);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}

<?php

class VentaModel
{
    private $conn;
    private $table_name = "venta";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getVentas($finicio, $ffin)
    {
        $query = "CALL SP_LISTAR_VENTA(:finicio, :ffin)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':finicio', $finicio);
        $stmt->bindParam(':ffin', $ffin);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function registrarVenta($idcliente, $idusuario, $tipo, $serie, $ncomprobante, $total, $impuesto, $porcentaje)
    {
        $query = "CALL SP_REGISTRAR_VENTA(:idcliente, :idusuario, :tipo, :serie, :ncomprobante, :total, :impuesto, :porcentaje)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idcliente', $idcliente);
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

    public function anularVenta($idventa)
    {
        $query = "CALL SP_ANULAR_VENTA(:idventa)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idventa', $idventa);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function listarComboCliente()
    {
        $query = "CALL SP_LISTAR_COMBO_CLIENTE()";
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

    public function numVentas(){
        $query = "SELECT COUNT(*) AS Total, MAX(venta_id) AS ultimo_id FROM VENTA";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function registrarVentaDetalle($id, $array_producto, $array_cantidad, $array_precio)
    {
        $query = "CALL SP_REGISTRAR_VENTA_DETALLE(:id, :array_producto, :array_cantidad, :array_precio)";
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

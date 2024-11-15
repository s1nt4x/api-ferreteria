<?php

class ProductoModel
{
    private $conn;
    private $table_name = "producto";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getProductos()
    {
        $query = "call SP_LISTAR_PRODUCTO()";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crearProductos($producto, $presentacion, $categoria, $unidad, $precio, $ruta)
    {
        $query = "CALL SP_REGISTRAR_PRODUCTO(:producto, :presentacion, :categoria, :unidad, :precio, :ruta)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':producto', $producto);
        $stmt->bindParam(':presentacion', $presentacion);
        $stmt->bindParam(':categoria', $categoria);
        $stmt->bindParam(':unidad', $unidad);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':ruta', $ruta);

        if ($stmt->execute()) {
            return $stmt->fetchColumn();
        }
        return false;
    }

    public function editarFotoProducto($id, $ruta)
    {
        $query = "CALL SP_MODIFICAR_PRODUCTO_FOTO(:id, :ruta)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':ruta', $ruta);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function listar_combo_categoria()
    {
        $query = "CALL SP_LISTAR_COMBO_CATEGORIA()";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listar_combo_unidad()
    {
        $query = "CALL SP_LISTAR_COMBO_UNIDAD()";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

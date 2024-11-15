<?php
class CategoriaModel
{
    private $conn;
    private $table_name = "categoria";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getCategorias()
    {
        $query = "CALL SP_LISTAR_CATEGORIA()";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crearCategoria($categoria_nombre)
    {
        $query = "CALL SP_REGISTRAR_CATEGORIA(:categoria_nombre)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":categoria_nombre", $categoria_nombre);

        if ($stmt->execute()) {
            return $stmt->fetchColumn();
        }
        return false;
    }

    public function editarCategoria($id, $categoriaActual, $categoriaNuevo, $estatus)
    {
        $query = "CALL SP_EDITAR_CATEGORIA(:id, :categoriaActual, :categoriaNuevo, :estatus)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':categoriaActual', $categoriaActual);
        $stmt->bindParam(':categoriaNuevo', $categoriaNuevo);
        $stmt->bindParam(':estatus', $estatus);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function eliminarCategoria($id)
    {
        $query = "DELETE FROM categoria WHERE categoria_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}

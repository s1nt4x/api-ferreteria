<?php

class UnidadMedidaModel
{
    private $conn;
    private $table_name = "unidad_medida";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getUnidadesMedida()
    {
        $query = "CALL SP_LISTAR_UNIDADMEDIDA()";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crearUnidadMedida($unidad, $abreviatura)
    {
        $query = "CALL SP_REGISTRAR_UNIDADMEDIDA(:unidad, :abreviatura)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':unidad', $unidad);
        $stmt->bindParam(':abreviatura', $abreviatura);

        if ($stmt->execute()) {
            return $stmt->fetchColumn();
        }
        return false;
    }

    public function editarUnidadMedida($id, $unidadactual, $unidadnueva, $abreviaturaeditar, $estatus)
    {
        $query = "CALL SP_EDITAR_UNIDADMEDIDA(:id, :unidadactual, :unidadnueva, :abreviaturaeditar, :estatus)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':unidadactual', $unidadactual);
        $stmt->bindParam(':unidadnueva', $unidadnueva);
        $stmt->bindParam(':abreviaturaeditar', $abreviaturaeditar);
        $stmt->bindParam(':estatus', $estatus);

        if ($stmt->execute()) {
            return $stmt->fetchColumn();
        }
        return false;
    }
}

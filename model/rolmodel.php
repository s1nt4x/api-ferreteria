<?php
class RolModel
{
    private $conn;
    private $table_name = "rol";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getRoles()
    {
        $query = "call SP_LISTAR_ROL()";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crearRol($rol)
    {
        $query = "call SP_REGISTRAR_ROL('$rol')";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":rol", $rol);

        if ($stmt->execute()) {
            return $stmt->fetchColumn();
        }
        return false;
    }

    public function editarRol($id, $rolactual, $rolnuevo, $estatus)
    {
        $query = "call SP_EDITAR_ROL('$id','$rolactual','$rolnuevo','$estatus')";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':rolactual', $rolactual);
        $stmt->bindParam(':rolnuevo', $rolnuevo);
        $stmt->bindParam(':estatus', $estatus);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}

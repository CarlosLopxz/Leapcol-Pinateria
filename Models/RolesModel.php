<?php
class RolesModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getRoles()
    {
        $sql = "SELECT * FROM roles WHERE estado = 1 ORDER BY nombrerol ASC";
        return $this->select_all($sql);
    }

    public function getModulos()
    {
        $sql = "SELECT * FROM modulos WHERE estado = 1 ORDER BY nombre ASC";
        return $this->select_all($sql);
    }

    public function getPermisos($rolId)
    {
        $sql = "SELECT modulo_id FROM permisos WHERE rol_id = " . intval($rolId);
        $result = $this->select_all($sql);
        $permisos = [];
        foreach($result as $row) {
            $permisos[] = $row['modulo_id'];
        }
        return $permisos;
    }

    public function setPermisos($rolId, $modulos)
    {
        try {
            $this->beginTransaction();
            
            // Eliminar permisos existentes
            $sql = "DELETE FROM permisos WHERE rol_id = ?";
            $this->update($sql, [intval($rolId)]);
            
            // Insertar nuevos permisos
            foreach($modulos as $moduloId) {
                $sql = "INSERT INTO permisos (rol_id, modulo_id) VALUES (?, ?)";
                $this->insert($sql, [intval($rolId), intval($moduloId)]);
            }
            
            $this->commit();
            return true;
        } catch (Exception $e) {
            $this->rollback();
            error_log("Error en setPermisos: " . $e->getMessage());
            return false;
        }
    }

    public function setRol($datos)
    {
        if(empty($datos['idrol'])) {
            // Crear nuevo rol
            $sql = "INSERT INTO roles (nombrerol, descripcion) VALUES (?, ?)";
            return $this->insert($sql, [$datos['nombrerol'], $datos['descripcion']]);
        } else {
            // Actualizar rol existente
            $sql = "UPDATE roles SET nombrerol = ?, descripcion = ? WHERE idrol = ?";
            return $this->update($sql, [$datos['nombrerol'], $datos['descripcion'], intval($datos['idrol'])]);
        }
    }

    public function getRol($rolId)
    {
        $sql = "SELECT * FROM roles WHERE idrol = ?";
        return $this->select($sql, [intval($rolId)]);
    }
}
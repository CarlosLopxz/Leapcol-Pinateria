<?php

class Mysql extends Conexion
{
    private $conexion;
    private $strquery;
    private $arrValues;

    public function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->conect();
    }

    //Insertar un registro
    public function insert(string $query, array $arrValues)
    {
        try {
            $this->strquery = $query;
            $this->arrValues = $arrValues;
            
            $insert = $this->conexion->prepare($this->strquery);
            $resInsert = $insert->execute($this->arrValues);
            
            if ($resInsert) {
                $lastInsert = $this->conexion->lastInsertId();
                return $lastInsert;
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            error_log("Error en insert: " . $e->getMessage());
            return 0;
        }
    }
    
    //Busca un registro
    public function select(string $query, array $arrValues = [])
    {
        $this->strquery = $query;
        $this->arrValues = $arrValues;
        $result = $this->conexion->prepare($this->strquery);
        $result->execute($this->arrValues);
        $data = $result->fetch(PDO::FETCH_ASSOC);
        return $data;
    }
    
    //Devuelve todos los registros
    public function select_all(string $query, array $arrValues = [])
    {
        $this->strquery = $query;
        $this->arrValues = $arrValues;
        $result = $this->conexion->prepare($this->strquery);
        $result->execute($this->arrValues);
        $data = $result->fetchall(PDO::FETCH_ASSOC);
        return $data;
    }
    
    //Actualiza registros
    public function update(string $query, array $arrValues)
    {
        try {
            $this->strquery = $query;
            $this->arrValues = $arrValues;
            
            $update = $this->conexion->prepare($this->strquery);
            $resExecute = $update->execute($this->arrValues);
            
            if ($resExecute) {
                return $resExecute;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Error en update: " . $e->getMessage());
            return false;
        }
    }
    
    //Eliminar un registros
    public function delete(string $query, array $arrValues = [])
    {
        $this->strquery = $query;
        $this->arrValues = $arrValues;
        $result = $this->conexion->prepare($this->strquery);
        $del = $result->execute($this->arrValues);
        return $del;
    }

    // Métodos de transacción
    public function beginTransaction()
    {
        return $this->conexion->beginTransaction();
    }

    public function commit()
    {
        return $this->conexion->commit();
    }

    public function rollback()
    {
        return $this->conexion->rollBack();
    }

    protected function getError()
    {
        if ($this->conexion) {
            $error = $this->conexion->errorInfo();
            return $error[2]; // Devuelve el mensaje de error
        }
        return "No hay conexión a la base de datos";
    }
}
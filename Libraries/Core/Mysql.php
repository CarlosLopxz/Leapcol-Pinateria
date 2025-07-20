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
            
            // Verificar conexión
            if (!$this->conexion instanceof PDO) {
                error_log("Error: La conexión no es un objeto PDO válido");
                return 0;
            }
            
            // Preparar consulta
            $insert = $this->conexion->prepare($this->strquery);
            if (!$insert) {
                $errorInfo = $this->conexion->errorInfo();
                error_log("Error al preparar consulta: " . json_encode($errorInfo));
                return 0;
            }
            
            // Ejecutar consulta
            $resInsert = $insert->execute($this->arrValues);
            
            if ($resInsert) {
                $lastInsert = $this->conexion->lastInsertId();
                return $lastInsert;
            } else {
                $errorInfo = $insert->errorInfo();
                error_log("Error en insert (errorInfo): " . json_encode($errorInfo));
                // Mostrar error específico de SQL
                if (isset($errorInfo[2])) {
                    error_log("Mensaje de error SQL: " . $errorInfo[2]);
                }
                return 0;
            }
        } catch (PDOException $e) {
            error_log("Error en insert: " . $e->getMessage());
            error_log("Código de error: " . $e->getCode());
            error_log("SQL: " . $this->strquery);
            error_log("Valores: " . json_encode($this->arrValues));
            return 0;
        }
    }
    
    //Busca un registro
    public function select(string $query, array $arrValues = [])
    {
        try {
            $this->strquery = $query;
            $this->arrValues = $arrValues;
            $result = $this->conexion->prepare($this->strquery);
            $result->execute($this->arrValues);
            $data = $result->fetch(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            error_log("Error en select: " . $e->getMessage());
            return null;
        }
    }
    
    //Devuelve todos los registros
    public function select_all(string $query, array $arrValues = [])
    {
        try {
            $this->strquery = $query;
            $this->arrValues = $arrValues;
            $result = $this->conexion->prepare($this->strquery);
            $result->execute($this->arrValues);
            $data = $result->fetchall(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            error_log("Error en select_all: " . $e->getMessage());
            return [];
        }
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
                $errorInfo = $update->errorInfo();
                error_log("Error en update (errorInfo): " . json_encode($errorInfo));
                return false;
            }
        } catch (PDOException $e) {
            error_log("Error en update (exception): " . $e->getMessage());
            error_log("SQL: " . $this->strquery);
            error_log("Valores: " . json_encode($this->arrValues));
            return false;
        }
    }
    
    //Eliminar un registros
    public function delete(string $query, array $arrValues = [])
    {
        try {
            $this->strquery = $query;
            $this->arrValues = $arrValues;
            $result = $this->conexion->prepare($this->strquery);
            $del = $result->execute($this->arrValues);
            return $del;
        } catch (PDOException $e) {
            error_log("Error en delete: " . $e->getMessage());
            return false;
        }
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
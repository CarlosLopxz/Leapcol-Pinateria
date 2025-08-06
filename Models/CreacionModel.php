<?php
class CreacionModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getCajaCreacion()
    {
        $sql = "SELECT monto_actual FROM caja_creacion WHERE id = 1";
        $result = $this->select($sql);
        return $result ?: ['monto_actual' => 0];
    }
    
    public function getInventarioCreacion()
    {
        $sql = "SELECT ic.cantidad, p.codigo, p.nombre, p.precio_venta
                FROM inventario_creacion ic
                INNER JOIN productos p ON ic.producto_id = p.id
                WHERE ic.cantidad > 0
                ORDER BY p.nombre ASC";
        return $this->select_all($sql) ?: [];
    }
    
    public function crearClienteCreacion()
    {
        $sql = "INSERT IGNORE INTO clientes (nombre, apellido, documento, tipo_documento, estado) 
                VALUES ('Cliente', 'Creación', '00000000', 'CC', 1)";
        $this->insert($sql, []);
        
        // Crear tablas si no existen
        $this->crearTablasCreacion();
    }
    
    private function crearTablasCreacion()
    {
        // Crear caja_creacion
        $sql1 = "CREATE TABLE IF NOT EXISTS caja_creacion (
                    id INT(11) NOT NULL AUTO_INCREMENT,
                    monto_actual DECIMAL(10,2) NOT NULL DEFAULT 0.00,
                    estado TINYINT(1) NOT NULL DEFAULT 1,
                    PRIMARY KEY (id)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        $this->insert($sql1, []);
        
        // Insertar registro inicial
        $sql2 = "INSERT IGNORE INTO caja_creacion (id, monto_actual) VALUES (1, 0.00)";
        $this->insert($sql2, []);
        
        // Crear inventario_creacion
        $sql3 = "CREATE TABLE IF NOT EXISTS inventario_creacion (
                    id INT(11) NOT NULL AUTO_INCREMENT,
                    producto_id INT(11) NOT NULL,
                    cantidad INT(11) NOT NULL DEFAULT 0,
                    PRIMARY KEY (id),
                    UNIQUE KEY unique_producto (producto_id),
                    FOREIGN KEY (producto_id) REFERENCES productos(id)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        $this->insert($sql3, []);
    }
}
<?php
class UsuariosModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getUsuarios()
    {
        $sql = "SELECT u.*, COALESCE(r.nombrerol, 'Sin rol') as nombrerol
                FROM usuarios u
                LEFT JOIN roles r ON u.rolid = r.idrol
                WHERE u.status != 3
                ORDER BY u.idusuario DESC";
        return $this->select_all($sql);
    }

    public function getUsuario($idUsuario)
    {
        $sql = "SELECT u.*, r.nombrerol
                FROM usuarios u
                INNER JOIN roles r ON u.rolid = r.idrol
                WHERE u.idusuario = " . intval($idUsuario);
        return $this->select($sql);
    }

    public function getRoles()
    {
        $sql = "SELECT * FROM roles WHERE status = 1 ORDER BY nombrerol ASC";
        return $this->select_all($sql);
    }

    public function insertUsuario($datos)
    {
        $query = "INSERT INTO usuarios(nombre, apellido, usuario, email, password, rolid, status) 
                  VALUES(?, ?, ?, ?, ?, ?, ?)";
        $arrData = [
            $datos['nombre'],
            $datos['apellido'],
            $datos['usuario'],
            $datos['email'],
            $datos['password'],
            $datos['rolid'],
            $datos['status']
        ];
        return $this->insert($query, $arrData);
    }

    public function updateUsuario($datos)
    {
        if(isset($datos['password'])) {
            $sql = "UPDATE usuarios 
                    SET nombre = ?, apellido = ?, usuario = ?, email = ?, password = ?, rolid = ?, status = ?
                    WHERE idusuario = ?";
            $arrData = [
                $datos['nombre'],
                $datos['apellido'],
                $datos['usuario'],
                $datos['email'],
                $datos['password'],
                $datos['rolid'],
                $datos['status'],
                $datos['idUsuario']
            ];
        } else {
            $sql = "UPDATE usuarios 
                    SET nombre = ?, apellido = ?, usuario = ?, email = ?, rolid = ?, status = ?
                    WHERE idusuario = ?";
            $arrData = [
                $datos['nombre'],
                $datos['apellido'],
                $datos['usuario'],
                $datos['email'],
                $datos['rolid'],
                $datos['status'],
                $datos['idUsuario']
            ];
        }
        
        return $this->update($sql, $arrData);
    }
    
    public function deleteUsuario($idUsuario)
    {
        $sql = "UPDATE usuarios SET status = 3 WHERE idusuario = ?";
        return $this->update($sql, [intval($idUsuario)]);
    }
}
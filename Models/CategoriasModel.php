<?php
class CategoriasModel extends Mysql
{
    private $id;
    private $nombre;
    private $descripcion;
    private $estado;

    public function __construct()
    {
        parent::__construct();
    }

    public function getCategorias()
    {
        $sql = "SELECT id, nombre, descripcion, estado, 
                DATE_FORMAT(fecha_creacion, '%d/%m/%Y') as fecha_creacion 
                FROM categorias ORDER BY nombre ASC";
        $request = $this->select_all($sql);
        return $request;
    }

    public function getCategoria(int $idCategoria)
    {
        $this->id = $idCategoria;
        $sql = "SELECT id, nombre, descripcion, estado, 
                DATE_FORMAT(fecha_creacion, '%d/%m/%Y') as fecha_creacion 
                FROM categorias WHERE id = {$this->id}";
        $request = $this->select($sql);
        return $request;
    }

    public function insertCategoria(array $datos)
    {
        $this->nombre = $datos['nombre'];
        $this->descripcion = $datos['descripcion'];
        $this->estado = $datos['estado'];

        $query_insert = "INSERT INTO categorias(nombre, descripcion, estado) 
                        VALUES(?,?,?)";
        $arrData = array($this->nombre, $this->descripcion, $this->estado);
        $request_insert = $this->insert($query_insert, $arrData);
        return $request_insert;
    }

    public function updateCategoria(array $datos)
    {
        $this->id = $datos['idCategoria'];
        $this->nombre = $datos['nombre'];
        $this->descripcion = $datos['descripcion'];
        $this->estado = $datos['estado'];

        $sql = "UPDATE categorias SET nombre = ?, descripcion = ?, estado = ? 
                WHERE id = {$this->id}";
        $arrData = array($this->nombre, $this->descripcion, $this->estado);
        $request = $this->update($sql, $arrData);
        return $request;
    }

    public function deleteCategoria(int $idCategoria)
    {
        $this->id = $idCategoria;
        $sql = "DELETE FROM categorias WHERE id = {$this->id}";
        $request = $this->delete($sql);
        return $request;
    }

    public function verificarProductosCategoria(int $idCategoria)
    {
        $this->id = $idCategoria;
        $sql = "SELECT COUNT(*) as total FROM productos WHERE categoria_id = {$this->id}";
        $request = $this->select($sql);
        return ($request['total'] > 0);
    }
}
<?php
class ProductosModel extends Mysql
{
    private $intIdProducto;
    private $strCodigo;
    private $strNombre;
    private $strDescripcion;
    private $decPrecioCompra;
    private $decPrecioVenta;
    private $intStock;
    private $intStockMinimo;
    private $intCategoria;
    private $strImagen;
    private $intEstado;

    public function __construct()
    {
        parent::__construct();
    }

    public function getProductos()
    {
        $sql = "SELECT p.*, c.nombre as categoria
                FROM productos p
                INNER JOIN categorias c ON p.categoria_id = c.id
                ORDER BY p.id DESC";
        $request = $this->select_all($sql);
        return $request;
    }

    public function getProducto($idProducto)
    {
        $this->intIdProducto = $idProducto;
        $sql = "SELECT p.*, c.nombre as categoria
                FROM productos p
                INNER JOIN categorias c ON p.categoria_id = c.id
                WHERE p.id = {$this->intIdProducto}";
        $request = $this->select($sql);
        return $request;
    }

    public function getProductoPorCodigo($codigo)
    {
        $this->strCodigo = $codigo;
        $sql = "SELECT * FROM productos WHERE codigo = '{$this->strCodigo}'";
        $request = $this->select($sql);
        return $request;
    }

    public function getCategorias()
    {
        $sql = "SELECT * FROM categorias WHERE estado = 1 ORDER BY nombre ASC";
        $request = $this->select_all($sql);
        return $request;
    }

    public function insertProducto($datos)
    {
        $this->strCodigo = $datos['codigo'];
        $this->strNombre = $datos['nombre'];
        $this->strDescripcion = $datos['descripcion'];
        $this->decPrecioCompra = $datos['precioCompra'];
        $this->decPrecioVenta = $datos['precioVenta'];
        $this->intStock = $datos['stock'];
        $this->intStockMinimo = $datos['stockMinimo'];
        $this->intCategoria = $datos['categoria'];
        $this->strImagen = $datos['imagen'];
        $this->intEstado = $datos['estado'];

        $query_insert = "INSERT INTO productos(codigo, nombre, descripcion, precio_compra, precio_venta, stock, stock_minimo, categoria_id, imagen, estado) 
                        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $arrData = array(
            $this->strCodigo,
            $this->strNombre,
            $this->strDescripcion,
            $this->decPrecioCompra,
            $this->decPrecioVenta,
            $this->intStock,
            $this->intStockMinimo,
            $this->intCategoria,
            $this->strImagen,
            $this->intEstado
        );
        $request_insert = $this->insert($query_insert, $arrData);
        return $request_insert;
    }

    public function updateProducto($datos)
    {
        $this->intIdProducto = $datos['idProducto'];
        $this->strCodigo = $datos['codigo'];
        $this->strNombre = $datos['nombre'];
        $this->strDescripcion = $datos['descripcion'];
        $this->decPrecioCompra = $datos['precioCompra'];
        $this->decPrecioVenta = $datos['precioVenta'];
        $this->intStock = $datos['stock'];
        $this->intStockMinimo = $datos['stockMinimo'];
        $this->intCategoria = $datos['categoria'];
        $this->intEstado = $datos['estado'];

        $sql = "UPDATE productos 
                SET codigo = ?, nombre = ?, descripcion = ?, precio_compra = ?, precio_venta = ?, 
                    stock = ?, stock_minimo = ?, categoria_id = ?, estado = ?";
        $arrData = array(
            $this->strCodigo,
            $this->strNombre,
            $this->strDescripcion,
            $this->decPrecioCompra,
            $this->decPrecioVenta,
            $this->intStock,
            $this->intStockMinimo,
            $this->intCategoria,
            $this->intEstado
        );

        if($datos['imagen'] != '') {
            $this->strImagen = $datos['imagen'];
            $sql .= ", imagen = ?";
            array_push($arrData, $this->strImagen);
        }

        $sql .= " WHERE id = ?";
        array_push($arrData, $this->intIdProducto);

        $request = $this->update($sql, $arrData);
        return $request;
    }

    public function deleteProducto($idProducto)
    {
        $this->intIdProducto = $idProducto;
        
        // Verificar si el producto está en alguna venta
        $sql = "SELECT COUNT(*) as total FROM detalle_venta WHERE producto_id = {$this->intIdProducto}";
        $request = $this->select($sql);
        if($request['total'] > 0) {
            // Si está en ventas, solo lo desactivamos
            $sql = "UPDATE productos SET estado = 0 WHERE id = {$this->intIdProducto}";
            $request = $this->update($sql, []);
        } else {
            // Si no está en ventas, lo eliminamos
            $sql = "DELETE FROM productos WHERE id = {$this->intIdProducto}";
            $request = $this->delete($sql);
        }
        return $request;
    }

    public function getProductosActivos()
    {
        $sql = "SELECT id, codigo, nombre, descripcion, precio_venta, stock
                FROM productos
                WHERE estado = 1 AND stock > 0
                ORDER BY nombre ASC";
        $request = $this->select_all($sql);
        return $request;
    }
}
<?php
class InventarioModel extends Mysql
{
    private $intIdProducto;
    private $strCodigo;
    private $strNombre;
    private $strDescripcion;
    private $intCategoria;
    private $intSubcategoria;
    private $strUnidadMedida;
    private $strTamanio;
    private $strPresentacion;
    private $strAlmacen;
    private $strUbicacion;
    private $strCondiciones;
    private $strObservaciones;
    private $intStockActual;
    private $intStockMinimo;
    private $intStockMaximo;
    private $decPrecioCompra;
    private $decPrecioVenta;
    private $decCostosAdicionales;
    private $intEstado;

    public function __construct()
    {
        parent::__construct();
    }

    public function getProductos()
    {
        try {
            $sql = "SELECT p.id, p.codigo, p.nombre, c.nombre as categoria, p.stock_actual, 
                    p.precio_venta, p.estado 
                    FROM productos p 
                    INNER JOIN categorias c ON p.categoria_id = c.id 
                    ORDER BY p.id DESC";
            $request = $this->select_all($sql);
            return $request;
        } catch (Exception $e) {
            // Si hay un error, devolver un array vacío y registrar el error
            error_log("Error en getProductos: " . $e->getMessage());
            return [];
        }
    }

    public function getProducto(int $idProducto)
    {
        try {
            $this->intIdProducto = $idProducto;
            $sql = "SELECT p.*, c.nombre as categoria_nombre, s.nombre as subcategoria_nombre, a.nombre as almacen_nombre 
                    FROM productos p 
                    INNER JOIN categorias c ON p.categoria_id = c.id 
                    LEFT JOIN subcategorias s ON p.subcategoria_id = s.id 
                    INNER JOIN almacenes a ON p.almacen_id = a.id 
                    WHERE p.id = {$this->intIdProducto}";
            $request = $this->select($sql);
            return $request;
        } catch (Exception $e) {
            // Si hay un error, registrarlo y devolver null
            error_log("Error en getProducto (Model): " . $e->getMessage());
            return null;
        }
    }

    public function setProducto(array $datos)
    {
        try {
            $this->strCodigo = $datos['codigo'];
            $this->strNombre = $datos['nombre'];
            $this->strDescripcion = $datos['descripcion'];
            $this->intCategoria = $datos['categoria'];
            $this->intSubcategoria = $datos['subcategoria'] != '' ? $datos['subcategoria'] : null;
            $this->strUnidadMedida = $datos['unidad_medida'];
            $this->strTamanio = $datos['tamanio'];
            $this->strPresentacion = $datos['presentacion'];
            $this->strAlmacen = $datos['almacen'];
            $this->strUbicacion = $datos['ubicacion'];
            $this->strCondiciones = $datos['condiciones'];
            $this->strObservaciones = $datos['observaciones_ubicacion'];
            $this->intStockActual = $datos['stock_actual'];
            $this->intStockMinimo = $datos['stock_minimo'];
            $this->intStockMaximo = $datos['stock_maximo'] != '' ? $datos['stock_maximo'] : null;
            $this->decPrecioCompra = $datos['precio_compra'];
            $this->decPrecioVenta = $datos['precio_venta'];
            $this->decCostosAdicionales = $datos['costos_adicionales'] != '' ? $datos['costos_adicionales'] : 0;
            $this->intEstado = $datos['estado'];
            
            if(isset($datos['idProducto']) && $datos['idProducto'] > 0) {
                // Actualizar producto
                $this->intIdProducto = $datos['idProducto'];
                $sql = "UPDATE productos SET codigo = ?, nombre = ?, descripcion = ?, categoria_id = ?, 
                        subcategoria_id = ?, unidad_medida = ?, tamanio = ?, presentacion = ?, 
                        almacen_id = ?, ubicacion = ?, condiciones = ?, observaciones = ?, 
                        stock_actual = ?, stock_minimo = ?, stock_maximo = ?, 
                        precio_compra = ?, precio_venta = ?, costos_adicionales = ?, estado = ? 
                        WHERE id = {$this->intIdProducto}";
                $arrData = [
                    $this->strCodigo, $this->strNombre, $this->strDescripcion, $this->intCategoria,
                    $this->intSubcategoria, $this->strUnidadMedida, $this->strTamanio, $this->strPresentacion,
                    $this->strAlmacen, $this->strUbicacion, $this->strCondiciones, $this->strObservaciones,
                    $this->intStockActual, $this->intStockMinimo, $this->intStockMaximo,
                    $this->decPrecioCompra, $this->decPrecioVenta, $this->decCostosAdicionales, $this->intEstado
                ];
                
                // Registrar los datos para depuración
                error_log("Actualizando producto ID: {$this->intIdProducto}");
                error_log("SQL: {$sql}");
                error_log("Datos: " . json_encode($arrData));
                
                $request = $this->update($sql, $arrData);
            } else {
                // Insertar nuevo producto
                $sql = "INSERT INTO productos (codigo, nombre, descripcion, categoria_id, subcategoria_id, 
                        unidad_medida, tamanio, presentacion, almacen_id, ubicacion, condiciones, 
                        observaciones, stock_actual, stock_minimo, stock_maximo, precio_compra, 
                        precio_venta, costos_adicionales, estado) 
                        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                $arrData = [
                    $this->strCodigo, $this->strNombre, $this->strDescripcion, $this->intCategoria,
                    $this->intSubcategoria, $this->strUnidadMedida, $this->strTamanio, $this->strPresentacion,
                    $this->strAlmacen, $this->strUbicacion, $this->strCondiciones, $this->strObservaciones,
                    $this->intStockActual, $this->intStockMinimo, $this->intStockMaximo,
                    $this->decPrecioCompra, $this->decPrecioVenta, $this->decCostosAdicionales, $this->intEstado
                ];
                $request = $this->insert($sql, $arrData);
            }
            return $request;
        } catch (Exception $e) {
            error_log("Error en setProducto: " . $e->getMessage());
            return false;
        }
    }

    public function deleteProducto(int $idProducto)
    {
        $this->intIdProducto = $idProducto;
        
        // En lugar de eliminar físicamente, cambiamos el estado a inactivo
        $sql = "UPDATE productos SET estado = 0 WHERE id = {$this->intIdProducto}";
        $request = $this->update($sql, []);
        return $request;
    }
    
    public function getSubcategorias(int $categoriaId)
    {
        try {
            $sql = "SELECT id, nombre FROM subcategorias WHERE categoria_id = {$categoriaId} AND estado = 1 ORDER BY nombre ASC";
            $request = $this->select_all($sql);
            return $request;
        } catch (Exception $e) {
            error_log("Error en getSubcategorias: " . $e->getMessage());
            return [];
        }
    }
}
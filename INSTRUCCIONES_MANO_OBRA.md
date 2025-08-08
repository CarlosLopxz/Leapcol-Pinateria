# Instrucciones para Implementar Mano de Obra

## Problema Identificado
El sistema no mostraba la mano de obra de los productos ni en el punto de venta ni en la gestión de productos porque:
1. No existía el campo `mano_obra` en la tabla `productos`
2. El código no estaba preparado para manejar este campo

## Cambios Realizados

### 1. Base de Datos
Ejecutar el siguiente script SQL:
```sql
ALTER TABLE productos ADD COLUMN mano_obra DECIMAL(10,2) NOT NULL DEFAULT 0.00 AFTER precio_venta;
```

### 2. Archivos Modificados
- `Models/ProductosModel.php` - Agregado soporte para campo mano_obra
- `Controllers/Productos.php` - Agregado manejo del campo mano_obra
- `Views/Productos/productos.php` - Agregado campo mano_obra al formulario
- `Models/PosModel.php` - Incluido mano_obra en consultas
- `Views/Pos/pos.php` - Agregada visualización y cálculo de mano de obra

### 3. Funcionalidades Implementadas

#### En Gestión de Productos:
- Campo "Mano de Obra" en el formulario de productos
- Visualización de mano de obra en la tabla de productos
- Almacenamiento y edición de mano de obra

#### En Punto de Venta:
- Visualización de mano de obra en la búsqueda de productos
- Columna "Mano Obra" en la tabla del carrito
- Campo "Mano de Obra" en el resumen de venta
- Cálculo correcto del total incluyendo mano de obra

### 4. Cómo Funciona Ahora

1. **Crear/Editar Producto**: Se puede asignar un valor de mano de obra
2. **Punto de Venta**: 
   - Al buscar productos se muestra el precio total (precio + mano de obra)
   - En el carrito se separa el precio base de la mano de obra
   - En el resumen se muestra subtotal, mano de obra y total
3. **Cálculo de Totales**:
   - Subtotal = suma de (cantidad × precio_venta)
   - Mano de Obra = suma de (cantidad × mano_obra)
   - Total = Subtotal + Mano de Obra - Descuentos

## Pasos para Aplicar los Cambios

1. Ejecutar el script SQL para agregar el campo a la base de datos
2. Los archivos ya han sido modificados con los cambios necesarios
3. Probar creando un producto con mano de obra
4. Verificar que se muestre correctamente en el punto de venta

## Verificación

Para verificar que todo funciona correctamente:
1. Ir a Gestión de Productos
2. Crear/editar un producto y asignar mano de obra
3. Ir al Punto de Venta
4. Buscar el producto y agregarlo al carrito
5. Verificar que se muestre la mano de obra por separado
6. Confirmar que el total se calcule correctamente
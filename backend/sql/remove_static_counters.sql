-- Eliminar columnas estáticas obsoletas ya que ahora se calculan dinámicamente
ALTER TABLE proveedores DROP COLUMN productos_suministrados;
ALTER TABLE proveedores DROP COLUMN total_pedidos;

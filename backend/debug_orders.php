<?php
require_once 'config/database.php';
$db = new Database();
$conn = $db->getConnection();

echo "Checking orders for ASO PIPE and TecnoPole...\n";

$stmt = $conn->query("
    SELECT o.id, o.numero_pedido, o.fecha_creacion, o.proveedor_id, p.nombre as proveedor_nombre 
    FROM pedidos o 
    LEFT JOIN proveedores p ON o.proveedor_id = p.id 
    WHERE p.nombre LIKE '%ASO%' OR p.nombre LIKE '%Tecno%'
");
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($orders)) {
    echo "No orders found for these suppliers.\n";
    
    // Check if suppliers exist
    $stmt = $conn->query("SELECT id, nombre FROM proveedores WHERE nombre LIKE '%ASO%' OR nombre LIKE '%Tecno%'");
    $suppliers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "Suppliers found:\n";
    print_r($suppliers);
} else {
    echo "Orders found:\n";
    print_r($orders);
}

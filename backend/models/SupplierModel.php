<?php
/**
 * Modelo de Proveedores
 */

require_once __DIR__ . '/../config/database.php';

class SupplierModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getSuppliers(array $filters = []) {
        $query = "SELECT
                    p.id,
                    p.nombre,
                    p.contacto,
                    p.email,
                    p.telefono,
                    p.direccion,
                    (SELECT COUNT(*) FROM productos prod WHERE prod.proveedor_id = p.id AND prod.activo = 1) as productos_suministrados,
                    (SELECT COUNT(*) FROM pedidos ped WHERE ped.proveedor_id = p.id) as total_pedidos,
                    p.activo
                  FROM proveedores p
                  WHERE 1 = 1";

        $params = [];

        if (!empty($filters['search'])) {
            $query .= " AND (p.nombre LIKE :search OR p.contacto LIKE :search OR p.email LIKE :search)";
            $params[':search'] = '%' . $filters['search'] . '%';
        }

        if (!empty($filters['status'])) {
            if ($filters['status'] === 'active') {
                $query .= " AND p.activo = 1";
            } elseif ($filters['status'] === 'inactive') {
                $query .= " AND p.activo = 0";
            }
        }

        $query .= " ORDER BY p.nombre ASC";

        $stmt = $this->conn->prepare($query);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();

        return array_map(function ($row) {
            return [
                'id' => (int) $row['id'],
                'nombre' => $row['nombre'],
                'contacto' => $row['contacto'],
                'email' => $row['email'],
                'telefono' => $row['telefono'],
                'direccion' => $row['direccion'],
                'productos_suministrados' => (int) $row['productos_suministrados'],
                'total_pedidos' => (int) $row['total_pedidos'],
                'activo' => (int) $row['activo'],
            ];
        }, $stmt->fetchAll());
    }

    public function getSummary() {
        // Calculate summary using the same dynamic logic to ensure consistency
        $query = "SELECT
                    COUNT(*) AS total_proveedores,
                    (SELECT COUNT(*) FROM productos WHERE activo = 1 AND proveedor_id IS NOT NULL) AS productos_totales,
                    (SELECT COUNT(*) FROM pedidos WHERE proveedor_id IS NOT NULL) AS pedidos_totales
                  FROM proveedores";
        
        // Note: The above query for totals is slightly simplified. 
        // A more accurate way for totals specifically related to *suppliers* (if we only want to count products/orders linked to existing suppliers)
        // would be summing the subqueries, but for general dashboard stats, counting the tables directly is usually what's expected 
        // and more performant. However, to match the 'Suppliers View' context, let's stick to the table counts 
        // but ensure we are counting what the user expects.
        
        // Actually, let's use a simpler approach for the summary that matches the grid data:
        $stmt = $this->conn->prepare("
            SELECT 
                COUNT(*) as total_proveedores,
                (SELECT COUNT(*) FROM productos WHERE proveedor_id IS NOT NULL AND activo = 1) as productos_totales,
                (SELECT COUNT(*) FROM pedidos WHERE proveedor_id IS NOT NULL) as pedidos_totales
            FROM proveedores
        ");
        
        $stmt->execute();
        $row = $stmt->fetch();

        return [
            'total_proveedores' => (int) ($row['total_proveedores'] ?? 0),
            'productos_totales' => (int) ($row['productos_totales'] ?? 0),
            'pedidos_totales' => (int) ($row['pedidos_totales'] ?? 0),
        ];
    }

    public function findById(int $id) {
        $stmt = $this->conn->prepare("SELECT * FROM proveedores WHERE id = :id LIMIT 1");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function findByEmail(string $email) {
        $stmt = $this->conn->prepare("SELECT * FROM proveedores WHERE email = :email LIMIT 1");
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function create(array $data) {
        $query = "INSERT INTO proveedores
            (nombre, contacto, email, telefono, direccion, productos_suministrados, total_pedidos, activo)
            VALUES
            (:nombre, :contacto, :email, :telefono, :direccion, :productos_suministrados, :total_pedidos, :activo)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':nombre', $data['nombre']);
        $stmt->bindValue(':contacto', $data['contacto']);
        $stmt->bindValue(':email', $data['email']);
        $stmt->bindValue(':telefono', $data['telefono']);
        $stmt->bindValue(':direccion', $data['direccion']);
        $stmt->bindValue(':productos_suministrados', $data['productos_suministrados'], PDO::PARAM_INT);
        $stmt->bindValue(':total_pedidos', $data['total_pedidos'], PDO::PARAM_INT);
        $stmt->bindValue(':activo', $data['activo'], PDO::PARAM_INT);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function update(int $id, array $data) {
        $query = "UPDATE proveedores SET
                    nombre = :nombre,
                    contacto = :contacto,
                    email = :email,
                    telefono = :telefono,
                    direccion = :direccion,
                    productos_suministrados = :productos_suministrados,
                    total_pedidos = :total_pedidos,
                    activo = :activo
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':nombre', $data['nombre']);
        $stmt->bindValue(':contacto', $data['contacto']);
        $stmt->bindValue(':email', $data['email']);
        $stmt->bindValue(':telefono', $data['telefono']);
        $stmt->bindValue(':direccion', $data['direccion']);
        $stmt->bindValue(':productos_suministrados', $data['productos_suministrados'], PDO::PARAM_INT);
        $stmt->bindValue(':total_pedidos', $data['total_pedidos'], PDO::PARAM_INT);
        $stmt->bindValue(':activo', $data['activo'], PDO::PARAM_INT);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function softDelete(int $id) {
        $stmt = $this->conn->prepare("UPDATE proveedores SET activo = 0 WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}



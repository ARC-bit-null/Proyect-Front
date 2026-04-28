<?php

function get_all_categories($pdo)
{
    try {
        $query = "SELECT id, nombre, descripcion FROM categorias ORDER BY nombre";
        $stmt = $pdo->query($query);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Error en get_all_categories: " . $e->getMessage());
        return false;
    }
}

function get_all_products($pdo)
{
    try {
        $query = "SELECT p.*, c.nombre as categoria_nombre 
                  FROM productos p 
                  LEFT JOIN categorias c ON p.categoria_id = c.id 
                  ORDER BY p.fecha_creacion DESC";
        $stmt = $pdo->query($query);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Error en get_all_products: " . $e->getMessage());
        return false;
    }
}

function get_dashboard_kpis($pdo = null)
{
    $kpis = [
        [
            'id'               => 'total_revenue',
            'title'            => 'Total Revenue',
            'value_formatted'  => '$56,385.72',
            'chart_data'       => [420, 455, 430, 480, 510, 542, 563],
            'ui_theme'         => 'cyan'
        ],
        [
            'id'               => 'new_orders',
            'title'            => 'New Orders',
            'value_formatted'  => '1,376',
            'chart_data'       => [100, 150, 120, 200, 180, 250, 300],
            'ui_theme'         => 'purple'
        ],
        [
            'id'               => 'average_of_value',
            'title'            => 'AOV',
            'value_formatted'  => '$371.97',
            'chart_data'       => [100, 150, 140, 180, 190, 160, 250],
            'ui_theme'         => 'pink'
        ],
        [
            'id'               => 'conversion_rate',
            'title'            => 'CVR',
            'value_formatted'  => '10.07%',
            'chart_data'       => [100, 90, 120, 110, 180, 90, 200],
            'ui_theme'         => 'cyan'
        ],
    ];
    return $kpis;
}

function search_products($pdo, $query)
{
    try {
        $searchTerm = '%' . $query . '%';
        $queryNum = is_numeric($query) ? intval($query) : 0;
        
        $stmt = $pdo->prepare("
            SELECT p.*, c.nombre as categoria_nombre 
            FROM productos p 
            LEFT JOIN categorias c ON p.categoria_id = c.id 
            WHERE p.nombre LIKE :query 
               OR p.id = :id
            ORDER BY p.fecha_creacion DESC
        ");
        $stmt->bindParam(':query', $searchTerm, PDO::PARAM_STR);
        $stmt->bindParam(':id', $queryNum, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Error en search_products: " . $e->getMessage());
        return false;
    }
}

function get_products_with_simulated_sales($pdo)
{
    try {
        $query = "SELECT p.*, c.nombre as categoria_nombre,
                  FLOOR(RAND() * 500 + 10) as ventas_simuladas
                  FROM productos p 
                  LEFT JOIN categorias c ON p.categoria_id = c.id 
                  ORDER BY ventas_simuladas DESC
                  LIMIT 5";
        $stmt = $pdo->query($query);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Error en get_products_with_simulated_sales: " . $e->getMessage());
        return false;
    }
}

function get_categories_sales($pdo)
{
    try {
        $query = "SELECT c.nombre as category, 
                         COUNT(p.id) as product_count,
                         FLOOR(SUM(p.precio * RAND() * 100)) as simulated_sales
                  FROM categorias c
                  LEFT JOIN productos p ON c.id = p.categoria_id
                  GROUP BY c.id, c.nombre";
        $stmt = $pdo->query($query);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Error en get_categories_sales: " . $e->getMessage());
        return false;
    }
}

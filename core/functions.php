<?php

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

function get_dashboard_kpis()
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
        'chart_data'       => [100, 150, 140, 180, 190, 16, 250],
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

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

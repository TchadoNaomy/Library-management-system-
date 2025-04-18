<?php
require_once '../../Backend/connection.php';

try {
    $conn = getConnection();
    
    // Simple query to get only the specified fields
    $query = "SELECT order_id, supplier_id, order_date, total_items, total_cost, status FROM orders";
    $result = $conn->query($query);

    if (!$result) {
        throw new Exception("Query failed: " . $conn->error);
    }

    // Generate table rows
    foreach ($result as $row) {
        echo "<tr>";
        echo "<td>{$row['order_id']}</td>";
        echo "<td>{$row['supplier_id']}</td>";
        echo "<td>{$row['order_date']}</td>";
        echo "<td>{$row['total_items']}</td>";
        echo "<td>{$row['total_cost']}</td>";
        echo "<td>{$row['status']}</td>";
        echo "</tr>";
    }

} catch (Exception $e) {
    echo "<tr><td colspan='6'>Error loading orders: " . $e->getMessage() . "</td></tr>";
} finally {
    if (isset($conn) && $conn instanceof mysqli) {
        $conn->close();
    }
}
?>
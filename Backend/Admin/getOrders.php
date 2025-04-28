<?php
require_once __DIR__ . '/../../Backend/connection.php';

try {
    $orderConn = getNewConnection();
    $query = "SELECT order_id, supplier_id, order_date, total_items, total_cost, status FROM orders";
    $result = mysqli_query($orderConn, $query);

    if (!$result) {
        throw new Exception("Query failed: " . mysqli_error($orderConn));
    }

    // Generate table rows
    while ($row = mysqli_fetch_assoc($result)) {
        // Convert status to lowercase for comparison
        $status = strtolower($row['status']);
        
        echo "<tr>";
        echo "<td>{$row['order_id']}</td>";
        echo "<td>{$row['supplier_id']}</td>";
        echo "<td>{$row['order_date']}</td>";
        echo "<td>{$row['total_items']}</td>";
        echo "<td>{$row['total_cost']}</td>";
        echo "<td>{$row['status']}</td>";
        echo "<td class='action-buttons'>";
        echo "<button class='viewBtn' data-id='{$row['order_id']}'><i class='fas fa-eye'></i></button>";
        
        // Check for 'pending' status (case-insensitive)
        if ($status === 'pending') {
            echo "<button class='editBtn' data-id='{$row['order_id']}'>
                    <i class='fas fa-edit'></i>
                  </button>";
            echo "<button class='deleteBtn' data-id='{$row['order_id']}'>
                    <i class='fas fa-trash'></i>
                  </button>";
        }
        echo "</td>";
        echo "</tr>";
        
        // Debug output
        error_log("Order ID: {$row['order_id']}, Status: {$row['status']}");
    }

} catch (Exception $e) {
    echo "<tr><td colspan='7'>Error loading orders: " . $e->getMessage() . "</td></tr>";
} finally {
    if (isset($result)) {
        mysqli_free_result($result);
    }
    if (isset($orderConn)) {
        mysqli_close($orderConn);
    }
}
?>
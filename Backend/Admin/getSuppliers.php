<?php
// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'library_management';

// Create a new connection
$conn = null;

try {
    $conn = new mysqli($host, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement
    $sql = "SELECT supplier_id, name, email, phone_number, address FROM supplier ORDER BY supplier_id DESC";
    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception("Query failed: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['supplier_id']) . "</td>
                    <td>" . htmlspecialchars($row['name']) . "</td>
                    <td>" . htmlspecialchars($row['email']) . "</td>
                    <td>" . htmlspecialchars($row['phone_number']) . "</td>
                    <td>" . htmlspecialchars($row['address']) . "</td>
                    <td>
                        <button class='edit-btn' data-id='" . $row['supplier_id'] . "'>
                            <i class='fas fa-edit'></i>
                        </button>
                        <button class='delete-btn' data-id='" . $row['supplier_id'] . "'>
                            <i class='fas fa-trash'></i>
                        </button>
                    </td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='6' class='no-data'>No suppliers found</td></tr>";
    }

} catch (Exception $e) {
    error_log("Error fetching suppliers: " . $e->getMessage());
    echo "<tr><td colspan='6' class='error'>Error loading suppliers: " . $e->getMessage() . "</td></tr>";
} finally {
    // Only close if connection was established
    if ($conn instanceof mysqli && !$conn->connect_error) {
        $conn->close();
    }
}
?>
<?php
require_once __DIR__ . '/../connection.php';

function fetchUsers() {
    try {
        // Create new connection
        $conn = new mysqli($GLOBALS['hostname'], $GLOBALS['servername'], $GLOBALS['password'], $GLOBALS['dbname']);
        
        // Check connection
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }

        $query = "SELECT user_id, name, email, role, profile_image, created_at 
                  FROM user 
                  ORDER BY created_at DESC";
        
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $users = array();
        while ($row = $result->fetch_assoc()) {
            // Convert BLOB to base64 if profile_image exists
            if ($row['profile_image']) {
                $row['profile_image'] = base64_encode($row['profile_image']);
            }
            $users[] = $row;
        }
        
        // Close resources
        $stmt->close();
        $conn->close();
        
        return $users;
    } catch (Exception $e) {
        error_log("Error fetching users: " . $e->getMessage());
        return [];
    }
}
?>
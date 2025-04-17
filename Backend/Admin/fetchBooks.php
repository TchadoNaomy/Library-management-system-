<?php
require_once __DIR__ . '/../connection.php';

function getBooks() {
    $books = array();
    
    try {
        // Create new connection using GLOBALS
        $conn = new mysqli($GLOBALS['hostname'], $GLOBALS['servername'], 
                         $GLOBALS['password'], $GLOBALS['dbname']);
        
        // Check connection
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }

        $query = "SELECT * FROM books ORDER BY added_date DESC";
        $result = $conn->query($query);
        
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Convert BLOB to base64 when fetching
                if ($row['book_cover']) {
                    $row['book_cover'] = base64_encode($row['book_cover']);
                }
                $books[] = $row;
            }
            $result->close();
        }

        $conn->close();
        return $books;
        
    } catch (Exception $e) {
        error_log("Error in getBooks: " . $e->getMessage());
        if (isset($conn)) {
            $conn->close();
        }
        return array();
    }
}

// Debug: Test the function
$result = getBooks();
error_log("Total books returned: " . count($result));
?>
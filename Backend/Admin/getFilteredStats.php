<?php
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $startDate = $_GET['startDate'];
    $endDate = $_GET['endDate'];
    
    try {
        // Get filtered counts
        $stats = array();
        
        // Count users registered between dates
        $userQuery = "SELECT COUNT(*) as total FROM user 
                     WHERE created_at BETWEEN ? AND ?";
        $stmt = $conn->prepare($userQuery);
        $stmt->bind_param("ss", $startDate, $endDate);
        $stmt->execute();
        $result = $stmt->get_result();
        $stats['users'] = $result->fetch_assoc()['total'];
        
        // Count books added between dates
        $bookQuery = "SELECT SUM(quantity) as total FROM books 
                     WHERE added_date BETWEEN ? AND ?";
        $stmt = $conn->prepare($bookQuery);
        $stmt->bind_param("ss", $startDate, $endDate);
        $stmt->execute();
        $result = $stmt->get_result();
        $stats['books'] = $result->fetch_assoc()['total'];
        
        // Count borrowings between dates
        $borrowQuery = "SELECT COUNT(*) as total FROM borrowing_book 
                       WHERE borrow_date BETWEEN ? AND ?";
        $stmt = $conn->prepare($borrowQuery);
        $stmt->bind_param("ss", $startDate, $endDate);
        $stmt->execute();
        $result = $stmt->get_result();
        $stats['borrowed'] = $result->fetch_assoc()['total'];
        
        header('Content-Type: application/json');
        echo json_encode($stats);
        
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
}
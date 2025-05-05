<?php
// src/backend/swaps/request_swap.php

// Start session to access user data
session_start();

// Include database connection
require_once '../config/db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header('Location: /src/frontend/components/signin/index.html');
    exit;
}

// Function to get user's items for swap
function getUserItems($userId, $conn) {
    // This is a placeholder for the actual database query
    // In a real implementation, you would query the database for items created by the user

    try {
        $stmt = $conn->prepare("SELECT id, title, image_url FROM swaps WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Log error and return empty array
        error_log("Error fetching user items: " . $e->getMessage());
        return [];
    }
}

// If this is an AJAX request to get user's items
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get_items') {
    $userId = $_SESSION['user_id'];
    $items = getUserItems($userId, $conn);

    // Return items as JSON
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'items' => $items]);
    exit;
}

// Check if form was submitted for a swap request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $requestedItemId = $_POST['requested_item_id'] ?? '';
    $swapItemId = $_POST['swap_item_id'] ?? '';
    $userId = $_SESSION['user_id'];

    // Validate input
    if (empty($requestedItemId) || empty($swapItemId)) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields']);
        exit;
    }

    // Verify that the swap item belongs to the current user
    // This is important for security to prevent users from offering items they don't own
    $userItems = getUserItems($userId, $conn);
    $userItemIds = array_column($userItems, 'id');

    if (!in_array($swapItemId, $userItemIds)) {
        echo json_encode(['success' => false, 'message' => 'You can only offer items that you own']);
        exit;
    }

    // TODO: Insert swap request into database
    // This is a placeholder for the actual database insertion
    // In a real implementation, you would create a new record in a swap_requests table

    // For now, just return success
    echo json_encode(['success' => true, 'message' => 'Swap request submitted successfully']);
    exit;
} else {
    // If not a POST or valid GET request, redirect to swaps page
    if (!isset($_GET['action']) || $_GET['action'] !== 'get_items') {
        header('Location: /src/frontend/components/swaps/index.html');
        exit;
    }
}

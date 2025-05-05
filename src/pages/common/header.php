<?php
require_once realpath(__DIR__ . '/../../includes/db_conn.php');
require_once realpath(__DIR__ . '/../../includes/auth.php');
?>

<div class="header-shipping-notice">
    Free shipping for all orders above 50 MYR!
</div>

<!-- Sidebar Navigation -->
<div id="mySidebar" class="header-sidebar">
    <a href="javascript:void(0)" class="closebtn">&times;</a>
    <a href="/src/pages/index.php">Home</a>
    <a href="/src/pages/recycling/index.php">Recycling</a>
    <a href="/src/pages/blogs_all/index.php">All Blogs</a>
    <!-- <button class="community_gardening">Community Gardening
        <i class="fa fa-caret-down"></i>
    </button>
    <div class="gardening-container">
        <a href="#">All Community Gardening</a>
        <a href="#">My Garden</a>
    </div>

    <button class="swap">Eco-friendly Product Swap
        <i class="fa fa-caret-down"></i>
    </button>
    <div class="swap-container">
        <a href="#">All Swaps</a>
        <a href="#">My Swaps</a>
    </div> -->
    <a href="/src/pages/gardening/index.php">Gardening</a>
    <a href="/src/pages/swaps/index.php">Swaps</a>
</div>
</div>


<header class="header-sticky-navbar">
    <div class="header-navbar">
        <div class="header-navbar-left">
            <img src="/src/images/burgerMenu.png" alt="Menu Icon" class="icon" id="menuBtn">
        </div>

        <div class="header-logo">
            <a href="/src/pages/index.php">
                <img src="/src/images/Ellipse 1.svg" alt="Logo" class="header-logo-icon">
                <span class="header-logo-text"> ECOCOM</span>
            </a>
        </div>

        <div class="header-navbar-right">
            <div class="header-notification-container">
                <div class="notification-icon-wrapper">
                    <img src="/src/images/notification.svg" alt="Notification Icon"
                        style="width: 30px; height: 30px; position: relative; top: -1px;" class="icon"
                        id="notificationBtn">
                    <!-- PHP will render the actual count here -->
                    <span class="notification-badge" id="notificationBadge">0</span>
                </div>
                <div class="header-notification-dropdown" id="notificationDropdown">
                    <div class="notification-header">
                        <h3>Notifications</h3>
                    </div>
                    <div class="notification-list" id="notificationList">
                        <!-- PHP will render notifications here -->
                        <!-- Example notification item for swap request -->
                        <?php
                        // Get user ID from the session
                        $user_id = $_SESSION['user_id'];

                        // Get notifications from the database
                        $query = "SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC LIMIT 10";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("i", $user_id);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        // Render the notifications
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $notification_id = $row['id'];
                                $type = $row['type'];
                                $message = $row['message'];
                                $created_at = $row['created_at'];

                                echo "<div class='notification-item' data-id='{$notification_id}' data-type='{$type}'>";
                                echo "<div class='notification-content'>";
                                echo "<p>{$message}</p>";
                                echo "<span class='notification-time'>{$created_at}</span>";
                                echo "</div>";

                                if ($type == 'swap_request' || $type == 'garden_exchange') {
                                    echo "<div class='notification-actions'>";
                                    echo "<button class='accept-btn' data-id='{$notification_id}'>Yes</button>";
                                    echo "<button class='reject-btn' data-id='{$notification_id}'>No</button>";
                                    echo "</div>";
                                }

                                echo "</div>";
                            }
                        }
                        ?>
                    </div>
                    <div class="notification-empty hidden">
                        <p>No new notifications</p>
                    </div>
                </div>
            </div>
            <div class="header-profile-container">
                <img src="/src/images/profile.png" alt="Person Icon" class="icon" id="profileBtn">
                <div class="header-profile-dropdown" id="profileDropdown">
                    <a href="/src/pages/profile/index.php">My Profile</a>
                    <a href="/src/pages/calendar/index.php">Calendar</a>
                    <a href="/src/pages/favourite/index.php">Favourite</a>
                    <a href="/src/pages/logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>
</header>

<script src="/src/pages/common/header.js"></script>
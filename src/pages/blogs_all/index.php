<?php
// Include database connection and authentication helper
require_once '../../includes/db_conn.php';
require_once '../../includes/auth.php';

// No login required for viewing blog posts
// Get user ID if logged in (for potential future features like favorites)
$user_id = isLoggedIn() ? getCurrentUserId() : null;

// Fetch all blog posts from the database
$blog_query = "
    SELECT b.*, u.username as author_name,
           DATE_FORMAT(b.created_at, '%M %d') as formatted_date
    FROM blog_posts b
    JOIN users u ON b.author_id = u.id
    ORDER BY b.created_at DESC
";

$blog_result = $conn->query($blog_query);
$blog_posts = [];
if ($blog_result) {
    while ($row = $blog_result->fetch_assoc()) {
        $blog_posts[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blog Posts</title>
  <link rel="stylesheet" href="index.css">
  <link rel="stylesheet" href="/src/css/header.css">
  <link rel="stylesheet" href="/src/css/footer.css">
  <link rel="stylesheet" href="/src/css/common.css">
  <link href='https://fonts.googleapis.com/css?family=Source Sans Pro' rel='stylesheet'>
</head>

<body>

  <!-- Header will be loaded here -->
  <?php include '../common/header.php'; ?>

  <div class="card-container">
    <?php if (empty($blog_posts)): ?>
      <p class="no-posts-message">No blog posts available at the moment.</p>
    <?php else: ?>
      <?php foreach ($blog_posts as $post): ?>
        <div class="card">
          <a href="/src/pages/blogs/index.php?id=<?php echo $post['id']; ?>">
            <img src="<?php echo !empty($post['image_url']) ? $post['image_url'] : '/src/frontend/images/blogpic1.jpg'; ?>" alt="<?php echo htmlspecialchars($post['title']); ?>">
          </a>
          <div class="card-content">
            <h2 class="card-title"><?php echo htmlspecialchars($post['title']); ?></h2>
            <p class="card-date">Created by <strong class="card-date-real"><?php echo htmlspecialchars($post['author_name']); ?></strong></p>
            <p class="card-location">Updated on <?php echo $post['formatted_date']; ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

  <!-- Footer will be loaded here -->
  <?php include '../common/footer.php'; ?>

</body>

</html>

<?php
session_start();
session_destroy();
header("Location: /src/pages/signin/index.php");
exit;
?>
<?php
// index.php additions
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require '../admin/config/database.php';

// Sử dụng prepared statement cho user info query
if(isset($_SESSION["login"]) && $_SESSION["login"] === true){
    $id = $_SESSION["id"];
    $stmt = $conn->prepare("SELECT * FROM tb_login WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/fonts/fontawesome-free-6.1.1-web/css/all.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300&display=swap" rel="stylesheet" />
    
    <link rel="stylesheet" href="../assets/css/base/normalize.css" />
    <link rel="stylesheet" href="../assets/css/index.css" />
    <link rel="stylesheet" href="../assets/css/base/base.css" />
    <link rel="stylesheet" href="../assets/css/responsive.css" />
    <link rel="stylesheet" href="../assets/css/components/menu.css" />
    <link rel="stylesheet" href="../assets/css/base/scroll_bar.css" />
    <link rel="stylesheet" href="../assets/css/components/loading.css" />
    <link rel="stylesheet" href="../assets/css/components/animation.css" />
    <title>Light Book - Bạn của sách</title>
</head>
<body>
<?php
  
  // Include the header
  include 'header.php';

  // Include the main content
  include 'content.php';

  // Include the footer
  include 'footer.php';
?> 

<script src="main.js"></script>
</body>
</html>
     



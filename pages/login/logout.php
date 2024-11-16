<?php
session_start();

// Sửa lại đường dẫn, lùi ra 1 cấp thư mục vì logout.php nằm trong thư mục Login
require '../../admin/config/database.php';  // thay vì require 'page\config.php'

// Hủy tất cả các biến session
$_SESSION = array();

// Hủy session
session_destroy();

// Chuyển hướng về trang chủ
// Sử dụng đường dẫn tương đối, lùi ra 2 cấp để về thư mục gốc
header("Location: ../../public/index.php");
exit();
?>
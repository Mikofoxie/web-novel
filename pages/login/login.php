<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require '../../admin/config/database.php';

if (isset($_POST["login-submit"])) {
    // Validate and sanitize input
    $usernameemail = filter_input(INPUT_POST, "usernameemail", FILTER_SANITIZE_STRING);
    $password = $_POST["password"];
    $remember = isset($_POST["remember-login"]) ? true : false;

    if (empty($usernameemail) || empty($password)) {
        echo "<script>alert('Vui lòng điền đầy đủ thông tin!'); window.location.href = '../../public/index.php';</script>";
        exit();
    }

    try {
        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT id, username, email, password FROM tb_login WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $usernameemail, $usernameemail);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            
            // Verify password
            if (password_verify($password, $row["password"])) {
                // Set session variables
                $_SESSION["login"] = true;
                $_SESSION["id"] = $row["id"];
                $_SESSION["username"] = $row["username"];

                // Handle "Remember Me" functionality
                if ($remember) {
                    // Generate secure token
                    $token = bin2hex(random_bytes(32));
                    $user_id = $row["id"];
                    
                    // Store token in database
                    $stmt = $conn->prepare("UPDATE tb_login SET remember_token = ? WHERE id = ?");
                    $stmt->bind_param("si", $token, $user_id);
                    $stmt->execute();
                    
                    // Set cookie that expires in 30 days
                    setcookie("remember_token", $token, time() + (86400 * 30), "/", "", true, true);
                }

                // Redirect to home page
                header("Location: ../../public/index.php");
                exit();
            } else {
                echo "<script>alert('Sai mật khẩu!'); window.location.href = '../../public/index.php';</script>";
            }
        } else {
            // Use generic error message for security
            echo "<script>alert('Thông tin đăng nhập không chính xác!'); window.location.href = '../../public/index.php';</script>";
        }
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo "<script>alert('Có lỗi xảy ra, vui lòng thử lại sau!'); window.location.href = '../../public/index.php';</script>";
    }
}

// Check for "Remember Me" cookie
if (!isset($_SESSION["login"]) && isset($_COOKIE["remember_token"])) {
    $token = filter_input(INPUT_COOKIE, "remember_token", FILTER_SANITIZE_STRING);
    
    $stmt = $conn->prepare("SELECT id, username FROM tb_login WHERE remember_token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION["login"] = true;
        $_SESSION["id"] = $row["id"];
        $_SESSION["username"] = $row["username"];
    }
}
?>
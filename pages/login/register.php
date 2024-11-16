<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require '../../admin/config/database.php';

if (isset($_POST["submit"])) {
    // Validate input
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $password = $_POST["password"];
    $confirmpassword = $_POST["confirmpassword"];
    $agreeTerms = isset($_POST["agree-to-the-terms"]) ? true : false;

    // Basic validation
    $errors = [];
    if (empty($username) || strlen($username) < 3) {
        $errors[] = "Tên người dùng phải có ít nhất 3 ký tự";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email không hợp lệ";
    }
    if (strlen($password) < 8) {
        $errors[] = "Mật khẩu phải có ít nhất 8 ký tự";
    }
    if (!$agreeTerms) {
        $errors[] = "Bạn phải đồng ý với điều khoản và dịch vụ";
    }

    if (empty($errors)) {
        // Prepare statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM tb_login WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>
                alert('Username hoặc Email của bạn đã tồn tại!');
                window.location.href = '../../public/index.php';
                </script>";
            exit;
        } else {
            if ($password === $confirmpassword) {
                // Hash password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                // Insert new user
                $stmt = $conn->prepare("INSERT INTO tb_login (username, email, password) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $username, $email, $hashed_password);
                
                if ($stmt->execute()) {
                    // Set session variables for newly registered user
                    $_SESSION["login"] = true;
                    $_SESSION["id"] = $stmt->insert_id;
                    
                    echo "<script>
                        alert('Đăng ký thành công!');
                        window.location.href = '../../public/index.php';
                        </script>";
                    exit;
                } else {
                    echo "<script>
                        alert('Có lỗi xảy ra, vui lòng thử lại!');
                        window.location.href = '../../public/index.php';
                        </script>";
                    exit;
                }
            } else {
                echo "<script>
                    alert('Mật khẩu xác nhận không khớp!');
                    window.location.href = '../../public/index.php';
                    </script>";
                exit;
            }
        }
    } else {
        echo "<script>
            alert('".implode("\\n", $errors)."');
            window.location.href = '../../public/index.php';
            </script>";
        exit;
    }
}
?>
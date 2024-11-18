<?php
require_once '../admin/config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $title = $_POST['title'] ?? '';
    $author = $_POST['author'] ?? '';
    $illustrator = $_POST['illustrator'] ?? '';
    $translator = $_POST['translator'] ?? '';
    $price = $_POST['price'] ?? 0;
    $page_count = $_POST['page_count'] ?? 0;
    $isbn = $_POST['isbn'] ?? '';
    $publisher = $_POST['publisher'] ?? '';
    $publish_year = $_POST['publish_year'] ?? 0;
    $book_size = $_POST['book_size'] ?? '';
    $cover_type = $_POST['cover_type'] ?? '';
    $category = $_POST['category'] ?? ''; 
    $gifts = $_POST['gifts'] ?? '';
    $description= $_POST['description'] ?? '';

    // Xử lý upload ảnh
    $target_dir = "../uploads/images/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $target_file = $target_dir . time() . '_' . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    
    
    // Kiểm tra file ảnh hợp lệ
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check === false) {
        header("Location: add_product.php?error=not_image");
        exit();
    }

    // Kiểm tra định dạng file
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        header("Location: add_product.php?error=invalid_format");
        exit();
    }

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        try {
            // Thêm sản phẩm vào database
            $sql = "INSERT INTO books (
                title, author, illustrator, translator, price, page_count, 
                isbn, publisher, publish_year, book_size, 
                cover_type, category, gifts, image_url, description
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                throw new Exception("Lỗi prepare statement: " . $conn->error);
            }

            $stmt->bind_param("ssssdississssss", 
                $title, $author, $illustrator, $translator, $price, $page_count,
                $isbn, $publisher, $publish_year, $book_size,
                $cover_type, $category, $gifts, $target_file, $description
            );

            if ($stmt->execute()) {
                header("Location: index.php?msg=success");
            } else {
                throw new Exception("Lỗi execute statement: " . $stmt->error);
            }
            $stmt->close();
        } catch (Exception $e) {
            // Log lỗi và hiển thị thông báo
            error_log($e->getMessage());
            header("Location: add_product.php?error=db_error&message=" . urlencode($e->getMessage()));
        }
    } else {
        header("Location: add_product.php?error=upload_failed");
    }
}

$conn->close();
?>
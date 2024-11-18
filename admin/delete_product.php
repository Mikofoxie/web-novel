<?php
require_once '../admin/config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = intval($_GET['id']); // Đảm bảo id là số nguyên

    try {
        // Bắt đầu transaction
        $conn->begin_transaction();

        // 1. Lấy và xóa ảnh
        $sql_get_image = "SELECT image_url FROM books WHERE id = ?";
        $stmt_get_image = $conn->prepare($sql_get_image);
        if ($stmt_get_image === false) {
            throw new Exception("Lỗi prepare statement: " . $conn->error);
        }

        $stmt_get_image->bind_param("i", $id);
        $stmt_get_image->execute();
        $result = $stmt_get_image->get_result();
        $stmt_get_image->close();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $image_path = $row['image_url'];

            // Xóa file ảnh khỏi thư mục nếu tồn tại
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }

        // 2. Xóa sản phẩm
        $sql_delete = "DELETE FROM books WHERE id = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        if ($stmt_delete === false) {
            throw new Exception("Lỗi prepare statement: " . $conn->error);
        }

        $stmt_delete->bind_param("i", $id);
        if (!$stmt_delete->execute()) {
            throw new Exception("Lỗi khi xóa sản phẩm: " . $stmt_delete->error);
        }
        $stmt_delete->close();

        // 3. Sắp xếp lại ID
        // Tạo bảng tạm để lưu ID mới
        $sql_reorder = "
            SET @count = 0;
            UPDATE books SET id = @count:= @count + 1 ORDER BY id;
        ";
        $conn->multi_query($sql_reorder);
        while ($conn->next_result()) {;} // clear multi_query results

        // 4. Reset auto_increment
        $sql_reset = "ALTER TABLE books AUTO_INCREMENT = 1";
        $conn->query($sql_reset);

        // Commit transaction nếu mọi thứ OK
        $conn->commit();
        header("Location: index.php?msg=deleted");

    } catch (Exception $e) {
        // Rollback nếu có lỗi
        $conn->rollback();
        error_log($e->getMessage());
        header("Location: index.php?error=db_error&message=" . urlencode($e->getMessage()));
    }
} else {
    header("Location: index.php?error=invalid_request");
}

$conn->close();
?>
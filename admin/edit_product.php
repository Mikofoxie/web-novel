<?php
// Kết nối cơ sở dữ liệu
require_once '../admin/config/database.php';

if (!isset($_GET['id'])) {
    die('Không tìm thấy sản phẩm!');
}

$id = intval($_GET['id']);

// Lấy thông tin sản phẩm từ cơ sở dữ liệu
$sql = $conn->prepare("SELECT * FROM books WHERE id = ?");
$sql->bind_param("i", $id);
$sql->execute();
$result = $sql->get_result();

if ($result->num_rows === 0) {
    die('Sản phẩm không tồn tại!');
}

$product = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $illustrator = $_POST['illustrator'];
    $translator = $_POST['translator'] ?? null;
    $price = $_POST['price'];
    $page_count = $_POST['page_count'] ?? null;
    $isbn = $_POST['isbn'] ?? null;
    $publisher = $_POST['publisher'] ?? null;
    $publish_year = $_POST['publish_year'] ?? null;
    $book_size = $_POST['book_size'] ?? null;
    $cover_type = $_POST['cover_type'] ?? null;
    $category = $_POST['category'] ?? null;
    $gifts = $_POST['gifts'] ?? null;
    $description = $_POST['description'] ?? null;


    
    

    // Xử lý upload ảnh
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../admin/uploads/images/';
        $image_name = basename($_FILES['image']['name']);
        $target_path = $upload_dir . $image_name;

        // Kiểm tra và di chuyển file
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
            $image_url = 'uploads/images/' . $image_name;
        } else {
            die('Lỗi khi upload ảnh!');
        }
    } else {
        // Giữ lại URL ảnh cũ nếu không upload mới
        $image_url = $product['image_url'];
    }

    // Chuẩn bị câu lệnh UPDATE
    $update_sql = $conn->prepare("
        UPDATE books
        SET title = ?, author = ?, illustrator = ?, translator = ?, price = ?, page_count = ?, isbn = ?, publisher = ?, 
            publish_year = ?, book_size = ?, cover_type = ?, category = ?, gifts = ?, image_url = ?, description = ?
        WHERE id = ?
    ");
    
    $update_sql->bind_param(
        "ssssdississssssi",
        $title, 
        $author, 
        $illustrator, 
        $translator, 
        $price, 
        $page_count, 
        $isbn, 
        $publisher,
        $publish_year, 
        $book_size, 
        $cover_type, 
        $category, 
        $gifts, 
        $image_url, 
        $description, 
        $id
    );

    // Thực thi câu lệnh
    if ($update_sql->execute()) {
        header("Location: index.php?message=Cập nhật sản phẩm thành công!");
        exit;
    } else {
        echo "Lỗi: " . $update_sql->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa Sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./styles/AdminEditProduct.css">
</head>
<body>
    <div class="container mt-4 mb-4">
        <h2>Chỉnh sửa Sản phẩm</h2>
        <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
                <label for="title" class="form-label">Tên sách</label>
                <input type="text" name="title" id="title" class="form-control" value="<?php echo htmlspecialchars($product['title']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="author" class="form-label">Tác giả</label>
                <input type="text" name="author" id="author" class="form-control" value="<?php echo htmlspecialchars($product['author']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="illustrator" class="form-label">Vẽ minh hoạ</label>
                <input type="text" name="illustrator" id="illustrator" class="form-control" value="<?php echo htmlspecialchars($product['illustrator']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="translator" class="form-label">Người dịch</label>
                <input type="text" name="translator" id="translator" class="form-control" value="<?php echo htmlspecialchars($product['translator']); ?>">
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Giá</label>
                <input type="number" step="0.01" name="price" id="price" class="form-control" value="<?php echo htmlspecialchars($product['price']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="page_count" class="form-label">Số trang</label>
                <input type="number" name="page_count" id="page_count" class="form-control" min="1" required oninput="this.value = Math.abs(this.value)" value="<?php echo htmlspecialchars($product['page_count']); ?>">
            </div>
            <div class="mb-3">
                <label for="isbn" class="form-label">ISBN</label>
                <input type="text" name="isbn" id="isbn" class="form-control" value="<?php echo htmlspecialchars($product['isbn']); ?>">
            </div>
            <div class="mb-3">
                <label for="publisher" class="form-label">Nhà xuất bản</label>
                <input type="text" name="publisher" id="publisher" class="form-control" value="<?php echo htmlspecialchars($product['publisher']); ?>">
            </div>
            <div class="mb-3">
                <label for="publish_year" class="form-label">Năm xuất bản</label>
                <input type="number" name="publish_year" id="publish_year" class="form-control" value="<?php echo htmlspecialchars($product['publish_year']); ?>">
            </div>
            <div class="mb-3">
                <label for="book_size" class="form-label">Kích thước</label>
                <input type="text" name="book_size" id="book_size" class="form-control" value="<?php echo htmlspecialchars($product['book_size']); ?>">
            </div>
            <div class="mb-3">
                <label for="cover_type" class="form-label">Loại bìa</label>
                <input type="text" name="cover_type" id="cover_type" class="form-control" value="<?php echo htmlspecialchars($product['cover_type']); ?>">
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Thể loại</label>
                <input type="text" name="category" id="category" class="form-control" value="<?php echo htmlspecialchars($product['category']); ?>">
            </div>

            <div class="mb-3">
                <label for="gifts" class="form-label">Quà tặng</label>
                <textarea rows="2" name="gifts" id="gifts" class="form-control"><?php echo htmlspecialchars($product['gifts']); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Ảnh sản phẩm</label>
                <input type="file" name="image" id="image" class="form-control">
            
            </div>
            <div class="mb-3">
                <?php if (!empty($product['image_url'])): ?>
                        <p style="margin-bottom: 10px;">Ảnh hiện tại: </p>
                        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="Sản phẩm" class="product-image" style="width: 150px; height: auto; object-fit:cover;">
                    <?php endif; ?>
            </div>

            <div class="mb-3 col-12">
                    <label for="description" class="form-label">Mô tả sản phẩm</label>
                    <textarea 
                    class="form-control" 
                    id="description" 
                    name="description" 
                    rows="14"
                    cols="30"
                    placeholder="Nhập mô tả chi tiết về sản phẩm..."
                    ><?php echo htmlspecialchars($product['description']); ?></textarea>
                </div>

            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
            <a href="index.php" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
</body>
</html>

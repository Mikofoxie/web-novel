<?php
require_once '../admin/config/database.php'
?>

<!-- index.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Quản lý Sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .product-image {
            width: 100px;
            height: auto;
        }
        .action-buttons {
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Quản lý Sản phẩm</h2>
            <a href="add_product.php" class="btn btn-success">
                <i class="fas fa-plus"></i> Thêm Sản phẩm
            </a>
        </div>

        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Hình ảnh</th>
                    <th>Tên sách</th>
                    <th>Giá</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Lấy danh sách sản phẩm
                $sql = "SELECT id, title, price, image_url FROM books ORDER BY id DESC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>".$row['id']."</td>";
                       
                        echo '<div class="product-item-img" style="background-image: url(\'../' . htmlspecialchars($row['image_url']) . '\');"></div>';
                       
                        echo "<td>".$row['title']."</td>";
                        echo "<td>".number_format($row['price'], 0, ',', '.')."đ</td>";
                        echo "<td class='action-buttons'>";
                        echo "<a href='edit_product.php?id=".$row['id']."' class='btn btn-primary btn-sm me-2'><i class='fas fa-edit'></i> Sửa</a>";
                        echo "<button onclick='deleteProduct(".$row['id'].")' class='btn btn-danger btn-sm'><i class='fas fa-trash'></i> Xóa</button>";
                        echo "</td>";
                        echo "</tr>";
                    }

                } else {
                    echo "<tr><td colspan='5' class='text-center'>Không có sản phẩm nào</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function deleteProduct(id) {
            if(confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
                window.location.href = 'delete_product.php?id=' + id;
            }
        }
    </script>
</body>
</html>
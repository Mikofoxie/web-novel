<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Sản phẩm Mới</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./styles/AdminAddProduct.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Thêm Sản phẩm Mới</h2>
        <form action="process_add.php" method="POST" enctype="multipart/form-data" class="mb-5">
            <div class="row">
                <!-- Cột trái -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="title" class="form-label">Tên sách</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>

                    <div class="mb-3">
                        <label for="author" class="form-label">Tác giả</label>
                        <input type="text" class="form-control" id="author" name="author" required>
                    </div>

                    <div class="mb-3">
                        <label for="illustrator" class="form-label">Vẽ minh hoạ</label>
                        <input type="text" class="form-control" id="illustrator" name="illustrator" required>
                    </div>

                    <div class="mb-3">
                        <label for="translator" class="form-label">Dịch giả</label>
                        <input type="text" class="form-control" id="translator" name="translator">
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Giá (VNĐ)</label>
                        <input type="number" class="form-control" id="price" name="price" required>
                    </div>

                    <div class="mb-3">
                        <label for="page_count" class="form-label">Số trang</label>
                        <input type="number" class="form-control" id="page_count" name="page_count" min="1" required oninput="this.value = Math.abs(this.value)" placeholder="Vui lòng nhập số trang">
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">Thể loại</label>
                        <input type="text" class="form-control" id="category" name="category" required>
                    </div>

                </div>

                <!-- Cột phải -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="isbn" class="form-label">ISBN</label>
                        <input type="text" class="form-control" id="isbn" name="isbn">
                    </div>

                    <div class="mb-3">
                        <label for="publisher" class="form-label">Nhà xuất bản</label>
                        <input type="text" class="form-control" id="publisher" name="publisher">
                    </div>

                    <div class="mb-3">
                        <label for="publish_year" class="form-label">Năm xuất bản</label>
                        <input type="number" class="form-control" id="publish_year" name="publish_year" 
                               min="1900" max="<?php echo date('Y'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="book_size" class="form-label">Khổ sách</label>
                        <input type="text" class="form-control" id="book_size" name="book_size" placeholder="VD: 18 x 13 cm">
                    </div>

                    <div class="mb-3">
                        <label for="cover_type" class="form-label">Loại bìa</label>
                        <select class="form-select" id="cover_type" name="cover_type">
                            <option value="Bìa mềm">Bìa mềm</option>
                            <option value="Bìa cứng">Bìa cứng</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="gifts" class="form-label">Quà tặng kèm</label>
                        <input type="text" class="form-control" id="gifts" name="gifts">
                    </div>
                </div>

                <!-- Phần hình ảnh -->
                <div class="col-12 mb-3">
                    <label for="image" class="form-label">Hình ảnh sản phẩm</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                </div>

                <div class="mb-3 col-12">
                    <label for="description" class="form-label">Mô tả sản phẩm</label>
                    <textarea 
                    class="form-control" 
                    id="description" 
                    name="description" 
                    rows="5"
                    placeholder="Nhập mô tả chi tiết về sản phẩm..."
                    ></textarea>
                </div>
                
                <!-- Nút submit và quay lại -->
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
                    <a href="index.php" class="btn btn-secondary">Quay lại</a>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
  <!-- Slider Begin-->
  <div class="slider">
    <div class="slides">
      <input
        type="radio"
        name="radio-btn"
        id="radio1"
        class="btn-move-img" />
      <input
        type="radio"
        name="radio-btn"
        id="radio2"
        class="btn-move-img" />
      <input
        type="radio"
        name="radio-btn"
        id="radio3"
        class="btn-move-img" />
      <div class="slide first">
        <img
          src="../assets/img/slider/lightnovel.jpg"
          alt=""
          class="photos" />
      </div>
      <div class="slide">
        <img
          src="../assets/img/slider/date-a-live.png"
          alt=""
          class="photos" />
      </div>
      <div class="slide">
        <img
          src="../assets/img/slider/2gether-main-banner.jpg"
          alt=""
          class="photos" />
      </div>
      <div class="navigation-auto">
        <div class="auto-btn1"></div>
        <div class="auto-btn2"></div>
        <div class="auto-btn3"></div>
      </div>
      <div class="navigation-manual">
        <label for="radio1" class="manual-btn"></label>
        <label for="radio2" class="manual-btn"></label>
        <label for="radio3" class="manual-btn"></label>
      </div>
    </div>
  </div>
  <!-- Slider End -->

  <!-- Main Begin -->
  <div class="container">
    <section class="introduct-content width-content full-width">
      <div class="row-introduct-content">
        <div class="introduct-content-info column-4 full-width">
          <div class="wrap-introduct-content-info">
            <div class="wrap-content-img" style="width: 21%">
              <img src="../assets/img/features/rocket.png" alt="" />
            </div>
            <div class="wrap-text-content">
              <p class="text-content">
                Light Book - Giao hàng nhanh, truyền tải đam mê sách đến mọi
                ngóc ngách đất nước.
              </p>
            </div>
          </div>
        </div>
        <div class="introduct-content-info column-4 full-width">
          <div class="wrap-introduct-content-info">
            <div class="wrap-content-img">
              <img src="../assets/img/features/clock.png" alt="" />
            </div>
            <div class="wrap-text-content">
              <p class="text-content">
                Tin tức về lịch phát hành, sự kiện luôn được cập nhật thường
                xuyên cho người đọc.
              </p>
            </div>
          </div>
        </div>
        <div class="introduct-content-info column-4 full-width">
          <div class="wrap-introduct-content-info">
            <div class="wrap-content-img">
              <img src="../assets/img/features/zoom.png" alt="" />
            </div>
            <div class="wrap-text-content">
              <p class="text-content">
                Những ưu đãi đặc biệt dành cho độc giả - sự thú vị đến từ
                nhà sách Light Book
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Product 1 favorite books -->
    <section class="product">
      <div
        class="container-product width-content width-t full-width width-1k width-500">
        <div class="product-heading-title">Sách được yêu thích</div>
        <div class="product-heading-separator">
          <span class="product-heading-separator-element">
            <div class="product-icon-book">
              <i class="ri-book-open-fill icon-book"></i>
            </div>
          </span>
        </div>
        <div class="row-product">
          <?php
          $sql = "SELECT * FROM books";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo '<div class="home-product-item column-2 t-col-3 m-col-6 m-col-12 col-3-1269">';
              echo '<a href="../pages/products/product-' . $row['id'] . '.html">';
              echo '<div class="product-item-img" style="background-image: url(\'../admin/' . htmlspecialchars($row['image_url']) . '\');"></div>';

              echo '</a>';
              echo '<div class="home-product-info">';
              echo '<div class="home-product-title" title="' . htmlspecialchars($row['title']) . '">';
              echo '<p>' . htmlspecialchars($row['title']) . '</p>';
              echo '</div>';
              echo '<div class="home-product-author">';
              echo '<p><span>Tác giả: </span>' . htmlspecialchars($row['author']) . '</p>';
              echo '</div>';
              echo '<div class="home-product-price">';
              echo '<span class="home-product-price-new">' . number_format($row['price'], 0, ',', '.') . 'đ</span>';
              // Thêm giá cũ nếu có
              echo '</div>';
              echo '<div class="home-product-buy">';
              echo '<a href="../pages/products/product-' . $row['id'] . '.html" class="home-product-btn-buy">Mua ngay</a>';
              echo '<div style="clear: both"></div>';
              echo '</div>';
              echo '</div>';
              echo '</div>';
            }
          } else {
            echo '<strong>Không có sản phẩm nào!</strong>';
          }
          $conn->close();
          ?>
        </div>
      </div>
      <div class="button-link">
        <a href="" class="btn-more">Xem thêm</a>
      </div>
    </section>


    <!-- Product 2 selling books -->
    <section class="product-selling-book">
  <div class="container-product width-content width-t full-width width-1k width-500">
    <div class="product-heading-title">Sách được bán chạy nhiều nhất</div>
    <div class="product-heading-separator">
      <span class="product-heading-separator-element">
        <div class="product-icon-book">
          <i class="ri-book-open-fill icon-book"></i>
        </div>
      </span>
    </div>
    <div class="row-product">
      <?php
      include '../admin/config/database.php';
      // Truy vấn dữ liệu sách
      $sql = "SELECT * FROM books WHERE price BETWEEN 0 AND 100000";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              echo '<div class="home-product-item column-2 t-col-3 m-col-6 m-col-12 col-3-1269">';
              echo '<a href="../pages/products/product-' . $row['id'] . '.html">';
              echo '<div class="product-item-img" style="background-image: url(\'../admin/' . htmlspecialchars($row['image_url']) . '\');"></div>';
              echo '</a>';
              echo '<div class="home-product-info">';
              echo '<div class="home-product-title" title="' . htmlspecialchars($row['title']) . '">';
              echo '<p>' . htmlspecialchars($row['title']) . '</p>';
              echo '</div>';
              echo '<div class="home-product-author">';
              echo '<p><span>Tác giả: </span>' . htmlspecialchars($row['author']) . '</p>';
              echo '</div>';
              echo '<div class="home-product-price">';
              echo '<span class="home-product-price-new">' . number_format($row['price'], 0, ',', '.') . 'đ</span>';
              if (!empty($row['old_price'])) {
                  echo '<span class="home-product-price-old">' . number_format($row['old_price'], 0, ',', '.') . 'đ</span>';
              }
              echo '</div>';
              echo '<div class="home-product-buy">';
              echo '<a href="../pages/products/product-' . $row['id'] . '.html" class="home-product-btn-buy">Mua ngay</a>';
              echo '<div style="clear: both"></div>';
              echo '</div>';
              echo '</div>';
              echo '</div>';
          }
      } else {
          echo '<strong>Không có sản phẩm bán chạy nào</strong>';
      }
      ?>

    </div>
  </div>
  <div class="button-link">
    <a href="" class="btn-more">Xem thêm</a>
  </div>
</section>



  </div>
  <!-- Main end -->
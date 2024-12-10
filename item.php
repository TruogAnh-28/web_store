<?php
    require_once 'config.php';
    require_once("services/connect_db.php");

    if(isset($_POST['content'])){
        if (strlen(trim($_POST['content']))) {
            require_once("services/connect_db.php");
            $productid = $_GET['id'];
            $account = $_SESSION["user"];
            $user_id = $_SESSION["user_id"];
            $content = $_POST["content"];
            $commentQuery = "insert into comments(user_id,product_id,date,content) values('$user_id',$productid,now(),'$content')";
            mysqli_query($connect, $commentQuery);
            echo"<script>alert('Your comment will appear soon') </script>";
        }
    }
?>
<?php
    require_once("services/connect_db.php");
    $id = $_GET['id'];
    $query = "select * from products where product_id='$id'";
    $result = mysqli_query($connect, $query);
    $item = mysqli_fetch_array($result);
    require_once "layout/navigation.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <title>Chi tiết sản phẩm</title>
  <style>
    body {
      font-family: Arial, sans-serif;
    }

    .product-container {
      display: flex;
      flex-wrap: wrap;
      margin: 20px 0;
    }

    .product-image {
      max-width: 100%;
      border-radius: 10px;
      margin-bottom: 15px;
    }

    .product-content {
      padding: 15px;
      background-color: #f8f9fa;
      border-radius: 10px;
    }

    .content-price {
      font-size: 1.5rem;
      color: #dc3545;
      font-weight: bold;
    }

    .comment-container {
      margin-top: 30px;
    }

    .comment-content {
      padding: 15px;
      background: #f1f1f1;
      
      border-radius: 10px;
    }

    .submit-btn {
      margin-top: 10px;
    }

    .quantity-selector button {
      margin: 0 5px;
    }

    .buy-btn {
      margin-top: 20px;
      width: 100%;
    }

    .comment-header h3 {
      margin-bottom: 15px;
    }
    .comment-container {
    width: 100%;
    margin: 20px 0;
}

    .comment-header {
        margin-bottom: 20px;
    }

    .comments-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 20px; /* Khoảng cách giữa các thẻ */
        margin-bottom: 20px;
    }

    .comment-card {
        flex: 1 1 calc(50% - 20px); /* Mỗi nhận xét chiếm 50% chiều rộng trừ đi khoảng cách */
        border: 1px solid #ddd;
        padding: 10px;
        position: relative; /* Để đặt ngày ở góc trên */
    }

    .comment-header {
        display: flex;
        justify-content: space-between; /* Canh đều hai bên */
        font-size: 14px;
        color: #555;
        margin-bottom: 10px;
    }

    .comment-user {
        font-weight: bold;
        color: #333;
    }

    .comment-date {
        color: #888;
        font-size: 12px;
    }

    .comment-content {
        color: #333;
        font-size: 14px;
        line-height: 1.6;
    }
    textarea {
      padding: 10px;
    }
  </style>
</head>

<body>
  <div class="container mt-4">
    <div class="row">
      <div class="col-md-6">
        <img class="product-image" src="/<?php echo $item['image']; ?>" alt="Product Image">
      </div>
      <div class="col-md-6">
        <div class="product-content">
          <h2><?php echo $item['name'] ?></h2>
          <p class="content-price"><?php echo number_format($item['price']) . ' VND' ?></p>
          <div class="content-size mb-3">
            <p><strong>Kích Thước:</strong></p>
            <form class="d-flex flex-wrap">
              <label class="me-2">
                <input type="radio" name="size" value="S"> S
              </label>
              <label class="me-2">
                <input type="radio" name="size" value="M"> M
              </label>
              <label class="me-2">
                <input type="radio" name="size" value="L"> L
              </label>
              <label class="me-2">
                <input type="radio" name="size" value="XL"> XL
              </label>
              <label>
                <input type="radio" name="size" value="XXL"> XXL
              </label>
            </form>
          </div>
          <!-- <div class="content-quantity mb-3">
            <p><strong>Số Lượng:</strong> <span id="quantity">1</span></p>
            <div class="quantity-selector">
              <button class="btn btn-outline-primary" onclick="increment()">+</button>
              <button class="btn btn-outline-secondary" onclick="decrement()">-</button>
            </div>
          </div> -->
          
          <form method="POST" action="/cart.php?action=add">
            <?php echo '<input id="demoInput" type="number" min=0 max=100 value="1" name="quantity[' . $item['product_id'] . ']" class="form-control mb-2">'; ?>
            <input class="btn btn-danger buy-btn" type="submit" value="Mua sản phẩm">
          </form>
          <div class="mt-4">
            <h4>Giới thiệu sản phẩm:</h4>
            <p><?php echo $item['description'] ?></p>
          </div>
        </div>
      </div>
    </div>

    <!-- Comment Section -->
    <div class="comment-container">
    <?php
        require_once("services/connect_db.php");
        $productid = $_GET['id']; // Lấy ID sản phẩm từ URL
        // Truy vấn JOIN bảng comments và users
        $getCommentsQuery = "
            SELECT comments.content, users.username, comments.date 
            FROM comments 
            JOIN users ON comments.user_id = users.user_id 
            WHERE comments.product_id = $productid
        ";
        
        // Kiểm tra kết nối trước khi thực hiện truy vấn
        if ($connect) {
            $allCommentsOfProducts = mysqli_query($connect, $getCommentsQuery);

            // Nếu truy vấn thành công, kiểm tra dữ liệu
            if ($allCommentsOfProducts && mysqli_num_rows($allCommentsOfProducts) > 0) {
                ?>
                <div class="comment-header">
                    <h3>Đánh giá sản phẩm: (<?= mysqli_num_rows($allCommentsOfProducts) ?> đánh giá)</h3>
                </div>
                <div class="comments-grid">
                <?php
                // Hiển thị tất cả các nhận xét
                while ($comment = mysqli_fetch_assoc($allCommentsOfProducts)) {
                    ?>
                    <div class="comment-card">
                        <section class="comment-header">
                            <span class="comment-user"><?= htmlspecialchars($comment['username']) ?></span>
                            <span class="comment-date"><?= date("d/m/Y", strtotime($comment['date'])) ?></span>
                        </section>
                        <section class="comment-content"><?= htmlspecialchars($comment['content']) ?></section>
                    </div>
                    <?php
                }
                ?>
                </div>
                <?php
            } else {
                // Không có đánh giá
                echo "<h2 style='color:green; margin-top:15px;'>Không có đánh giá nào!</h2>";
            }
        }
    ?>
    <?php if (isset($_SESSION["user"])) { ?>
        <!-- Form để gửi nhận xét -->
        <section>
            <form method="post" action="">
                <section>
                    <textarea name="content" id="" cols="30" rows="3" style="width:100%" placeholder="Viết đánh giá về sản phẩm"></textarea>
                </section>
                <section>
                    <input class="btn btn-primary submit-btn" type="submit" value="Gửi đánh giá">
                </section>
            </form>
        </section>
    <?php } ?>
</div>



  <script>
    function increment() {
      var value = parseInt(document.getElementById('demoInput').value, 10);
      value = isNaN(value) ? 0 : value;
      value++;
      document.getElementById('demoInput').value = value;
      document.getElementById('quantity').innerHTML = value;
    }

    function decrement() {
      var value = parseInt(document.getElementById('demoInput').value, 10);
      value = isNaN(value) ? 0 : value;
      value = value <= 1 ? 1 : value - 1;
      document.getElementById('demoInput').value = value;
      document.getElementById('quantity').innerHTML = value;
    }
  </script>
</body>

</html>
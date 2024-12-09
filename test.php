<?php
    require_once 'config.php';
    require_once("services/connect_db.php");

    if(isset($_POST['content'])){
        if (strlen(trim($_POST['content']))) {
            require_once("services/connect_db.php");
            $productid = $_GET['id'];
            $account = $_SESSION["user"];
            $content = $_POST["content"];
            $commentQuery = "insert into comments(account,productid,date,content) values('$account',$productid,now(),'$content')";
            mysqli_query($connect, $commentQuery);
            echo"<script>alert('Your comment will appear soon') </script>";
        }
    }
?>
<?php
    require_once("services/connect_db.php");
    $id = $_GET['id'];
    $query = "select * from db_products where id='$id'";
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
  <link rel="stylesheet" href="css/item.css">
  <title>KARANTS</title>
</head>
<style>
<?php require_once 'css/item.css';

?>
</style>

<body>
  <div class="container">
    <div class="product-container">
      <img class="product-image" src="<?php echo $item['image'] ?>" alt="Card image cap">
      <div class="product-content">
        <a class="font-weight-bold content-name"> <?php echo $item['name'] ?> </a>
        <p class="content-price"> <?php echo number_format($item['price']) . ' VND' ?></p>
        <div class="content-size">
          <a>Kích Thước:</a>
          <form class="boxed size-form">
            <input type="radio" id="S-size" name="size" value="S">
            <label for="S-size">S</label>
            <input type="radio" id="M-size" name="size" value="M">
            <label for="M-size">M</label>
            <input type="radio" id="L-size" name="size" value="L">
            <label for="L-size">L</label>
            <input type="radio" id="XL-size" name="size" value="XL">
            <label for="XL-size">XL</label>
            <input type="radio" id="XXL-size" name="size" value="XXL">
            <label for="XXL-size">XXL</label>
          </form>
        </div>
        <br>
        <div class="content-quantity">
          <a class="font-weight-bold">Số Lượng: <span id="quantity">1</span></a>
        </div>
        <div class="quantity-selector">
          <div class="change-quantity">
            <button class="quantity-btn" onclick="increment()">&#9650</button>
            <button class="quantity-btn" onclick="decrement()">&#9660</button>
          </div>
          <div class="quantity-form">
            <form method="POST" action="/cart.php?action=add" autocomplete="off">
              <?php echo '<input id="demoInput" type="number" min=0 max=100 value="1" name="quantity[' . $item['id'] .']">' ?>
              <input class="btn btn-primary buy-btn" type="submit" value="Mua sản phẩm">
            </form>
          </div>
        </div>
        </br>
        </br>
        <span class="font-weight-bold">Giới thiệu sản phẩm:</span>
        <p class="content-description"><?php echo $item['description'] ?></p>
      </div>
    </div>
    <div class="comment-container">
      <!-- show comment -->
      <?php
                require_once("services/connect_db.php");
                $productid = $_GET['id'];
                $getCommentsQuery = "select * from comments where productid = $productid";
                $allCommentsOfProducts = mysqli_query($connect, $getCommentsQuery);
                ?>
      <?php
                if(mysqli_num_rows($allCommentsOfProducts) == 0) {
            ?>
      <h2 style='color:green; margin-top:15px;'>Không có đánh giá nào!</h2>
      <?php
                        if(isset($_SESSION["user"])){
                    ?>
      <section>
        <form method="post" action="">
          <section>
            <textarea name="content" id="" cols="30" rows="3" style="width:100%" placeholder=" Comment here"></textarea>
          </section>
          <section>
            <input class="btn btn-primary submit-btn" type="submit" value="Gửi đánh giá">
          </section>
        </form>
      </section>
      <?php
                        }
                    ?>
      <?php
                } else {
            ?>
      <div class="comment-header">
        <h3>Đánh giá sản phẩm: </h3>
        <h3 class="comment-number" style="font-style:italic">(<?=mysqli_num_rows($allCommentsOfProducts)?> đánh giá)
        </h3>
      </div>
      <!-- comment -->
      <?php
                        if(isset($_SESSION["user"])){
                    ?>
      <section>
        <form method="post" action="">
          <section>
            <textarea name="content" id="" cols="30" rows="3" style="width:100%" placeholder=" Comment here"></textarea>
          </section>
          <section>
            <input class="btn btn-primary submit-btn" type="submit" value="Gửi đánh giá">
          </section>
        </form>
      </section>
      <?php
                        }
                    ?>
      <?php
                        foreach($allCommentsOfProducts as $comment) {
                    ?>
      <div class="comment-content">
        <section style='font-weight:bold;'>Tài khoản: <span><?=$comment['account']?></span></section>
        <section style='padding-left:1%;'>Nội dung đánh giá: <?=$comment['content']?></section>
      </div>
      <br>
      <?php
                        }
                }   
            $connect->close();
                    ?>
    </div>
  </div>

  <?php include 'layout/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
    integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
    integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
  </script>

  <!-- Script for quantity increase/decrease -->
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
    value < 2 ? value = 2 : '';
    value--;
    document.getElementById('demoInput').value = value;
    document.getElementById('quantity').innerHTML = value;
  }
  </script>

</body>

</html>
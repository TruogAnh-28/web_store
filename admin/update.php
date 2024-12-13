<?php
  $id = $_GET["id"];
  require_once("services/connect_db.php");
  $item = mysqli_fetch_array($connect->query("SELECT * from products WHERE product_id='$id'"));
?>
<?php
  if (isset($_POST['name'])) {
    $name = mysqli_real_escape_string($connect, $_POST['name']); 
    $price = $_POST['price'];
    $image = mysqli_real_escape_string($connect, $_POST['image']);
    $description = mysqli_real_escape_string($connect, $_POST['description']);
    require_once("services/connect_db.php");
    // $_POST = null;
    var_dump($_POST);//exit();
    $updateQuery = "UPDATE products set name='$name',price = $price,image='$image', description='$description' where product_id='$id'";
    $result1 =  mysqli_query($connect, $updateQuery);
    if (!$result1) {
      printf("Error: %s\n", mysqli_error($connect));
      exit();
    }
    echo "<script>
            alert('Sản phẩm đã được cập nhật !');
            window.location.href='products.php';
          </script>";
    $connect->close();
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/update.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    <title>ADMIN</title>
</head>
<body>
    <?php include "layouts/appbar.php"; ?>
    <div class="wrapper">
        <div class="content">
            <div class="form-container">
                <div class="form-title">
                    <span style="font-size: 24px">Cập nhật sản phẩm</span>
                </div>
                <form class="form-content" method="POST" autocomplete="off">
                <div>
                    <div class="left-form product-name">Tên sản phẩm</div>
                    <input name="name"  value="<?=$item['name']?>" type="text" class="form-control" placeholder="Name..." required>
                </div>
                <div >
                    <div class="left-form product-price">Đơn giá</div>
                    <input name="price"  value="<?=$item['price']?>" type="text" class="form-control" placeholder="Price..." required>
                </div>
                <div >
                    <div class="left-form product-image">Hình ảnh</div>
                    <input name="image" value="<?=$item['image']?>" type="text" class="form-control" placeholder="Link Image...">
                </div>

                <div >
                    <div class="left-form product-description">Mô tả sản phẩm</div>
                    <input name="description"  value="<?=$item['description']?>" type="text" class="form-control" placeholder="Description..." required>
                </div>
                <button class="btn btn-primary submit-btn" type="submit" >Cập nhật sản phẩm</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>





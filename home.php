<?php
    $search = '';
    if (isset($_GET["search"])) {
        $search = htmlspecialchars($_GET["search"]);

        if ($search === "") {

            if (isset($_GET["page"])) {
                header("location: ./index.php?page=" . $_GET["page"]);
            } else {
                header("location: ./index.php");
            }
        }

        require_once("services/connect_db.php");
        $stmt = $connect->prepare('SELECT * FROM products WHERE NAME LIKE ?');
        $searchQuery ="%".$search."%";
        $stmt->bind_param('s',  $searchQuery);
        $stmt->execute();
        $fullProducts = $stmt->get_result();

        //paging
        $page = 1;
        if(isset($_GET['page'])){
            $page = $_GET['page'];
        }

        $productsPerPage = 8;
        $from = ($page-1) * $productsPerPage;
        // $fullProducts = mysqli_query($connect, $query);
        $totalPages = ceil(mysqli_num_rows($fullProducts) / $productsPerPage);

        $query2 = $connect->prepare('SELECT * FROM products WHERE NAME LIKE ? limit ?,?');
        $query2->bind_param('sss', $searchQuery, $from, $productsPerPage);
        $query2->execute();
        $resultsearch = $query2->get_result();

        $datasearch = [];
        while ($row = mysqli_fetch_array($resultsearch, 1)) {
            $datasearch[] = $row;
        }
        $items = $datasearch;
        $connect->close();
    } else {
        require_once("services/connect_db.php");
        $query1 =  "SELECT * from products";

        //paging
        $page = 1;
        if(isset($_GET['page'])){
            $page = $_GET['page'];
        }

        $productsPerPage = 2;
        $from = ($page - 1) * $productsPerPage;
        $fullProducts = mysqli_query($connect, $query1);
        $totalPages = ceil(mysqli_num_rows($fullProducts) / $productsPerPage);
        // printf($totalPages);

        $query1.=" limit $from,$productsPerPage";
        // query DB
        $result1 = mysqli_query($connect, $query1);
        if (!$result1) {
            printf("Error: %s\n", mysqli_error($connect));
            exit();
        }
        while ($row1 = mysqli_fetch_array($result1,1)) {
            $data[] = $row1;
        }
        $items = $data;
        $connect->close();
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="css/home.css">
  <style>
    .carousel-item {
      transition: transform 0 ease-in-out, opacity 0 ease-in-out;
    }
  </style>
  <title>Coolmate Inspired Shop</title>
</head>
 <?php include "layout/navigation.php"; ?>
<body>
<div id="carouselBanner" class="carousel slide carousel-fade mb-5" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="image/banner1.png" class="d-block w-100" alt="Banner 1" style="height: 500px; object-fit: cover;">
    </div>
    <div class="carousel-item">
      <img src="image/banner2.png" class="d-block w-100" alt="Banner 2" style="height: 500px; object-fit: cover;">
    </div>
    <div class="carousel-item">
      <img src="image/banner3.png" class="d-block w-100" alt="Banner 3" style="height: 500px; object-fit: cover;">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselBanner" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselBanner" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

  <div class="container mt-5">
    <!-- Tìm kiếm -->
    <div class="search-bar">
      <h5 class="mb-4">Tìm sản phẩm bạn thích:</h5>
      <form class="row g-3" action="index.php" method="GET">
        <div class="col-md-10">
          <input type="text" class="form-control" placeholder="Tìm tên sản phẩm" aria-label="Search" name="search">
        </div>
        <div class="col-md-2 text-end">
          <button type="submit" class="btn btn-dark">Tìm kiếm</button>
        </div>
      </form>
    </div>

    <!-- Kết quả tìm kiếm -->
    <div class="section-header mt-4">
      <?php if (!isset($_GET["search"])): ?>
        <h3 class="text-uppercase fw-bold">Sản phẩm</h3>
      <?php else: ?>
        <h3 class="text-uppercase fw-bold">Kết quả tìm kiếm: <?php echo $search; ?></h3>
      <?php endif; ?>
    </div>

    <!-- Sản phẩm -->
    <div class="row mt-4">
      <?php foreach ($items as $item): ?>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
          <div class="card h-100 border-0 shadow">
            <a href="item.php/?id=<?php echo $item['product_id']; ?>" class="text-decoration-none">
              <img src="<?php echo $item['image']; ?>" class="card-img-top img-fluid" alt="<?php echo $item['name']; ?>" style="height: 300px; object-fit: cover;">
            </a>
            <div class="card-body text-center">
              <a href="item.php/?id=<?php echo $item['product_id']; ?>" class="text-dark text-decoration-none">
                <h5 class="card-title fw-bold"><?php echo $item['name']; ?></h5>
              </a>
              <p class="card-text text-primary fw-bold"><?php echo number_format($item['price']); ?>đ</p>
              <p class="card-text text-muted small"><?php echo $item['description']; ?></p>
              <form class="d-flex justify-content-between" method="POST" action="/cart.php?action=add">
                <input type="hidden" value="1" name="quantity[<?php echo $item['product_id']; ?>]">
                <button class="btn btn-danger btn-sm">Mua ngay</button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="addToCart(<?php echo $item['product_id']; ?>)">Thêm vào giỏ</button>
              </form>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-5">
      <?php require_once "layout/pagination.php"; ?>
    </div>
  </div>

  <script>
    const addToCart = (id) => {
      fetch('/cart.php?action=add', {
        method: 'POST',
        body: (() => {
          var formData = new FormData();
          formData.append(`quantity[${id}]`, 1);
          return formData;
        })()
      })
        .then(response => {
          alert("Thêm vào giỏ hàng thành công!");
        })
        .catch(error => {
          alert("Thêm vào giỏ hàng thất bại!");
        });
    }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

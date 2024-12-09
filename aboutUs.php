<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.0.2/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="css/aboutUs.css">
  <title>KARANTS - Phong cách thời trang hiện đại</title>
</head>

<body>
  <?php 
    require_once 'config.php';
    require_once("services/connect_db.php");
  ?>
  <div class="navigation-wrapper">
    <?php include "layout/navigation.php"; ?>
  </div>


  <!-- Header Section -->
  <header class="text-center py-5 bg-dark text-white">
    <div class="container">
      <h1>KARANTS</h1>
      <p class="lead">Khám phá phong cách thời trang hiện đại, đậm chất riêng của bạn.</p>
    </div>
  </header>

  <!-- Introduction Section -->
  <section class="my-5">
    <div class="container">
      <div class="text-center mb-4">
        <h2 class="font-weight-bold">Chào mừng đến với KARANTS</h2>
        <p>Điểm đến cho những tín đồ thời trang Gen Z, nơi hội tụ phong cách và cá tính.</p>
      </div>
      <div class="row">
        <div class="col-md-6 mb-4">
          <img src="./image/about.png" class="img-fluid rounded" alt="Fashion Style">
        </div>
        <div class="col-md-6">
          <h3>Phong cách đa dạng</h3>
          <p>Chúng tôi tự hào mang đến những thiết kế trẻ trung, năng động và sáng tạo, phù hợp với xu hướng thời trang mới nhất. Từ những trang phục hằng ngày đến những bộ cánh sang trọng, KARANTS đều đáp ứng mọi nhu cầu của bạn.</p>
          <p>Với slogan <span style="font-weight: bold;">“Be The Best Of You”</span>, Karants mong ước muốn mang đến cái đẹp cho tất cả mọi người và được góp phần tạo dựng hình ảnh mới - lạ - đẹp cho thời trang Việt Nam, Karants đã tập trung đầu tư vào chất lượng và kiểu dáng sản phẩm phù hợp với giá thành để thương hiệu KARANTS luôn là sự lựa chọn tốt nhất của bạn.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Our Mission Section -->
  <section class="bg-light py-5">
    <div class="container">
      <div class="text-center mb-4">
        <h2 class="font-weight-bold">Sứ mệnh của chúng tôi</h2>
        <p>Cùng bạn định hình phong cách và khẳng định cá tính.</p>
      </div>
      <div class="row text-center">
        <div class="col-md-4">
          <img src="./image/mission1.png" alt="Icon 1" class="mb-3" style="width: 300px;">
          <h5>Đổi mới</h5>
          <p>Luôn cập nhật những xu hướng thời trang mới nhất để mang đến sự đổi mới không ngừng.</p>
        </div>
        <div class="col-md-4">
          <img src="./image/mission2.png" alt="Icon 2" class="mb-3" style="width: 300px;">
          <h5>Chất lượng</h5>
          <p>Sản phẩm được thiết kế và hoàn thiện tỉ mỉ để đảm bảo sự hài lòng của khách hàng.</p>
        </div>
        <div class="col-md-4">
          <img src="./image/mission3.png" alt="Icon 3" class="mb-3" style="width: 300px;">
          <h5>Cộng đồng</h5>
          <p>Kết nối những người yêu thời trang, cùng chia sẻ và lan tỏa phong cách.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Gallery Section -->
  <section class="py-5">
    <div class="container">
      <h2 class="text-center font-weight-bold mb-4">Bộ sưu tập nổi bật</h2>
      <div class="row">
        <div class="col-md-4 mb-3">
          <img src="./image/bst1.png" class="img-fluid rounded" alt="Collection 1">
        </div>
        <div class="col-md-4 mb-3">
          <img src="./image/bst2.png" class="img-fluid rounded" alt="Collection 2">
        </div>
        <div class="col-md-4 mb-3">
          <img src="./image/bst3.png" class="img-fluid rounded" alt="Collection 3">
        </div>
      </div>
    </div>
  </section>

  <!-- Call to Action Section -->
  <section class="bg-dark text-white text-center py-5">
    <div class="container">
      <h3>Khám phá ngay phong cách của bạn tại KARANTS</h3>
      <a href="index.php" class="btn btn-primary btn-lg mt-3">Mua sắm ngay</a>
    </div>
  </section>

  <?php require_once "layout/footer.php"; ?>
</body>

</html>

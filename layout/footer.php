<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>Footer</title>
  <style>
    body {
      margin: 0;
      font-family: 'Arial', sans-serif;
      background-color: #f9f9f9;
    }

    .footer-container {
      background: linear-gradient(135deg, #1a1a1a, #3a3a3a);
      color: #ffffff;
      padding: 2rem 0;
      font-size: 0.9rem;
    }

    .footer-container .container {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      gap: 2rem;
    }

    .footer-container .brand {
      flex: 1;
      min-width: 250px;
    }

    .footer-container .brand h2 {
      font-size: 2rem;
      color: #ff4c60;
    }

    .footer-container .brand p {
      line-height: 1.5;
      margin: 1rem 0;
    }

    .footer-container .social-icons {
      display: flex;
      gap: 1rem;
    }

    .footer-container .social-icons a {
      color: #fff;
      font-size: 1.5rem;
      transition: 0.3s ease;
    }

    .footer-container .social-icons a:hover {
      color: #ff4c60;
    }

    .footer-container .links,
    .footer-container .policies {
      flex: 1;
      min-width: 200px;
    }

    .footer-container h3 {
      margin-bottom: 1rem;
      font-size: 1.2rem;
      border-bottom: 2px solid #ff4c60;
      display: inline-block;
      padding-bottom: 0.2rem;
    }

    .footer-container ul {
      list-style: none;
      padding: 0;
    }

    .footer-container ul li {
      margin: 0.5rem 0;
    }

    .footer-container ul li a {
      color: #ccc;
      text-decoration: none;
      transition: 0.3s ease;
    }

    .footer-container ul li a:hover {
      color: #ff4c60;
    }

    .footer-container .contact {
      flex: 1;
      min-width: 250px;
    }

    .footer-container .contact ul {
      list-style: none;
      padding: 0;
    }

    .footer-container .contact ul li {
      margin: 0.5rem 0;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .footer-container .contact ul li i {
      font-size: 1.2rem;
    }

    .footer-container .newsletter {
      margin-top: 1rem;
    }

    .footer-container .newsletter input {
      padding: 0.5rem;
      border: none;
      width: calc(100% - 100px);
      margin-right: 1rem;
      border-radius: 5px;
    }

    .footer-container .newsletter button {
      padding: 0.5rem 1rem;
      border: none;
      background: #ff4c60;
      color: #fff;
      border-radius: 5px;
      cursor: pointer;
      transition: 0.3s ease;
    }

    .footer-container .newsletter button:hover {
      background: #ff6a76;
    }

    .footer-bottom {
      text-align: center;
      margin-top: 2rem;
      border-top: 1px solid #444;
      padding-top: 1rem;
      color: #aaa;
    }
  </style>
</head>

<body>
  <footer class="footer-container">
    <div class="container">
      <div class="brand">
        <h2>KARANTS</h2>
        <p>
          Khám phá phong cách hiện đại và sáng tạo với KARANTS – nơi hội tụ thời trang và cảm hứng.
        </p>
        <div class="social-icons">
          <a href="https://www.facebook.com" target="_blank"><i class="fa fa-facebook"></i></a>
          <a href="https://twitter.com" target="_blank"><i class="fa fa-twitter"></i></a>
          <a href="https://www.instagram.com" target="_blank"><i class="fa fa-instagram"></i></a>
          <a href="https://www.youtube.com" target="_blank"><i class="fa fa-youtube"></i></a>
        </div>
      </div>
      <div class="links">
        <h3>Liên Kết Nhanh</h3>
        <ul>
          <li><a href="/home.php">Trang Chủ</a></li>
          <li><a href="#">Sản Phẩm</a></li>
          <li><a href="#">Giới Thiệu</a></li>
          <li><a href="#">Liên Hệ</a></li>
        </ul>
      </div>
      <div class="policies">
        <h3>Chính Sách</h3>
        <ul>
          <li><a href="#">Chính Sách Đổi Trả</a></li>
          <li><a href="#">Chính Sách Bảo Mật</a></li>
          <li><a href="#">Thông Tin Giao Hàng</a></li>
          <li><a href="#">Điều Khoản Sử Dụng</a></li>
        </ul>
      </div>
      <div class="contact">
        <h3>Liên Hệ</h3>
        <ul>
          <li><i class="fa fa-map-marker"></i> 123 Thủ Đức, TP.HCM</li>
          <li><i class="fa fa-phone"></i> +84 123 456 789</li>
          <li><i class="fa fa-envelope"></i> hotro@KARANTS.vn</li>
        </ul>
      
      </div>
    </div>
    <div class="footer-bottom">
      &copy; 2024 KARANTS. All rights reserved.
    </div>
  </footer>
</body>

</html>

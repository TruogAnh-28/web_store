<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KARANTS</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .navbar {
            background: linear-gradient(135deg, #1a1a1a, #3a3a3a);
        }

        .navbar-brand {
            color: #ff4c60 !important;
            font-weight: bold;
            font-size: 1.5rem;
        }

        .navbar-nav .nav-link {
            color: #fff !important;
            margin: 0 0.5rem;
            transition: 0.3s ease;
            display: flex;
            align-items: center;
        }

        .navbar-nav .nav-link:hover {
            color: #ff4c60 !important;
        }

        .navbar-nav .nav-link i {
            margin-right: 0.5rem;
            font-size: 1rem;
        }

        .navbar-toggler {
            border: none;
            color: #fff;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(255,255,255,0.7)' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
        }

        .helloUser {
            color: #ff4c60;
            margin-right: 1rem;
            font-weight: bold;
        }

        .navbar span img {
            vertical-align: middle;
            transition: transform 0.3s ease;
        }

        .navbar span img:hover {
            transform: scale(1.2);
        }

        .cart-icon img {
            filter: invert(1);
        }
    </style>
</head>

<body>
    <div class="account">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">KARANTS</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/users.php"><i class="fas fa-users-cog"></i>Quản lý tài khoản</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/products.php"><i class="fas fa-cogs"></i>Quản lý sản phẩm</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/comments.php"><i class="fas fa-comment-dots"></i>Đánh giá</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/orders.php"><i class="fas fa-list-alt"></i>Danh sách đơn hàng</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/login.php"><i class="fas fa-sign-out-alt"></i>Đăng xuất</a>
                        </li>
                    </ul>
                </div>
            </div>
            <span>
                <?php echo '<span class="helloUser">admin </span>' ?>
            </span>
        </nav> 
    </div>
</body>

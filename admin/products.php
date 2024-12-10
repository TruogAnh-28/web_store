<?php
// Xử lý thêm sản phẩm
if (isset($_POST['name'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $description = $_POST['description'];
    require_once("services/connect_db.php");
    $query1 = "INSERT INTO products(name, price, image, description) 
               VALUES('$name', '$price', '$image', '$description')";
    $result1 = mysqli_query($connect, $query1);
    echo "<script>alert('Sản phẩm đã được thêm!')</script>";
}

// Xử lý xóa sản phẩm
if (isset($_GET["id"])) {
    require_once("services/connect_db.php");
    $id = $_GET["id"];
    $query = "DELETE FROM products WHERE product_id='$id'";
    mysqli_query($connect, $query);
    echo "<script>alert('Sản phẩm $id đã bị xoá!')</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <style>
        .table-container {
            padding: 40px;
        }
        .btn-action {
            width: 80px;
            margin-bottom: 10px;
        }
    </style>
    <title>Quản lý sản phẩm</title>
</head>
<body>
    <?php session_start(); ?>
    <?php include "layouts/appbar.php"; ?>

    <div class="table-container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Quản lý sản phẩm</h2>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                Thêm sản phẩm
            </button>
        </div>

        <!-- Bảng danh sách sản phẩm -->
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th style="width: 5%">ID</th>
                    <th style="width: 30%">Sản phẩm</th>
                    <th style="width: 10%">Đơn giá</th>
                    <th style="width: 20%">Hình ảnh</th>
                    <th style="width: 25%">Mô tả sản phẩm</th>
                    <th style="width: 10%">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once("services/connect_db.php");
                $query = "SELECT * FROM products";
                $result = mysqli_query($connect, $query);
                while ($item = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    echo "
                    <tr>
                        <td class='text-center'>{$item['product_id']}</td>
                        <td>{$item['name']}</td>
                        <td class='text-center'>{$item['price']}</td>
                        <td class='text-center'><img src='/{$item['image']}' alt='{$item['name']}' style='width: 100px; height: auto;'></td>
                        <td>{$item['description']}</td>
                        <td class='text-center'>
                            <a class='btn btn-primary btn-sm btn-action' href='update.php?id={$item['product_id']}'>Cập nhật</a>
                            <a class='btn btn-danger btn-sm btn-action' href='?id={$item['product_id']}'>Xóa</a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal Thêm sản phẩm -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm sản phẩm mới</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="products.php" autocomplete="off">
                        <div class="mb-3">
                            <label for="productName" class="form-label">Tên sản phẩm</label>
                            <input id="productName" name="name" type="text" class="form-control" placeholder="Tên sản phẩm" required>
                        </div>
                        <div class="mb-3">
                            <label for="productPrice" class="form-label">Đơn giá</label>
                            <input id="productPrice" name="price" type="text" class="form-control" placeholder="Đơn giá" required>
                        </div>
                        <div class="mb-3">
                            <label for="productImage" class="form-label">Link hình ảnh</label>
                            <input id="productImage" name="image" type="text" class="form-control" placeholder="Link hình ảnh">
                        </div>
                        <div class="mb-3">
                            <label for="productDescription" class="form-label">Mô tả sản phẩm</label>
                            <textarea id="productDescription" name="description" class="form-control" placeholder="Mô tả sản phẩm" required></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Huỷ</button>
                            <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Quản lý đánh giá</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .table-container {
            padding: 40px;
        }
        .action-btn {
            color: #fff;
            font-weight: bold;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .action-btn:hover {
            opacity: 0.9;
        }
        .btn-delete {
            background-color: #dc3545;
        }
    </style>
</head>
<body>
    <?php session_start(); ?>
    <?php include "layouts/appbar.php"; ?>

    <div class="table-container">
        <h2 class="mb-4">Quản lý đánh giá</h2>
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th scope="col" style="width: 5%;">STT</th>
                    <th scope="col" style="width: 20%;">Tài khoản đánh giá</th>
                    <th scope="col" style="width: 15%;">Sản phẩm đánh giá</th>
                    <th scope="col" style="width: 15%;">Thời gian</th>
                    <th scope="col" style="width: 35%;">Nội dung đánh giá</th>
                    <th scope="col" style="width: 10%;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if (isset($_GET["id"])) {
                require_once("services/connect_db.php");
                $id = $_GET["id"];
                $query = "DELETE FROM comments WHERE comment_id='$id'";
                mysqli_query($connect, $query);
                echo "<script>alert('Bình luận $id đã bị xoá');</script>";
            }

            // Kết nối cơ sở dữ liệu
            require_once("services/connect_db.php");

            // Truy vấn JOIN để lấy thông tin username và product name
            $query = "
                SELECT 
                    comments.comment_id AS comment_id,
                    users.username AS account,
                    products.name AS product_name,
                    comments.date,
                    comments.content
                FROM comments
                JOIN users ON comments.user_id = users.user_id
                JOIN products ON comments.product_id = products.product_id
            ";

            $result = mysqli_query($connect, $query);

            // Lưu dữ liệu vào mảng
            $data = [];
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $data[] = $row;
            }
            $connect->close();

            // Hiển thị dữ liệu
            $index = 1;
            foreach ($data as $item) {
                echo '
                <tr>
                    <td class="text-center">' . ($index++) . '</td>
                    <td class="text-center">' . htmlspecialchars($item['account']) . '</td>
                    <td class="text-center">' . htmlspecialchars($item['product_name']) . '</td>
                    <td class="text-center">' . htmlspecialchars($item['date']) . '</td>
                    <td>' . htmlspecialchars($item['content']) . '</td>
                    <td class="text-center">
                        <a href="?id=' . $item['comment_id'] . '" class="action-btn btn-delete">Xóa</a>
                    </td>
                </tr>';
            }
            ?>

            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>

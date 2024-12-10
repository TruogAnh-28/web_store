<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Quản lý Đơn hàng</title>
    <style>
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
        .btn-delete {
            background-color: #dc3545;
        }
        .btn-view {
            background-color: #007bff;
        }
    </style>
</head>
<body>
    <?php include "layouts/appbar.php"; ?>

    <div class="table-container">
        <h2 class="mb-4">Quản lý Đơn hàng</h2>
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Mã Đơn hàng</th>
                    <th scope="col">Khách hàng</th>
                    <th scope="col">Ngày đặt</th>
                    <th scope="col">Trạng thái</th>
                    <th scope="col">Thao tác</th>
                </tr>
            </thead>
            <tbody>
            <?php
            // Kết nối cơ sở dữ liệu
            require_once("services/connect_db.php");

            // Truy vấn lấy thông tin đơn hàng
            $query = "
                SELECT 
                    orders.order_id AS order_id,
                    orders.customer_id,
                    orders.order_date,
                    orders.status,
                    users.username AS customer_name
                FROM orders
                JOIN users ON orders.customer_id = users.user_id
            ";

            $result = mysqli_query($connect, $query);

            // Hiển thị dữ liệu
            $index = 1;
            while ($order = mysqli_fetch_assoc($result)) {
                echo '
                <tr>
                    <td>' . $index++ . '</td>
                    <td>' . htmlspecialchars($order['order_id']) . '</td>
                    <td>' . htmlspecialchars($order['customer_name']) . '</td>
                    <td>' . htmlspecialchars($order['order_date']) . '</td>
                    <td>' . htmlspecialchars($order['status']) . '</td>
                    <td class="text-center">
                        <a href="view_order.php?id=' . $order['order_id'] . '" class="action-btn btn-view btn btn-sm">Xem</a>
                        <a href="delete_order.php?id=' . $order['order_id'] . '" class="action-btn btn-delete btn btn-sm">Xóa</a>
                    </td>
                </tr>';
            }
            ?>
            </tbody>
        </table>
    </div>
</body>
</html>

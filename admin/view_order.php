<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Chi tiết Đơn hàng</title>
</head>
<body>
    <?php include "layouts/appbar.php"; ?>
    <div class="container mt-5">
        <h2>Chi tiết Đơn hàng</h2>
        <?php
        require_once("services/connect_db.php");

        // Lấy ID đơn hàng từ URL
        $order_id = $_GET['id'];

        // Truy vấn thông tin đơn hàng
        $query = "
            SELECT 
                orders.order_id AS order_id,
                orders.order_date,
                orders.status,
                users.username AS customer_name,
                users.address AS customer_address
            FROM orders
            JOIN users ON orders.customer_id = users.user_id
            WHERE orders.order_id = $order_id
        ";
        $result = mysqli_query($connect, $query);
        $order = mysqli_fetch_assoc($result);

        // Truy vấn sản phẩm trong đơn hàng
        $query_items = "
            SELECT 
                products.name AS product_name,  -- Lấy tên sản phẩm từ bảng products
                order_items.size,
                order_items.quantity,
                order_items.price
            FROM order_items
            JOIN products ON order_items.product_id = products.product_id  -- JOIN bảng order_items với products
            WHERE order_items.order_id = $order_id
        ";
        $result_items = mysqli_query($connect, $query_items);
        ?>
        <p><strong>Mã Đơn hàng:</strong> <?= htmlspecialchars($order['order_id']) ?></p>
        <p><strong>Khách hàng:</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
        <p><strong>Địa chỉ giao hàng:</strong> <?= htmlspecialchars($order['customer_address']) ?></p>
        <p><strong>Ngày đặt:</strong> <?= htmlspecialchars($order['order_date']) ?></p>
        <p><strong>Trạng thái:</strong> <?= htmlspecialchars($order['status']) ?></p>

        <h3>Sản phẩm trong đơn hàng</h3>
        <table class="table table-bordered">
    <thead>
        <tr>
            <th>Tên sản phẩm</th>
            <th>Số lượng</th>
            <th>Kích thước</th>
            <th>Giá</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($item = mysqli_fetch_assoc($result_items)): ?>
        <tr>
            <td><?= htmlspecialchars($item['product_name']) ?></td>
            <td><?= htmlspecialchars($item['quantity']) ?></td>
            <td><?= htmlspecialchars($item['size']) ?></td>
            <td><?= htmlspecialchars($item['price'] * $item['quantity']) ?></td>  <!-- Tính giá = price * quantity -->
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

    </div>
</body>
</html>

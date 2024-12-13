<?php
if (isset($_GET['id'])) {
    require_once("services/connect_db.php");
    $id = $_GET["id"];
    $query = "DELETE FROM orders WHERE order_id = $id";
    if (mysqli_query($connect, $query)) {
        echo "<script>alert('Đơn hàng $id đã bị xoá!');</script>";
    } else {
        echo "<script>alert('Xóa đơn hàng thất bại!');</script>";
    }
    echo "<script>window.location.href = 'orders.php';</script>";
} else {
    echo "<script>window.location.href = 'orders.php';</script>";
}
$conn->close();
?>
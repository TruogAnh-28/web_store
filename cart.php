<?php
require_once 'config.php';

if (!isset($_SESSION["user"])) {
    $_SESSION["cart"] = array();
    header("Location: ./login.php");
    exit();
}

if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = array();
}

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case "add":
            foreach ($_POST['quantity'] as $id => $quantity) {
                if (isset($_SESSION["cart"][$id])) {
                    // Ensure we're using a numeric value
                    $_SESSION["cart"][$id] = is_array($_SESSION["cart"][$id]) 
                        ? $quantity 
                        : (int)$_SESSION["cart"][$id] + $quantity;
                } else {
                    $_SESSION["cart"][$id] = $quantity;
                }
            }
            break;

        case "delete":
            if (isset($_GET['id'])) {
                unset($_SESSION["cart"][$_GET['id']]);
            }
            header("Location: ./cart.php");
            exit();

        case "submit":
            if (isset($_POST['update'])) {
                foreach ($_POST['quantity'] as $id => $quantity) {
                    $_SESSION["cart"][$id] = $quantity;
                }
            }

            if (isset($_POST['order'])) {
                require_once("services/connect_db.php");

                $userId = $_SESSION['user_id'];
                $totalMoney = 0;

                foreach ($_SESSION["cart"] as $itemId => $itemQty) {
                    $query = "SELECT price FROM products WHERE product_id = $itemId";
                    $result = mysqli_query($connect, $query);
                    $row = mysqli_fetch_assoc($result);
                    
                    // Ensure $itemQty is a numeric value
                    $itemQty = is_array($itemQty) ? $itemQty['quantity'] : $itemQty;
                    $totalMoney += $row['price'] * $itemQty;
                }

                $orderQuery = "INSERT INTO orders (customer_id, total_price, status, order_date) 
                               VALUES ('$userId', '$totalMoney', 'Đang xử lí', NOW())";
                if (mysqli_query($connect, $orderQuery)) {
                    $orderId = mysqli_insert_id($connect);

                    foreach ($_SESSION["cart"] as $itemId => $item) {
                        // Handle both array and scalar item representations
                        $quantity = is_array($item) ? $item['quantity'] : $item;
                        $size = isset($_POST['size'][$itemId]) ? $_POST['size'][$itemId] : 'M';
                        
                        $query = "SELECT price FROM products WHERE product_id = $itemId";
                        $result = mysqli_query($connect, $query);
                        $product = mysqli_fetch_assoc($result);

                        $orderItemQuery = "INSERT INTO order_items (order_id, product_id, quantity, price, size) 
                                           VALUES ('$orderId', '$itemId', '$quantity', '{$product['price']}', '$size')";
                        mysqli_query($connect, $orderItemQuery);
                    }

                    unset($_SESSION["cart"]);
                }

                header("Location: ./cart.php");
                exit();
            }
            break;

        case "update":
            if (isset($_POST['id']) && isset($_POST['quantity'])) {
                $id = $_POST['id'];
                $quantity = $_POST['quantity'];
                
                // Update quantity in session
                $_SESSION["cart"][$id] = $quantity;

                // Recalculate total money
                $totalMoney = 0;
                foreach ($_SESSION["cart"] as $itemId => $itemQty) {
                    $query = "SELECT price FROM products WHERE product_id = $itemId";
                    $result = mysqli_query($connect, $query);
                    $row = mysqli_fetch_assoc($result);
                    
                    // Ensure $itemQty is a numeric value
                    $itemQty = is_array($itemQty) ? $itemQty['quantity'] : $itemQty;
                    $totalMoney += $row['price'] * $itemQty;
                }

                // Get the specific item's price for subtotal
                $query = "SELECT price FROM products WHERE product_id = $id";
                $result = mysqli_query($connect, $query);
                $row = mysqli_fetch_assoc($result);
                $subtotal = $quantity * $row['price'];

                // Return both subtotal and total as JSON
                echo json_encode([
                    "subtotal" => $subtotal, 
                    "total" => $totalMoney
                ]);
                exit();
            }
            break;
    }
}

if (!empty($_SESSION["cart"])) {
    require_once("services/connect_db.php");
    $query = "SELECT * FROM products WHERE product_id IN (" . implode(",", array_keys($_SESSION["cart"])) . ")";
    $result = mysqli_query($connect, $query);
    while ($row1 = mysqli_fetch_array($result, 1)) {
        $data[] = $row1;
    }
}

// Adjust the HTML rendering to handle both array and scalar cart items
if (!empty($data)) {
    foreach ($data as $item) {
        $itemId = $item['product_id'];
        // Handle both array and scalar cart item representations
        $itemQty = is_array($_SESSION["cart"][$itemId]) 
            ? $_SESSION["cart"][$itemId]['quantity'] 
            : $_SESSION["cart"][$itemId];
        $itemSize = is_array($_SESSION["cart"][$itemId]) && isset($_SESSION["cart"][$itemId]['size'])
            ? $_SESSION["cart"][$itemId]['size']
            : 'M';

        $subtotal = $item['price'] * $itemQty;
        // Rest of the HTML rendering remains the same
    }
}
?>
<!-- Rest of the HTML remains the same as in the original file -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="css/footer.css">
    <style>
        .cart-container {
            margin-top: 20px;
        }

        .cart-table th,
        .cart-table td {
            vertical-align: middle;
            text-align: center;
        }

        .cart-table img {
            width: 80px;
            height: auto;
        }

        .total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
			margin-bottom: 40px;
            font-size: 18px;
        }

        .total span {
            font-weight: bold;
        }

        .total p {
            font-size: 24px;
            color: #dc3545;
        }
		.right{
			width: 100%;
			display: flex;
			justify-content: right;
		}
    </style>
    <title>Giỏ hàng</title>
</head>

<body>
    <?php include "./layout/navigation.php"; ?>

    <div class="container cart-container">
        <h2 class="text-center mb-4">Giỏ hàng của bạn</h2>

        <form method="POST" action="cart.php?action=submit" id="cart-form">
            <table class="table table-bordered cart-table">
                <thead class="table-dark">
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Đơn giá (VND)</th>
                        <th>Số lượng</th>
                        <th>Kích thước</th>
                        <th>Thành tiền (VND)</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $totalMoney = 0;
                    if (!empty($data)) {
                        foreach ($data as $item) {
                            $itemId = $item['product_id'];
                            
                            // Handle both array and scalar cart item representations
                            $itemQty = is_array($_SESSION["cart"][$itemId]) 
                                ? $_SESSION["cart"][$itemId]['quantity'] 
                                : $_SESSION["cart"][$itemId];
                            
                            $itemSize = is_array($_SESSION["cart"][$itemId]) && isset($_SESSION["cart"][$itemId]['size'])
                                ? $_SESSION["cart"][$itemId]['size']
                                : 'M';

                            $subtotal = $item['price'] * $itemQty;
                            echo "
                                <tr>
                                    <td class='text-start'>
                                        <img src='{$item['image']}' alt='{$item['name']}' />
                                        <div>{$item['name']}</div>
                                    </td>
                                    <td>" . number_format($item['price']) . "</td>
                                    <td>
                                        <input type='number' min='1' max='99' value='{$itemQty}' name='quantity[{$item['product_id']}]' class='form-control quantity' data-id='{$item['product_id']}' />
                                    </td>
                                    <td>
                                        <select name='size[{$item['product_id']}]' class='form-control'>
                                            <option value='M' " . ($itemSize == 'M' ? 'selected' : '') . ">M</option>
                                            <option value='L' " . ($itemSize == 'L' ? 'selected' : '') . ">L</option>
                                            <option value='XL' " . ($itemSize == 'XL' ? 'selected' : '') . ">XL</option>
                                        </select>
                                    </td>
                                    <td class='subtotal' id='subtotal-{$item['product_id']}'>" . number_format($subtotal) . "</td>
                                    <td>
                                        <a href='cart.php?action=delete&id={$item['product_id']}' class='btn btn-danger btn-sm'>Xóa</a>
                                    </td>
                                </tr>
                            ";
                            $totalMoney += $subtotal;
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>Giỏ hàng của bạn đang trống!</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <div class="total">
                <a href="/index.php" class="btn btn-primary">Tiếp tục mua hàng</a>
                <div>
                    <span>Tổng tiền thanh toán:</span>
                    <div class="right">
                        <p id="total-money" class="m-0"><?= number_format($totalMoney) ?> VND</p>
                    </div>
                    <div class="right">
                        <?php if (count($_SESSION["cart"]) > 0): ?>
                            <input class="btn btn-danger text-right" type="submit" name="order" value="Đặt hàng" />
                        <?php else: ?>
                            <button class="btn btn-danger text-right" disabled>Giỏ hàng trống</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </form>
    </div>

    <?php echo number_format($totalMoney);
     include 'layout/footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script>
       $(document).ready(function () {
    function updateCartTotal() {
        let totalMoney = 0;
        $(".cart-table tbody tr").each(function() {
            const price = parseFloat($(this).find('td:nth-child(2)').text().replace(/[^\d]/g, ''));
            const quantity = parseInt($(this).find('.quantity').val());
            const subtotal = price * quantity;
            
            // Update subtotal for this row
            $(this).find('.subtotal').text(subtotal.toLocaleString('vi-VN') + ' VND');
            
            // Add to total
            totalMoney += subtotal;
        });
        
        // Update total money
        $("#total-money").text(totalMoney.toLocaleString('vi-VN') + ' VND');
    }

    $(".quantity").on("input", function() {
        const id = $(this).data("id");
        const quantity = $(this).val();

        if (quantity >= 1) {
            $.ajax({
                url: "cart.php?action=update",
                type: "POST",
                data: {
                    id: id,
                    quantity: quantity
                },
                success: function (response) {
                    updateCartTotal();
                },
                error: function() {
                    // Fallback to client-side calculation if AJAX fails
                    updateCartTotal();
                }
            });
        }
    });

    // Initial setup for total calculation
    updateCartTotal();
});
    </script>
</body>

</html>
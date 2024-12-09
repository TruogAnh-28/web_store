<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/user.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    <title>User Management</title>
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
        <h2 class="mb-4">Quản lý người dùng</h2>
        <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Họ và tên</th>
                        <th scope="col">Tài khoản</th>
                        <th scope="col">Số điện thoại</th>
                        <th scope="col">Email</th>
                        <th scope="col">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_GET["id"])) {
                        require_once("../services/connect_db.php");
                        $id = $_GET["id"];
                        $query = "DELETE FROM users WHERE ACCOUNT='$id'";
                        mysqli_query($connect, $query);
                        echo "<script>alert('Tài khoản $id đã bị xoá')</script>";
                    }
                    
                    require_once("../services/connect_db.php");
                    $query = "SELECT * FROM users";
                    $result = mysqli_query($connect, $query);
                    $data = [];
                    while ($row = mysqli_fetch_array($result, 1)) {
                        $data[] = $row;
                    }
                    $connect->close();
                    
                    $index = 1;
                    foreach ($data as $item) {
                        echo "
                        <tr>
                            <th scope='row' class='text-center'>" . ($index++) . "</th>
                            <td class='text-center'>" . htmlspecialchars($item['name']) . "</td>
                            <td class='text-center'>" . htmlspecialchars($item['username']) . "</td>
                            <td class='text-center'>" . htmlspecialchars($item['address']) . "</td>
                            <td class='text-center'>" . htmlspecialchars($item['email']) . "</td>
                            <td class='text-center'>
                                <a class='btn action-btn btn-delete' href='?id=" . htmlspecialchars($item['user_id']) . "'>Xóa</a>
                            </td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>

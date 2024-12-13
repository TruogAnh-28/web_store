<?php
require_once 'config.php';

if (isset($_SESSION["user"])) {
    header("location: ./index.php");
    return;
}

$error_message = '';

if (isset($_POST['account'])) {
    $account = htmlspecialchars($_POST['account']);
    $pass = htmlspecialchars(md5($_POST['pass']));
    if ($account == "admin") {
        header("location: ./admin/index.php");
    } else {
        require_once("services/connect_db.php");
        $stmt = $connect->prepare('SELECT * FROM users WHERE username = ? AND password = ?');
        $stmt->bind_param('ss', $account, $pass);
        $stmt->execute();
        $result = $stmt->get_result();
        if (mysqli_num_rows($result) > 0) {
            $user = $result->fetch_assoc();
            $_SESSION["user"] = $user['username'];
            $_SESSION["user_id"] = $user['user_id'];
            header("location: ./index.php");
        } else {
            $error_message = "Bạn nhập sai tài khoản hoặc mật khẩu.";
        }
        $connect->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng nhập</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/login-register.css">
  <style>
    .login-page {
      background-color: #f4f4f9;
      font-family: 'Roboto', sans-serif;
    }
    .login-page .login-container {
      max-width: 400px;
      margin: auto;
      padding: 2rem;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      margin-top: 60px;
      margin-bottom: 60px;
    }
    .login-page .login-container h3 {
      font-size: 1.8rem;
      color: #333;
      margin-bottom: 1.5rem;
    }
    .login-page .form-control {
      border-radius: 8px;
      padding: 0.75rem;
      border: 1px solid #ddd;
      margin-bottom: 1rem;
    }
    .login-page .form-control:focus {
      border-color: #ff4c60;
      box-shadow: 0 0 0 0.2rem rgba(255, 76, 96, 0.25);
    }
    .login-page .btn-primary {
      background-color: #ff4c60;
      border-color: #ff4c60;
      padding: 0.75rem;
      width: 100%;
      font-weight: 600;
      border-radius: 8px;
    }
    .login-page .btn-primary:hover {
      background-color: #ff3a4f;
      border-color: #ff3a4f;
    }
    .login-page .register-link {
      text-align: center;
      margin-top: 1rem;
    }
    .login-page .error-msg {
      color: #ff4c60;
      font-size: 0.875rem;
      margin-bottom: 1rem;
    }
  </style>
</head>
<?php include "layout/navigation.php"; ?>
<body class="login-page">
  <div class="login-container">
    <h3>Đăng nhập</h3>
    <form method="POST" action="login.php" autocomplete="off">
      <div class="form-group">
        <label for="account">Tài khoản</label>
        <input name="account" type="text" class="form-control" placeholder="Nhập username" value="<?php echo isset($_POST['account']) ? htmlspecialchars($_POST['account']) : ''; ?>" required>
      </div>
      <div class="form-group">
        <label for="pass">Mật khẩu</label>
        <input name="pass" type="password" class="form-control" placeholder="Nhập mật khẩu" required>
      </div>
      <div class="error-msg">
        <?php echo $error_message; ?>
      </div>
      <button type="submit" class="btn btn-primary">Đăng nhập</button>
    </form>
    <div class="register-link">
      <p>Chưa có tài khoản? <a href="signIn.php">Đăng ký ngay</a></p>
    </div>
  </div>

</body>
<?php require_once "layout/footer.php"; ?>
</html>

<?php
require_once 'config.php';

if (isset($_SESSION["user"])) {
    header("location: ./index.php");
    return;
}

$error_msgs = [
    'name' => 'Name must have 3-30 characters',
    'email' => 'Invalid email',
    'address' => 'Address must have 3-100 characters',
    'account' => 'Account must have 3-30 characters',
    'password' => 'Password must have 3-30 characters',
    'confirm_pass' => 'Confirm password does not match password',
    'duplicate_account' => 'Account already exists, please enter a different account',
];

$error_codes = [];

function validate_form(&$error_codes, $name, $email, $address, $account, $pass, $confirmpass)
{
    $email_filter = '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/';
    
    if (strlen($account) < 3 or strlen($account) > 30) {
        array_push($error_codes, 'account');
    }
    if (strlen($name) < 3 or strlen($name) > 30) {
        array_push($error_codes, 'name');
    }
    if (strlen($address) < 3 or strlen($address) > 100) {
        array_push($error_codes, 'address');
    }
    if (!preg_match($email_filter, $email)) {
        array_push($error_codes, 'email');
    }
    if (strlen($pass) < 3 or strlen($pass) > 30) {
        array_push($error_codes, 'password');
    }
    if ($pass !== $confirmpass) {
        array_push($error_codes, 'confirm_pass');
    }
    
    return count($error_codes) === 0;
}

if (isset($_POST['account'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $address = htmlspecialchars($_POST['address']);
    $account = htmlspecialchars($_POST['account']);
    $pass = htmlspecialchars($_POST['pass']);
    $confirmpass = htmlspecialchars($_POST['confirmpass']);

    if (validate_form($error_codes, $name, $email, $address, $account, $pass, $confirmpass)) {
        require_once("services/connect_db.php");
        $stmt = $connect->prepare('INSERT INTO users (name, email, address, username, password) VALUES (?, ?, ?, ?, md5(?))');
        $stmt->bind_param('sssss', $name, $email, $address, $account, $pass);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            session_start();
            $_SESSION["user"] = $account;
            header("location: index.php");
        } else {
            array_push($error_codes, 'duplicate_account');
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
  <title>Đăng ký</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/login-register.css">
  <style>
    .sign-up {
      background-color: #f4f4f9;
      font-family: 'Roboto', sans-serif;
    }
    .sign-up .register-container {
      max-width: 800px;
      margin: auto;
      padding: 2rem;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      margin-top: 60px;
      margin-bottom: 60px;
    }
    .sign-up .register-container h3 {
      font-size: 1.8rem;
      color: #333;
      margin-bottom: 1.5rem;
    }
    .sign-up .form-control {
      border-radius: 8px;
      padding: 0.75rem;
      border: 1px solid #ddd;
      margin-bottom: 1rem;
    }
    .sign-up .form-control:focus {
      border-color: #ff4c60;
      box-shadow: 0 0 0 0.2rem rgba(255, 76, 96, 0.25);
    }
    .sign-up .btn-primary {
      background-color: #ff4c60;
      border-color: #ff4c60;
      padding: 0.75rem;
      width: 100%;
      font-weight: 600;
      border-radius: 8px;
    }
    .sign-up .btn-primary:hover {
      background-color: #ff3a4f;
      border-color: #ff3a4f;
    }
    .sign-up .login-link {
      text-align: center;
      margin-top: 1rem;
    }
    .sign-up .error-msg {
      color: #ff4c60;
      font-size: 0.875rem;
      margin-bottom: 1rem;
    }
    .form-row .col {
      padding-right: 0.5rem;
    }
  </style>
</head>
<body class="sign-up">
  <?php include "layout/navigation.php"; ?>
  <div class="register-container">
    <h3>Đăng ký tài khoản</h3>
    <form method="POST" action="signIn.php" autocomplete="off">
      <!-- Họ và tên + Username -->
      <div class="form-row">
        <div class="col">
          <label for="name">Họ tên</label>
          <input name="name" type="text" class="form-control" placeholder="Nhập họ và tên" required>
        </div>
        <div class="col">
          <label for="account">Tên tài khoản</label>
          <input name="account" type="text" class="form-control" placeholder="Nhập username" required>
        </div>
      </div>
      <!-- Địa chỉ + Email -->
      <div class="form-row">
        <div class="col">
          <label for="address">Địa chỉ</label>
          <input name="address" type="text" class="form-control" placeholder="Nhập địa chỉ" required>
        </div>
        <div class="col">
          <label for="email">Email</label>
          <input name="email" type="email" class="form-control" placeholder="Nhập email" required>
        </div>
      </div>
      <!-- Mật khẩu + Nhập lại mật khẩu -->
      <div class="form-row">
        <div class="col">
          <label for="pass">Mật khẩu</label>
          <input name="pass" type="password" class="form-control" placeholder="Nhập mật khẩu" required>
        </div>
        <div class="col">
          <label for="confirmpass">Nhập lại mật khẩu</label>
          <input name="confirmpass" type="password" class="form-control" placeholder="Xác nhận mật khẩu" required>
        </div>
      </div>
      <div class="error-msg">
        <?php
          foreach ($error_codes as $error_code) {
            echo "<p>" . $error_msgs[$error_code] . "</p>";
          }
        ?>
      </div>
      <button type="submit" class="btn btn-primary">Đăng ký</button>
    </form>
    <div class="login-link">
      <p>Đã có tài khoản? <a href="login.php">Đăng nhập ngay</a></p>
    </div>
  </div>
</body>
<?php require_once "layout/footer.php"; ?>
</html>

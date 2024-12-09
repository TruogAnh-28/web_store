<?php
require_once 'config.php';

if (!isset($_SESSION["user"])) {
  header("location: ./index.php");
  return;
}

$account = $_SESSION["user"];
require_once("services/connect_db.php");

$error_message = '';
$success_message = '';

if (isset($_POST['oldpass'])) {
  $stmt = $connect->prepare('SELECT * FROM users WHERE username = ? AND password = md5(?)');
  $oldpass = htmlspecialchars($_POST['oldpass']);
  $stmt->bind_param('ss', $account, $oldpass);
  $stmt->execute();
  $user = $stmt->get_result();

  if ($user->num_rows <= 0) {
    $error_message = "Bạn đã nhập sai mật khẩu cũ.";
  } else {
    $newpass = htmlspecialchars($_POST['newpass']);
    $confirmpass = htmlspecialchars($_POST['confirmpass']);

    if ($newpass != $confirmpass) {
      $error_message = "Xác nhận mật khẩu mới không chính xác.";
    } else {
      $stmt = $connect->prepare('UPDATE users SET password = md5(?) WHERE username = ?');
      $stmt->bind_param('ss', $newpass, $account);
      $stmt->execute();
      $success_message = "Bạn đã đổi mật khẩu thành công.";
    }
  }
  $connect->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đổi mật khẩu</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .changePassword {
      background-color: #f4f4f9;
      font-family: 'Roboto', sans-serif;
    }
    .changePassword .change-password-container {
      max-width: 500px;
      margin: auto;
      background-color: #fff;
      padding: 2rem;
      margin-top: 60px;
      margin-bottom: 60px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .changePassword .change-password-container h4 {
      text-align: center;
      margin-bottom: 1.5rem;
      color: #333;
    }
    .changePassword .form-control {
      margin-bottom: 1rem;
    }
    .changePassword .btn-primary {
      background-color: #ff4c60;
      border-color: #ff4c60;
      padding: 0.75rem;
      width: 100%;
      font-weight: 600;
      margin-top: 1rem;
    }
    .changePassword .btn-primary:hover {
      background-color: #ff3a4f;
      border-color: #ff3a4f;
    }
    .changePassword .error-msg {
      color: #ff4c60;
      font-size: 0.875rem;
      margin-top: -0.5rem;
      margin-bottom: 1rem;
      text-align: center;
    }
    .changePassword .success-msg {
      color: #28a745;
      font-size: 0.875rem;
      margin-top: -0.5rem;
      margin-bottom: 1rem;
      text-align: center;
    }
  </style>
</head>
<?php include "layout/navigation.php"; ?>
<body class="changePassword">
  <div class="change-password-container">
    <h4>Đổi mật khẩu của bạn</h4>

    <form method="POST" action="changePassword.php" autocomplete="off">
      <div class="form-group">
        <label for="oldpass">Mật khẩu cũ</label>
        <input name="oldpass" type="password" class="form-control" id="oldpass" placeholder="Nhập mật khẩu cũ..." required>
      </div>
      <div class="form-group">
        <label for="newpass">Mật khẩu mới</label>
        <input name="newpass" type="password" class="form-control" id="newpass" placeholder="Nhập mật khẩu mới..." required>
      </div>
      <div class="form-group">
        <label for="confirmpass">Xác nhận mật khẩu mới</label>
        <input name="confirmpass" type="password" class="form-control" id="confirmpass" placeholder="Xác nhận mật khẩu mới..." required>
      </div>

      <?php if ($error_message): ?>
        <div class="error-msg"><?= $error_message; ?></div>
      <?php endif; ?>

      <?php if ($success_message): ?>
        <div class="success-msg"><?= $success_message; ?></div>
      <?php endif; ?>

      <button type="submit" class="btn btn-primary btn-sm">Đổi mật khẩu</button>
    </form>
  </div>

  <?php require_once "layout/footer.php"; ?>
</body>
</html>

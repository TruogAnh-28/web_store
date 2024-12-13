<?php
require_once 'config.php';
require_once 'services/connect_db.php';

if (!isset($_SESSION["user"])) {
    header("location: login.php");
    return;
}

$user = $_SESSION["user"];
$error_msgs = [
    'name' => 'Tên phải có từ 3 đến 40 ký tự.',
    'email' => 'Email không hợp lệ.',
    'address' => 'Địa chỉ phải có từ 3 đến 100 ký tự.',
    'update_error' => 'Cập nhật thông tin không thành công. Vui lòng thử lại.'
];
$success_msg = 'Cập nhật thông tin thành công!'; // Thêm thông báo thành công
$error_codes = [];

// Fetch user data
$stmt = $connect->prepare('SELECT name, email, address, username FROM users WHERE username = ?');
$stmt->bind_param('s', $user);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($name, $email, $address, $username);
$stmt->fetch();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $address = htmlspecialchars($_POST['address']);

    $email_filter = '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/';

    if (strlen($name) < 3 || strlen($name) > 40) {
        array_push($error_codes, 'name');
    }
    if (!preg_match($email_filter, $email)) {
        array_push($error_codes, 'email');
    }
    if (strlen($address) < 3 || strlen($address) > 100) {
        array_push($error_codes, 'address');
    }

    if (count($error_codes) === 0) {
        $stmt = $connect->prepare('UPDATE users SET name = ?, email = ?, address = ? WHERE username = ?');
        $stmt->bind_param('ssss', $name, $email, $address, $user);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $_SESSION["success"] = $success_msg; // Thêm thông báo thành công vào session
            header("location: profile.php");
        } else {
            array_push($error_codes, 'update_error');
        }
    }
}

$connect->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Thông tin cá nhân</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .profile.profile  {
      background-color: #f4f4f9;
      font-family: 'Roboto', sans-serif;
    }
    .profile .profile-container {
      max-width: 600px;
      margin: auto;
      background-color: #fff;
      padding: 2rem;
      margin-top: 60px;
      margin-bottom: 60px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .profile .profile-container h3 {
      text-align: center;
      margin-bottom: 2rem;
      color: #333;
    }
    .profile .form-control {
      margin-bottom: 1.5rem;
    }
    .profile .btn-primary {
      background-color: #ff4c60;
      border-color: #ff4c60;
      padding: 0.75rem;
      width: 100%;
      font-weight: 600;
      margin-top: 1rem;
    }
    .profile .btn-primary:hover {
      background-color: #ff3a4f;
      border-color: #ff3a4f;
    }
    .profile .error-msg {
      color: #ff4c60;
      font-size: 0.875rem;
      margin-bottom: 1rem;
    }
    .profile .success-msg {
      color: #28a745;
      font-size: 1rem;
      margin-bottom: 1rem;
    }
  </style>
</head>
<?php include "layout/navigation.php"; ?>
<body class="profile">
<div class="profile-container">
  <h3>Thông tin cá nhân</h3>
  
  <!-- Hiển thị thông báo thành công nếu có -->
  <?php if (isset($_SESSION["success"])): ?>
    <div class="success-msg">
      <?php echo $_SESSION["success"]; ?>
      <?php unset($_SESSION["success"]); ?> <!-- Xóa thông báo sau khi hiển thị -->
    </div>
  <?php endif; ?>

  <form method="POST" action="profile.php">
    <div class="form-group">
      <label for="name">Họ và tên</label>
      <input name="name" type="text" class="form-control" value="<?php echo $name; ?>" required>
    </div>
    <div class="form-group">
      <label for="username">Tên tài khoản</label>
      <input name="username" type="text" class="form-control" value="<?php echo $username; ?>" disabled>
    </div>
    <div class="form-group">
      <label for="email">Email</label>
      <input name="email" type="email" class="form-control" value="<?php echo $email; ?>" required>
    </div>
    <div class="form-group">
      <label for="address">Địa chỉ</label>
      <input name="address" type="text" class="form-control" value="<?php echo $address; ?>" required>
    </div>

    <!-- Hiển thị thông báo lỗi nếu có -->
    <div class="error-msg">
      <?php
        foreach ($error_codes as $error_code) {
          echo "<p>" . $error_msgs[$error_code] . "</p>";
        }
      ?>
    </div>

    <button type="submit" class="btn btn-primary">Cập nhật</button>
  </form>
</div>
<?php require_once "layout/footer.php"; ?>
</body>
</html>

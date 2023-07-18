<?php
// Kết nối đến cơ sở dữ liệu
include 'db_connection.php';

// Kiểm tra xem form đăng nhập đã được gửi hay chưa
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Thực hiện truy vấn để kiểm tra tên người dùng và mật khẩu
    $loginSql = "SELECT id FROM users WHERE username = '$username'";
    $result = $connection->query($loginSql);

    if ($result && $result->num_rows > 0) {
        // Tên người dùng tồn tại trong cơ sở dữ liệu
        $row = $result->fetch_assoc();
        $userId = $row['id'];

        // Kiểm tra mật khẩu
        $passwordSql = "SELECT id FROM users WHERE username = '$username' AND password = '$password'";
        $passwordResult = $connection->query($passwordSql);

        if ($passwordResult && $passwordResult->num_rows > 0) {
            // Mật khẩu đúng
            header("Location: Trangchu.php?user_id=$userId");
            exit();
        } else {
            // Mật khẩu sai
            $errorMessage = "Mật khẩu không chính xác.";
        }
    } else {
        // Tên người dùng không tồn tại
        $errorMessage = "Chưa có tài khoản.";
    }
}

// Đóng kết nối cơ sở dữ liệu
$connection->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Đăng nhập</title>
    <style>
        /* CSS đã được chỉnh sửa */
        body {
    --main-color: #e70634;
    --hover-color: hsl(37, 94%, 57%);
    --body-color: #1e1e2a;
    --container-color: #2d2e37;
    --text-color: #fcfeff;
    background: var(--body-color);
    color: var(--text-color);
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 400px;
    margin: auto;
    padding: 20px;
    background-color: var(--container-color);
    border-radius: 10px;
    margin-top: 100px;
}

.container h2 {
    margin-top:0;
    font-size: 24px;
    font-weight: 600;
    margin-bottom: 20px;
    color: var(--main-color);
}

label {
    margin-top: 20px;
    font-size: 16px;
    font-weight: 500;
    display: block;
    margin-bottom: 12px;
}

input[type="text"],
input[type="password"] {
    width: 95%;
    height: 40px;
    padding: 8px;
    border-radius: 6px;
    border: 1px solid var(--container-color);
    background-color: white;
    color: black;
    font-size: 14px;
}

button[type="submit"] {
    padding: 10px 20px;
    background-color: var(--main-color);
    color: var(--text-color);
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    margin-top: 15px;
}

button[type="submit"]:hover {
    background-color: var(--hover-color);
}

p.error-message {
    color: red;
    font-size: 14px;
    margin-top: 10px;
}

.register-link {
    margin-top: 15px;
    font-size: 16px;
    color: var(--text-color);
    text-align: center;
}

.register-link a {
    color: var(--main-color);
    text-decoration: none;
}

.register-link a:hover {
    color: var(--hover-color);
}

.container container-h2{
    width:100%;
    align-items:center;
    justify-content: center;
}

    </style>
</head>
<body>
    <div class="container">

        <div class = "container-h2">
             <h2>Đăng nhập</h2>
        </div>

        <form method="post" action="Dangnhap.php">
            <label for="username">Tên người dùng:</label>
            <input type="text" id="username" name="username" required><br>

            <label for="password">Mật khẩu:</label>
            <input type="password" id="password" name="password" required><br>

            <button type="submit">Đăng nhập</button>
        </form>
        <?php
        if (isset($errorMessage)) {
            echo "<p class='error-message'>$errorMessage</p>";
        }
        ?>
        <div class="register-link">
            Chưa có tài khoản? <a href="Dangky.php">Đăng ký</a>
        </div>
    </div>
</body>
</html>

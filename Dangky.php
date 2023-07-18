<?php
// Kết nối đến cơ sở dữ liệu
include 'db_connection.php';

$errorMessage = '';
$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Kiểm tra xem tên người dùng đã tồn tại hay chưa
    $checkUsernameSql = "SELECT * FROM users WHERE username = '$username'";
    $checkUsernameResult = $connection->query($checkUsernameSql);

    if ($checkUsernameResult && $checkUsernameResult->num_rows > 0) {
        // Tên người dùng đã tồn tại
        $errorMessage = "Tên người dùng đã tồn tại, xin hãy thử lại.";
    } else {
        // Tên người dùng chưa tồn tại, tiến hành thêm người dùng mới
        $insertSql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        if ($connection->query($insertSql) === TRUE) {
            // Hiển thị thông báo đăng ký thành công bằng hộp thoại alert
            echo "<script>
                        alert('Đăng ký thành công!');
                        window.location.href = 'Dangnhap.php';
                </script>";
        } else {
            $errorMessage = "Đã xảy ra lỗi, vui lòng thử lại sau.";
        }
    }
}

// Đóng kết nối cơ sở dữ liệu
$connection->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Đăng ký</title>
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
            margin-top: 0;
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

        p.success-message {
            color: green;
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
    </style>
</head>
<body>
    <div class="container">
        <h2>Đăng ký</h2>
        <?php
        if (!empty($errorMessage)) {
            echo "<p class='error-message'>$errorMessage</p>";
        }
        if (!empty($successMessage)) {
            echo "<p class='success-message'>$successMessage</p>";
        }
        ?>
        <form method="post" action="Dangky.php">
            <label for="username">Tên người dùng:</label>
            <input type="text" id="username" name="username" required><br>

            <label for="password">Mật khẩu:</label>
            <input type="password" id="password" name="password" required><br>

            <button type="submit">Đăng ký</button>
        </form>
    </div>
</body>
</html>

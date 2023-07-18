<?php
session_start();

// Kết nối đến cơ sở dữ liệu
include 'db_connection.php';

// Kiểm tra xem user_id đã tồn tại trong $_SESSION hay chưa
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    // Chuyển hướng đến trang Đăng nhập
    header("Location: Dangnhap.php");
    exit();
}

// Lấy thông tin người dùng từ cơ sở dữ liệu
$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    // Chuyển hướng đến trang Đăng nhập
    header("Location: Dangnhap.php");
    exit();
}

// Xử lý yêu cầu cập nhật thông tin người dùng
if (isset($_POST['update'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $avatar_link = isset($_POST['avatar_link']) ? $_POST['avatar_link'] : '';

    $sql = "UPDATE users SET username = '$username', email = '$email', avatar_link = '$avatar_link' WHERE id = '$user_id'";
    $result = $connection->query($sql);

    if ($result === true) {
        // Cập nhật thành công, cập nhật lại thông tin người dùng
        $user['username'] = $username;
        $user['email'] = $email;
        $user['avatar_link'] = $avatar_link;
    }
}


// Xử lý yêu cầu đăng xuất
if (isset($_POST['logout'])) {
    // Xóa tất cả các biến session
    session_unset();
    // Hủy bỏ session
    session_destroy();
    // Điều hướng đến trang Đăng nhập
    header("Location: Dangnhap.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Info</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="img/fav-icon.png" type="image/x-icon">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="dropdown.css">
    <style>
        .user {
            display: flex;
            align-items: center;
        }

        .user-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: contain;
            object-position: center;
        }

        /* Section */
        section {
            padding: 3rem 0 2rem;
        }

        .user-info {
            display: flex;
            align-items: center;
        }

        .user-info img {
            width: 100%;
            height:500px;
            object-fit: cover;
            margin-right: 1rem;
            margin-bottom:30px;
        }

        .info p {
            margin-bottom: 0.5rem;
        }

        form div {
            margin-bottom: 1rem;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .infor-input,
        input[type="email"] {
            width: 100%;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
            margin-bottom: 15px;
        }

        .logout-button {
            background-color: var(--main-color);
            color: var(--text-color);
            padding: 10px 80px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            margin-bottom: 20px;
        }

        .logout-button:hover {
            background-color: var(--hover-color);
            color: var(--text-color);
        }

        .container h1 {
            margin-top: 60px;
            margin-bottom: 30px;
            font-size: 30px;
            color: #E91A46;
        }

        .container h2 {
            margin-bottom: 30px;
            font-size: 30px;
            color: #E91A46;
        }

        .button-row {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .update-button {
            background-color: var(--main-color);
            color: var(--text-color);
            padding: 10px 30px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            margin-bottom: 20px;
        }

        .update-button:hover {
            background-color: var(--hover-color);
            color: var(--text-color);
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <!-- Navigation -->
        <div class="nav container">
            <!-- Logo -->
            <a href="TrangChu.html" class="logo">
                Movie<span>Manhwa</span>
            </a>
            <!-- Search Box -->
            <div class="search-box">
                <form method="post" style="display: flex;">
                    <input type="text" name="noidung" autocomplete="off" id="search-input" placeholder="Search Movies">
                    <button class="search-button" type="submit" name="btn">
                        <a href="search.php"><i class="bx bx-search"></i> </a>
                    </button>
                </form>
            </div>
            <!-- User -->
            <a href="#" class="user">
                <img src="<?php echo isset($user['avatar_link']) ? $user['avatar_link'] : 'img/images.png'; ?>" alt="" class="user-img">
            </a>
            <!-- Navbar -->
            <div class="navbar">
                <a href="Trangchu.php?user_id=<?php echo $_SESSION['user_id']; ?>" class="nav-link">
                    <i class="bx bx-home nav-link-icon"></i>
                    <span class="nav-link-title">Trang chủ</span>
                </a>
                <a href="#home" class="nav-link">
                    <i class="bx bxs-hot nav-link-icon"></i>
                    <span class="nav-link-title">Thịnh hành</span>
                </a>
                <a href="PhimBo.php?user_id=<?php echo $_SESSION['user_id']; ?>" class="nav-link nav-active">
                    <i class="bx bxs-movie nav-link-icon"></i>
                    <span class="nav-link-title">Phim bộ</span>
                </a>
                <a href="PhimLe.php?user_id=<?php echo $_SESSION['user_id']; ?>" class="nav-link">
                    <i class="bx bxs-film nav-link-icon"></i>
                    <span class="nav-link-title">Phim lẻ</span>
                </a>
                <div class="dropdown-toggle-container" id="genre-dropdown-toggle">
                    <a href="#" class="nav-link dropdown">
                        <i class="bx bx-category nav-link-icon"></i>
                        <span class="nav-link-title">Thể loại</span>
                    </a>
                    <div class="dropdown-content">
                        <div class="column">
                            <a href="Theloai.php?genre=Hài hước&user_id=<?php echo $_SESSION['user_id']; ?>">Hài hước</a>
                            <a href="Theloai.php?genre=Hành động&user_id=<?php echo $_SESSION['user_id']; ?>">Hành động</a>
                            <a href="Theloai.php?genre=Phiêu lưu&user_id=<?php echo $_SESSION['user_id']; ?>">Phiêu lưu</a>
                            <a href="Theloai.php?genre=Tình cảm&user_id=<?php echo $_SESSION['user_id']; ?>">Tình cảm</a>
                            <a href="Theloai.php?genre=Học đường&user_id=<?php echo $_SESSION['user_id']; ?>">Học đường</a>
                            <a href="Theloai.php?genre=Võ thuật&user_id=<?php echo $_SESSION['user_id']; ?>">Võ thuật</a>
                            <a href="Theloai.php?genre=Tài liệu&user_id=<?php echo $_SESSION['user_id']; ?>">Tài liệu</a>
                        </div>
                        <div class="column">
                            <a href="Theloai.php?genre=Viễn tưởng&user_id=<?php echo $_SESSION['user_id']; ?>">Viễn tưởng</a>
                            <a href="Theloai.php?genre=Hoạt hình&user_id=<?php echo $_SESSION['user_id']; ?>">Hoạt hình</a>
                            <a href="Theloai.php?genre=Thể thao&user_id=<?php echo $_SESSION['user_id']; ?>">Thể thao</a>
                            <a href="Theloai.php?genre=Âm nhạc&user_id=<?php echo $_SESSION['user_id']; ?>">Âm nhạc</a>
                            <a href="Theloai.php?genre=Gia đình&user_id=<?php echo $_SESSION['user_id']; ?>">Gia đình</a>
                            <a href="Theloai.php?genre=Kinh dị&user_id=<?php echo $_SESSION['user_id']; ?>">Kinh dị</a>
                            <a href="Theloai.php?genre=Tâm lý&user_id=<?php echo $_SESSION['user_id']; ?>">Tâm lý</a>
                        </div>
                    </div>
                </div>
                <a href="#home" class="nav-link">
                    <i class="bx bx-heart nav-link-icon"></i>
                    <span class="nav-link-title">Yêu thích</span>
                </a>
            </div>
        </div>
    </header>

    <section class="container">
        <?php if ($user === null) : ?>
            <h1>Vui lòng đăng nhập trước</h1>
        <?php else : ?>
            <h1>Thông tin cá nhân</h1>
            <div class="user-info">
                <img src="<?php echo isset($user['avatar_link']) ? $user['avatar_link'] : 'img/images.png'; ?>" alt="Avatar">
                <div class="info">
                </div>
            </div>

            <h2>Cập nhật thông tin</h2>
            <form method="POST" action="">
                <div>
                    <label for="username">Tên tài khoản:</label>
                    <input type="text" name="username" id="username" class="infor-input" value="<?php echo $user['username']; ?>">
                </div>
                <div>
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" value="<?php echo $user['email']; ?>">
                </div>
                <div>
                    <label for="avatar_link">Đường dẫn ảnh đại diện:</label>
                    <input type="text" name="avatar_link" id="avatar_link" class="infor-input" value="<?php echo $user['avatar_link']; ?>">
                </div>
                <div class="button-row">
                    <button type="submit" name="update" class="update-button">Cập nhật</button>
                    <button type="submit" name="logout" class="logout-button">Đăng xuất</button>
                </div>
            </form>
        <?php endif; ?>
    </section>

    <script src="js/main.js"></script>
    <script src="dropdown.js"></script>
</body>

</html>

<?php
// Đóng kết nối cơ sở dữ liệu
$connection->close();
?>

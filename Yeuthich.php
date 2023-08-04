<?php
// Kết nối đến cơ sở dữ liệu
include 'db_connection.php';

// Bắt đầu phiên làm việc với session
session_start();

// Kiểm tra xem user_id đã tồn tại trong $_SESSION hay chưa
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Kiểm tra xem có yêu cầu xóa phim hay không
    if (isset($_POST['delete'])) {
        if (isset($_POST['favorite'])) {
            $favoriteMovies = $_POST['favorite'];
            foreach ($favoriteMovies as $movieId) {
                // Xóa bộ phim khỏi danh sách yêu thích
                $deleteSql = "DELETE FROM favorites WHERE user_id = $user_id AND movie_id = $movieId";
                $deleteResult = $connection->query($deleteSql);
            }
            // Refresh trang sau khi xóa
            echo "<script>alert('Xóa khỏi danh sách yêu thích thành công!'); window.location.href = 'Yeuthich.php';</script>";
            exit; // Stop further execution
        }
    }

    // Truy vấn danh sách phim yêu thích của user
    $sql = "SELECT movies.* FROM movies
            INNER JOIN favorites ON movies.id = favorites.movie_id
            WHERE favorites.user_id = $user_id";
    $result = $connection->query($sql);

    // Đóng kết nối cơ sở dữ liệu
    $connection->close();
} else {
    // Chuyển hướng đến trang Đăng nhập nếu người dùng chưa đăng nhập
    echo '<script>
        alert("Vui lòng đăng nhập");
        window.location.href = "Dangnhap.php";
    </script>';
    exit; // Stop further execution
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ManhwaMovies</title>
    <!-- Link to CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="search.css">
    <!-- Link Swiper CSS-->
    <link rel="stylesheet" href="css/cdn.jsdelivr.net_npm_swiper@10.0.4_swiper-bundle.min.css">
    <!-- Fav Icon -->
    <link rel="shortcut icon" href="img/fav-icon.png" type="image/x-icon">
    <!-- Box Icon -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="dropdown.css">

    <style>

    .container h1{
        margin-top:80px;
        margin-bottom:20px;
        font-size: 30px;
        color: #E91A46;
    }

    .checkbox-container {
            display: flex;
            justify-content: center;
            align-items: flex-end;
            margin-top: 15px;

            
        }
        .box-text a {
    color: white;
    text-decoration: none; /* Loại bỏ gạch chân khi hover */
}
    .favorite-checkbox {
        width: 30px;
        height: 30px;
        margin-right: 10px;
            
    }

    .delete-button {
    margin-bottom: 30px;
    background-color: #E91A46;
    color: #fff;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s ease;

    }

    .delete-button:hover {
    background-color: #C2183B;

     }
     .favorite-movie img {
    width: 100%;
    height: 400px; /* Kích thước hình ảnh phim */
    object-fit: cover;
}

    </style>
</head>

<body>
<header>
        <div class="nav container">
            <a href="TrangChu.html" class="logo">
                Movie<span>Manhwa</span>
            </a>
            
            <div class="search-box">
                 <form method="post" action="search.php" style="display: flex;">
                     <input type="text" name="noidung" autocomplete="off" id="search-input" placeholder="Search Movies">
                         <button class="search-button" type="submit" name="btn">
                             <i class="bx bx-search"></i>
                         </button>
                 </form>
            </div>

            <a href="<?php echo isset($_SESSION['user_id']) ? 'UserInfo.php?user_id=' . $_SESSION['user_id'] : 'Dangnhap.php'; ?>" class="user">
                <img src="<?php echo isset($user['avatar_link']) ? $user['avatar_link'] : 'img/images.png'; ?>" alt="" class="user-img">
            </a>
            
            <div class="navbar">
                <a href="Trangchu.php?user_id=<?php echo $_SESSION['user_id']; ?>" class="nav-link">
                    <i class="bx bx-home nav-link-icon"></i>
                    <span class="nav-link-title">Trang chủ</span>
                </a>

                <a href="#home" class="nav-link">
                    <i class="bx bxs-hot nav-link-icon"></i>
                    <span class="nav-link-title">Thịnh hành</span>
                </a>

                <a href="PhimBo.php?user_id=<?php echo $_SESSION['user_id']; ?>" class="nav-link">
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

                <a href="Yeuthich.php?user_id=<?php echo  $_SESSION['user_id']; ?>" class="nav-link nav-active">
                    <i class="bx bx-heart nav-link-icon"></i>
                    <span class="nav-link-title">Yêu thích</span>
                </a>

            </div>
        </div>
    </header>

    <?php if (isset($_SESSION['user_id'])) { ?>
       <section class="favorite-movies-section">
    <div class="container">
        <h1>Danh sách phim yêu thích của bạn</h1>
        <form id="favorite-form" method="POST">
            <?php if ($result->num_rows > 0) { ?>
                <div class="movie-grid">
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <div class="movie-box">
                            <img src="<?php echo $row['image']; ?>" alt="" class="movie-box-img">
                            <div class="box-text">
                                <a href="chitietphim.php?id=<?php echo $row['id']; ?>&user_id=<?php echo $_SESSION['user_id']; ?>">
                                <h2 class="movie-title"><?php echo $row['title']; ?></h2>
                                <span class="movie-type"><?php echo $row['genre']; ?></span>
                                </a>
                                <div class="checkbox-container">
                                    <input type="checkbox" name="favorite[]" value="<?php echo $row['id']; ?>" class="favorite-checkbox">
                                </div>
                        </div>
                            </div>
                            
                       
                    <?php } ?>
                </div>
                <!-- Add some margin between the movie grid and the delete button -->
                <div style="margin-top: 20px; display: flex; justify-content: flex-end;">
                    <button type="submit" name="delete" onclick="deleteFavorites()" class="delete-button">Xóa khỏi danh sách yêu thích</button>
                </div>
            <?php } else { ?>
                <p class="no-favorite">Bạn chưa có bộ phim nào trong danh sách yêu thích.</p>
            <?php } ?>
        </form>
    </div>
</section>
    <?php } ?>

    <script>
        function deleteFavorites() {
            if (confirm("Bạn có chắc chắn muốn xóa?")) {
                document.getElementById('favorite-form').submit();
            }
        }
    </script>
     <script src="js/main.js"></script>
    <script src="dropdown.js"></script>
</body>

</html>

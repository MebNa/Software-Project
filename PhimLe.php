<?php
// Kết nối đến cơ sở dữ liệu
include 'db_connection.php';

// Truy vấn danh sách phim bộ từ cơ sở dữ liệu
$sql = "SELECT * FROM movies WHERE genre LIKE '%Phim lẻ%'";
$result = $connection->query($sql);

// Đầu trang HTML
echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ManhwaMovies - Phim lẻ</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="img/fav-icon.png" type="image/x-icon">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

</head>
<body>
    <header>
        <div class="nav container">
            <a href="TrangChu.html" class="logo">
                Movie<span>Manhwa</span>
            </a>
            <div class="search-box">
                <form method="post" style="display: flex;">
                    <input type="text" name="noidung" autocomplete="off" id="search-input" placeholder="Search Movies">
                    <button class="search-button" type="submit" name="btn">
                        <a href="Search.html"><i class="bx bx-search"></i> </a>
                    </button>
                </form>
            </div>
            <a href="#" class="user">
                <img src="img/images.png" alt="" class="user-img">
            </a>
            <div class="navbar">

                <a href="TrangChu.html" class="nav-link">
                    <i class="bx bx-home"></i>
                    <span class="nav-link-title">Trang chủ</span>
                </a>

                <a href="#home" class="nav-link">
                    <i class="bx bxs-hot" ></i>
                    <span class="nav-link-title">Thịnh hành</span>
                </a>

                <a href="PhimBo.php" class="nav-link">
                    <i class="bx bxs-movie"></i>
                    <span class="nav-link-title">Phim bộ</span>
                </a>

                <a href="PhimLe.php" class="nav-link nav-active">
                     <i class="bx bxs-film"></i>
                     <span class="nav-link-title">Phim lẻ</span>
                </a>

                <a href="#home" class="nav-link">
                  <i class="bx bx-category" ></i>
                  <span class="nav-link-title">Thể loại</span>
                </a>

                <a href="#home" class="nav-link">
                   <i class="bx bx-heart"></i>
                   <span class="nav-link-title">Yêu thích</span>
                </a>
               
            </div>
        </div>
    </header>
    <section class="popular container" id="popular">
        <div class="heading">
            <h2 class="heading-title">Danh sách phim lẻ</h2>
        </div>
        <div class="popular-content">
            <div class="movie-grid">';
        
// Hiển thị danh sách phim lẻ
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '
        <div class="movie-box">
            <img src="' . $row['image'] . '" alt="" class="movie-box-img">
            <div class="box-text">
                <h2 class="movie-title">' . $row['title'] . '</h2>
                <span class="movie-type">' . $row['genre'] . '</span>
                <a href="chitietphim.php?id=' . $row['id'] . '" class="watch-btn play-btn">
                    <i class="bx bx-right-arrow"></i>
                </a>
            </div>
        </div>';
    }
} else {
    echo "Không có phim lẻ trong cơ sở dữ liệu.";
}

// Chân trang HTML
echo '</div>
            </div>
        </div>
    </section>
    <script src="js/main.js"></script>
</body>
</html>';

// Đóng kết nối cơ sở dữ liệu
$connection->close();
?>



<?php
session_start();

// Kiểm tra xem có tham số user_id trong URL hay không
if (isset($_GET['user_id'])) {
    $_SESSION['user_id'] = $_GET['user_id'];
} else {
    $_SESSION['user_id'] = null;
}

// Kết nối đến cơ sở dữ liệu
include 'db_connection.php';

$user = null;

// Lấy thông tin người dùng từ cơ sở dữ liệu (nếu có)
if ($_SESSION['user_id'] !== null) {
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM users WHERE id = '$user_id'";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    }
}

// Đóng kết nối cơ sở dữ liệu
$connection->close();
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
    <link rel="stylesheet" href="./search.css">
    <!-- Link Swiper CSS-->
    <link rel="stylesheet" href="css/cdn.jsdelivr.net_npm_swiper@10.0.4_swiper-bundle.min.css">
    <!-- Fav Icon -->
    <link rel="shortcut icon" href="img/fav-icon.png" type="image/x-icon">
    <!-- Box Icon -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="dropdown.css">
    <style>
        .user-info {
            display: flex;
            align-items: center;
        }

        .user-info img {
            width: 250px;
            height:350px;
            object-fit: cover;
            margin-right: 1rem;
            margin-bottom:30px;
        }

    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <!-- Nav -->
        <div class="nav container">
            <!-- Logo -->
            <a href="TrangChu.html" class="logo">
                Movie<span>Manhwa</span>
            </a>
            <!-- Search Box-->
            <div class="search-box">
                <form method="post" style="display: flex;">
                    <input type="text" name="noidung" autocomplete="off" id="search-input" placeholder="Search Movies">
                    <button class="search-button" type="submit" name="btn">
                        <a href="Search.html"><i class='bx bx-search'></i> </a>
                    </button>
                </form>
            </div>
            <!-- User -->
            <a href="<?php echo isset($_SESSION['user_id']) ? 'UserInfo.php?user_id=' . $_SESSION['user_id'] : 'Dangnhap.php'; ?>" class="user">
            <img src="<?php echo $user !== null ? $user['avatar_link'] : 'img/images.png'; ?>" alt="" class="user-img">
            </a>
            <!-- NavBar -->
            <div class="navbar">
            <a href="Trangchu.php?user_id=<?php echo $_SESSION['user_id']; ?>" class="nav-link nav-active">
                    <i class='bx bx-home' ></i>
                    <span class="nav-link-title">Trang chủ</span>
                </a>
                <a href="Trangchu.php?user_id=<?php echo $_SESSION['user_id']; ?>" class="nav-link">
                    <i class='bx bxs-hot' ></i>
                    <span class="nav-link-title">Thịnh hành</span>
                </a>
                <a href="PhimBo.php?user_id=<?php echo $_SESSION['user_id']; ?>" class="nav-link">
                    <i class='bx bxs-movie' ></i>
                    <span class="nav-link-title">Phim bộ</span>
                </a>
                <a href="PhimLe.php?user_id=<?php echo  $_SESSION['user_id']; ?>" class="nav-link">
                    <i class='bx bxs-film'></i>
                    <span class="nav-link-title">Phim lẻ</span>
                    <div class="dropdown-toggle-container" id="genre-dropdown-toggle">
                        <a href="#" class="nav-link dropdown">
                            <i class="bx bx-category nav-link-icon"></i>
                            <span class="nav-link-title">Thể loại</span>
                         </a>
                         <div class="dropdown-content">
                         <div class="column">
                         <a href="Theloai.php?genre=Hài hước&user_id=<?php echo $userId; ?>">Hài hước</a>
                             <a href="Theloai.php?genre=Hành động">Hành động</a>
                             <a href="Theloai.php?genre=Phiêu lưu">Phiêu lưu</a>
                             <a href="Theloai.php?genre=Tình cảm">Tình cảm</a>
                             <a href="Theloai.php?genre=Học đường">Học đường</a>
                             <a href="Theloai.php?genre=Võ thuật">Võ thuật</a>
                             <a href="Theloai.php?genre=Tài liệu">Tài liệu</a>
                 
                         </div>
                         <div class="column">
                             <a href="Theloai.php?genre=Viễn tưởng">Viễn tưởng</a>
                             <a href="Theloai.php?genre=Hoạt hình">Hoạt hình</a>
                             <a href="Theloai.php?genre=Thể thao">Thể thao</a>
                             <a href="Theloai.php?genre=Âm nhạc">Âm nhạc</a>
                             <a href="Theloai.php?genre=Gia đình">Gia đình</a>
                             <a href="Theloai.php?genre=Kinh dị">Kinh dị</a>
                             <a href="Theloai.php?genre=Tâm lý">Tâm lý</a>
                         </div>
                         <!-- Thêm các thể loại khác tương ứng với các option -->
                     </div>
                 
                     </div>
                
                 
                <a href="Yeuthich.php" class="nav-link">
                    <i class='bx bx-heart'></i>
                    <span class="nav-link-title">Yêu thích</span>
                </a>
            </div>
        </div>
    </header>
    <!-- Trang chủ -->
    <section class="home container" id="home">
        <!-- Home Image -->
        <img src="img/Solo_Leveling.jpg" alt="" class="home-img">
        <!-- Home Text -->
        <div class="home-text">
            <h1 class="home-title">Solo Leveling</h1>
            <p>Phát hành vào 01/2024</p>
            <a href="#" class="watch-btn">
                <i class='bx bx-right-arrow'></i>
                <span>Xem trailer</span>
            </a>
        </div>
    </section>
    <!-- Home End -->
    <!-- Popular Section Start -->
    <section class="popular container" id="popluar">
        <!-- Heading -->
        <div class="heading">
            <h2 class="heading-title">Movies Phổ Biến</h2>
        </div>
        <!-- Content -->
        <div class="popular-content swiper">
            <div class="swiper-wrapper">
                <!-- Movies Box 1 -->
                <div class="swiper-slide">
                    <div class="movie-box">
                        <img src="img/Tower_of_God.jpg" alt="" class="movie-box-img">
                        <div class="box-text">
                            <h2 class="movie-title">Tower Of God</h2>
                        <span class="movie-type">Hành Động, Phiêu Lưu, Hoạt Hình</span>
                        <a href="#" class="watch-btn play-btn">
                            <i class='bx bx-right-arrow'></i>
                        </a>
                        </div>
                    </div>
                </div>
                <!-- Movies Box 2 -->
                <div class="swiper-slide">
                    <div class="movie-box">
                        <img src="img/TGDQ.jpg" alt="" class="movie-box-img">
                        <div class="box-text">
                            <h2 class="movie-title">Demon Slayer - <br>Thanh gươm diệt quỷ</h2>
                        <span class="movie-type">Hành Động, Phiêu Lưu, Hoạt Hình</span>
                        <a href="#" class="watch-btn play-btn">
                            <i class='bx bx-right-arrow'></i>
                        </a>
                        </div>
                    </div>
                </div>
                 <!-- Movies Box 3 -->
                 <div class="swiper-slide">
                    <div class="movie-box">
                        <img src="img/One Piece_ Stampede.jpg" alt="" class="movie-box-img">
                        <div class="box-text">
                            <h2 class="movie-title">One Piece - <br>Stampded</h2>
                        <span class="movie-type">Hành Động, Phiêu Lưu, Hoạt Hình</span>
                        <a href="#" class="watch-btn play-btn">
                            <i class='bx bx-right-arrow'></i>
                        </a>
                        </div>
                    </div>
                </div>
                <!-- Movies Box 4 -->
                <div class="swiper-slide">
                    <div class="movie-box">
                        <img src="img/Bách Luyện Thành Thần.jpg" alt="" class="movie-box-img">
                        <div class="box-text">
                            <h2 class="movie-title">Bách luyện thành thần</h2>
                        <span class="movie-type">Hành Động, Phiêu Lưu, Hoạt Hình</span>
                        <a href="#" class="watch-btn play-btn">
                            <i class='bx bx-right-arrow'></i>
                        </a>
                        </div>
                    </div>
                </div>
                <!-- Movies Box 5 -->
                <div class="swiper-slide">
                    <div class="movie-box">
                        <img src="img/Watch Fairy Tail.png" alt="" class="movie-box-img">
                        <div class="box-text">
                            <h2 class="movie-title">Fairy Tail</h2>
                        <span class="movie-type">Hành Động, Phiêu Lưu, Hoạt Hình</span>
                        <a href="#" class="watch-btn play-btn">
                            <i class='bx bx-right-arrow'></i>
                        </a>
                        </div>  
                    </div>
                </div>
                <!-- Movies Box 6 -->
                <div class="swiper-slide">
                    <div class="movie-box">
                        <img src="img/Jujutsu Kaisen.jpg" alt="" class="movie-box-img">
                        <div class="box-text">
                            <h2 class="movie-title">Jujutsu Kaisen - <br>Chú Thuật Hồi Chiến</h2>
                        <span class="movie-type">Hành Động, Hoạt Hình</span>
                        <a href="#" class="watch-btn play-btn">
                            <i class='bx bx-right-arrow'></i>
                        </a>
                        </div>
                    </div>
                </div>
                <!-- Movies Box 7 -->
                <div class="swiper-slide">
                    <div class="movie-box">
                        <img src="img/Kaguya Shinomiya_Image Gallery.png" alt="" class="movie-box-img">
                        <div class="box-text">
                            <h2 class="movie-title">Kaguya Shinomiya</h2>
                        <span class="movie-type">Học Đường, Lãng Mạn, Hoạt Hình</span>
                        <a href="#" class="watch-btn play-btn">
                            <i class='bx bx-right-arrow'></i>
                        </a>
                        </div>
                    </div>
                </div>
                <!-- Movies Box 8 -->
                <div class="swiper-slide">
                    <div class="movie-box">
                        <img src="img/SPY×FAMILY (2022).jpg" alt="" class="movie-box-img">
                        <div class="box-text">
                            <h2 class="movie-title">Spy Family</h2>
                        <span class="movie-type">Gia đình, Lãng Mạn, Hoạt Hình</span>
                        <a href="#" class="watch-btn play-btn">
                            <i class='bx bx-right-arrow'></i>
                        </a>
                        </div>
                    </div>
                </div>
                <!-- Movies Box 9 -->
                <div class="swiper-slide">
                    <div class="movie-box">
                        <img src="img/Conan.jpg" alt="" class="movie-box-img">
                        <div class="box-text">
                            <h2 class="movie-title">Conan</h2>
                        <span class="movie-type">Hành Động, Trinh thám, Hoạt Hình</span>
                        <a href="#" class="watch-btn play-btn">
                            <i class='bx bx-right-arrow'></i>
                        </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </section>
    <!-- Popular Section End-->

    <!-- Link Swiper JS -->
    <script src="js/cdn.jsdelivr.net_npm_swiper@10.0.4_swiper-bundle.min.js"></script>
    <!-- Link to JS -->
    <script src="js/main.js"></script>
    <script src="dropdown.js"></script>
</body>
</html>

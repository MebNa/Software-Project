<?php
include 'db_connection.php';


session_start();


if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = null;
}

if ($_SESSION['user_id'] !== null) {
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM users WHERE id = '$user_id'";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    }
}


if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT movies.title, trailers.video_link, COUNT(episodes.id) AS episode_count
            FROM movies
            INNER JOIN trailers ON movies.id = trailers.movie_id
            LEFT JOIN episodes ON movies.id = episodes.movie_id
            WHERE movies.id = $id";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $title = $row['title'];
        $videoLink = $row['video_link'];
        $episodeCount = $row['episode_count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xem Trailer - <?php echo $title; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="img/fav-icon.png" type="image/x-icon">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="dropdown.css">
    <style>
          .video-container {
                position: relative;
                width: 100%;
                height: 0;
                padding-bottom: 56.25%; /* Tỷ lệ 16:9 */
            }
            
            .video-container iframe {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
            }
            
            .movie-details.container {
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
                margin-top: 60px;
            }
            .episode-list {
                margin-top: 15px;
                padding: 15px 20px;
                background-color: #272735;
                border-radius: 8px;
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                margin-bottom: 40px;
            }
            
               .container h3 {
                font-size: 30px;
                margin-bottom: 5px;
                color: #E91A46;
                margin-top: 40px;
            }
            
            .episode-list ul {
                padding: 0;
                display: flex;
                flex-direction: row;
                flex-wrap: wrap;
            }
            
            .episode-list li {
                padding: 10px 15px;
                border-radius: 10px;
                margin-right: 10px;
                background-color: #272735;
                color: white;
            }
            
            .episode-list li:hover {
                background-color: #E91A46;
                color: white;
                cursor: pointer;
            }
            
            .current-episode-title {
                margin-top: 20px;
                font-weight: bold;
                font-size: 28px;
                margin-bottom: 20px;
            }
            
            .comment-section {
                margin-top: 20px;
                padding: 10px;
                background-color:#272735;
            }

            a {
                color: white; 
            }
            
    </style>
</head>
<body>
    <header>
    <div class="nav container">

<a href="Trangchu.php?user_id=<?php echo $_SESSION['user_id']; ?>" class="logo">
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
        <i class="bx bx-home"></i>
        <span class="nav-link-title">Trang chủ</span>
    </a>

    <a href="Trangchu.php?user_id=<?php echo $_SESSION['user_id']; ?>" class="nav-link">
        <i class="bx bxs-hot"></i>
        <span class="nav-link-title">Thịnh hành</span>
    </a>

    <a href="PhimBo.php?user_id=<?php echo $_SESSION['user_id']; ?>" class="nav-link">
        <i class="bx bxs-movie"></i>
        <span class="nav-link-title">Phim bộ</span>
    </a>

    <a href="PhimLe.php?user_id=<?php echo $_SESSION['user_id']; ?>" class="nav-link">
        <i class="bx bxs-film"></i>
        <span class="nav-link-title">Phim lẻ</span>
    </a>

    <div class="dropdown-toggle-container" id="genre-dropdown-toggle">
<a href="#" class="nav-link dropdown ">
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
<!-- Thêm các thể loại khác tương ứng với các option -->
</div>

</div>

<a href="Yeuthich.php?user_id=<?php echo  $_SESSION['user_id']; ?>" class="nav-link">
                    <i class='bx bx-heart'></i>
                    <span class="nav-link-title">Yêu thích</span>
                </a>

</div>
</div>
    </header>
    <section class="movie-details container">
        <div class="container">
            <div class="current-episode-title">
                <p>Trailer phim '<?php echo $title; ?>'</p>
            </div>
            <div class="video-container">
                <iframe src="<?php echo $videoLink; ?>" frameborder="0" allowfullscreen></iframe>
            </div>

            <h3>Danh sách tập phim</h3>
            <div class="episode-list">
                <ul>
                    <li><a href="XemTrailer.php?id=<?php echo $id; ?>&user_id=<?php echo $_SESSION['user_id']; ?>">Trailer</a></li>
                    <?php
                    for ($i = 1; $i <= $episodeCount; $i++) {
                        ?>
                        <li><a href="XemTap.php?id=<?php echo $id; ?>&episode=<?php echo $i; ?>&user_id=<?php echo $_SESSION['user_id']; ?>">Tập <?php echo $i; ?></a></li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
        </div>

        <?php
        // Gọi file comment.php
        include 'comment.php';
        ?>

    </section>
    <script src="js/main.js"></script>
    <script src="dropdown.js"></script>
</body>
</html>

<?php
    } else {
        echo "Không tìm thấy trailer của phim.";
    }
} else {
    echo "Không có id phim được truyền vào.";
}

$connection->close();
?>

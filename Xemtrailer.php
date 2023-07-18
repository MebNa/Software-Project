<?php
// Kết nối đến cơ sở dữ liệu
include 'db_connection.php';

// Kiểm tra xem id phim đã được truyền vào hay chưa
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Truy vấn thông tin phim dựa trên id
    $sql = "SELECT movies.title, trailers.video_link, COUNT(episodes.id) AS episode_count
            FROM movies
            INNER JOIN trailers ON movies.id = trailers.movie_id
            LEFT JOIN episodes ON movies.id = episodes.movie_id
            WHERE movies.id = $id";
    $result = $connection->query($sql);

    // Kiểm tra xem có kết quả trả về hay không
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $title = $row['title'];
        $videoLink = $row['video_link'];
        $episodeCount = $row['episode_count'];

        // Hiển thị trailer của phim
        echo '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Xem Trailer - ' . $title . '</title>
            <link rel="stylesheet" href="css/style.css">
            <link rel="shortcut icon" href="img/fav-icon.png" type="image/x-icon">
            <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
            <link rel="stylesheet" type="text/css" href="dropdown.css">
            <style>
            /* CSS cho phần khung xem phim */
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
                margin-top: 20px;
                padding: 15px 20px;
                background-color: #272735;
                border-radius: 8px;
                display: flex;
                flex-direction: column;
                align-items: flex-start;
            }
            
            .episode-list h3 {
                font-size: 24px;
                margin-bottom: 5px;
                color: #E91A46;
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

            /* CSS cho màu chữ trong liên kết */
            a {
                color: white; /* Đặt màu chữ là màu trắng */
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
                        <form method="post" style="display: flex;">
                            <input type="text" name="noidung" autocomplete="off" id="search-input" placeholder="Search Movies">
                            <button class="search-button" type="submit" name="btn">
                                <a href="Search.html"><i class="bx bx-search"></i></a>
                            </button>
                        </form>
                    </div>
                    <a href="#" class="user">
                        <img src="img/images.png" alt="" class="user-img">
                    </a>
                    <div class="navbar">
                        <a href="TrangChu.php" class="nav-link">
                            <i class="bx bx-home"></i>
                            <span class="nav-link-title">Trang chủ</span>
                        </a>
                        <a href="#home" class="nav-link">
                            <i class="bx bxs-hot"></i>
                            <span class="nav-link-title">Thịnh hành</span>
                        </a>
                        <a href="PhimBo.php" class="nav-link">
                            <i class="bx bxs-movie"></i>
                            <span class="nav-link-title">Phim bộ</span>
                        </a>
                        <a href="PhimLe.php" class="nav-link">
                            <i class="bx bxs-film"></i>
                            <span class="nav-link-title">Phim lẻ</span>
                            
                        </a>
                        <div class="dropdown-toggle-container" id="genre-dropdown-toggle">
                <a href="#" class="nav-link dropdown">
                    <i class="bx bx-category nav-link-icon"></i>
                    <span class="nav-link-title">Thể loại</span>
                 </a>
                 <div class="dropdown-content">
                 <div class="column">
                     <a href="Theloai.php?genre=Hài hước">Hài hước</a>
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
                        <a href="#home" class="nav-link">
                            <i class="bx bx-heart"></i>
                            <span class="nav-link-title">Yêu thích</span>
                        </a>
                    </div>
                </div>
            </header>
            <section class="movie-details container">
              <div class = container>
                <div class="current-episode-title">
                    <!-- Hiển thị tên bộ phim đang chiếu trailer -->
                    <p>Trailer phim ' . $title . '</p>
                </div>
                <div class="video-container">
                    <!-- Khung xem trailer -->
                    <iframe src="' . $videoLink . '" frameborder="0" allowfullscreen></iframe>
                </div>

                <div class="episode-list">
                    <!-- Danh sách các tập phim -->
                    <h3>Danh sách tập phim</h3>
                    <ul>';
                    echo '<li><a href="XemTrailer.php?id=' . $id . '">Trailer</a></li>';
        for ($i = 1; $i <= $episodeCount; $i++) {
            echo '<li><a href="XemTap.php?id=' . $id . '&episode=' . $i . '">Tập ' . $i . '</a></li>';
        }
        echo '
                    </ul>
                </div>
                
               

              </div>
            </section>
            <script src="js/main.js"></script>
            <script src="dropdown.js"></script>
            
        </body>
        </html>';
    } else {
        echo "Không tìm thấy trailer của phim.";
    }
} else {
    echo "Không có id phim được truyền vào.";
}


// Đóng kết nối cơ sở dữ liệu
$connection->close();
?>

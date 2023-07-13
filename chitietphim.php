<?php
// Kết nối đến cơ sở dữ liệu
include 'db_connection.php';

// Kiểm tra xem id phim đã được truyền vào hay chưa
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Truy vấn thông tin phim dựa trên id
    $sql = "SELECT * FROM movies WHERE id = $id";
    $result = $connection->query($sql);

    // Kiểm tra xem có kết quả trả về hay không
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Hiển thị thông tin phim
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Chi tiết phim - <?php echo $row['title']; ?></title>
            <link rel="stylesheet" href="css/style.css">
            <link rel="shortcut icon" href="img/fav-icon.png" type="image/x-icon">
            <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
            <style>
                .movie-details.container {
                    display: flex;
                    flex-wrap: wrap;
                    justify-content: space-between;
                   //align-items: flex-start;
                    margin-top: 60px;

                }

                .movie-poster {
                    width: 35%;
                    position: relative;
                    cursor: pointer;
                    overflow: hidden;
                    border-radius: 20px;
                }

                .movie-poster img {
                    transition: filter 0.3s ease;
                }

                .movie-poster:hover img {
                    filter: brightness(0.7);
                }

                .play-icon {
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    display: none;
                    color: white;
                    font-size: 48px;
                    opacity: 0.8;
                }

                .movie-poster:hover .play-icon {
                    display: block;
                }

                .play-button {
                    position: absolute;
                    bottom: 0;
                    left: 0;
                    width: 100%;
                    display: none;
                    background-color: #e80535;
                    color: white;
                    padding: 10px 20px;
                    font-size: 18px;
                    opacity: 1;
                    z-index: 2;
                    text-align: center;
                    font-weight: bold;

                }

                .movie-poster:hover .play-button {
                    display: block;
                }

                .movie-info {
                    width: 65%;
                    padding-left: 32px;
                    font-size: 20px;
                    line-height: 2;
                }

                .movie-description {
                    width: 100%;
                    padding-top: 16px;
                    font-size: 22px;
                    line-height: 2;
                }

                .poster-info-container {
                    display: flex;
                    flex-wrap: wrap;
                    justify-content: space-between;
                    background-color: #22222E;
                    padding: 40px;
                    border-radius: 10px;
                    width: 100%;
                }

                .movie-title {
                    color: #E91A46;
                    font-weight: 550;
                }

                .movie-description h2 {
                    color: #E91A46;
                }

                .movie-info strong {
                    color: #B8B8B8
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
                            <i class="bx bxs-hot"></i>
                            <span class="nav-link-title">Thịnh hành</span>
                        </a>

                        <a href="PhimBo.php" class="nav-link nav-active">
                            <i class="bx bxs-movie"></i>
                            <span class="nav-link-title">Phim bộ</span>
                        </a>

                        <a href="PhimLe.php" class="nav-link">
                            <i class="bx bxs-film"></i>
                            <span class="nav-link-title">Phim lẻ</span>
                        </a>

                        <a href="#home" class="nav-link">
                            <i class="bx bx-category"></i>
                            <span class="nav-link-title">Thể loại</span>
                        </a>

                        <a href="#home" class="nav-link">
                            <i class="bx bx-heart"></i>
                            <span class="nav-link-title">Yêu thích</span>
                        </a>

                    </div>
                </div>
            </header>
            <section class="movie-details container">

                <div class="poster-info-container">
                    <div class="movie-poster">
                        <a href="Xemtrailer.php?id=<?php echo $row['id']; ?>">
                            <img src="<?php echo $row['image']; ?>" alt="Movie Poster">
                            <i class="play-icon bx bx-play-circle"></i>
                            <div class="play-button">Xem phim</div>
                        </a>
                    </div>
                    <div class="movie-info">
                        <h2 class="movie-title"><?php echo $row['title']; ?></h2>
                        <p><strong>Tên khác:</strong> <?php echo $row['othertitle']; ?></p>
                        <p><strong>Năm sản xuất:</strong> <?php echo $row['release_year']; ?></p>
                        <p><strong>Thể loại:</strong> <?php echo $row['genre']; ?></p>
                        <p><strong>Trạng thái:</strong> <?php echo $row['status']; ?></p>
                        <p><strong>Số tập:</strong> <?php echo $row['episodes']; ?></p>
                        <p><strong>Diễn viên:</strong> <?php echo $row['actors']; ?></p>
                        <p><strong>Đạo diễn:</strong> <?php echo $row['director']; ?></p>
                    </div>
                </div>
                <div class="movie-description">
                    <h2>Nội dung chi tiết</h2>
                    <p><?php echo $row['summary']; ?></p>
                </div>


            </section>
            <script src="js/main.js"></script>

        </body>

        </html>
<?php
    } else {
        echo "Không tìm thấy phim.";
    }
} else {
    echo "Không có id phim được truyền vào.";
}

// Đóng kết nối cơ sở dữ liệu
$connection->close();
?>

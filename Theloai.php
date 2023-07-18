<?php
// Kết nối đến cơ sở dữ liệu
include 'db_connection.php';
session_start();
// Xác định số phần tử trên mỗi trang và trang hiện tại
$itemsPerPage = 4; // Số phim thể loại hiển thị trên mỗi trang
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; // Trang hiện tại, mặc định là trang đầu tiên

// Xác định thể loại phim từ biến đầu vào
$genre = isset($_GET['genre']) ? $_GET['genre'] : '';

// Xác định user_id từ biến đầu vào
if (isset($_GET['user_id'])) {
    $_SESSION['user_id'] = $_GET['user_id'];
} else {
    $_SESSION['user_id'] = null;
}

// Tính toán số phần tử bỏ qua
$offset = ($page - 1) * $itemsPerPage;
if ($offset < 0) {
    $offset = 0;
}

// Truy vấn danh sách phim theo thể loại từ cơ sở dữ liệu với phân trang
$sql = "SELECT * FROM movies WHERE genre LIKE '%$genre%' LIMIT $itemsPerPage OFFSET $offset";
$result = $connection->query($sql);

// Truy vấn để đếm tổng số phim theo thể loại
$sqlCount = "SELECT COUNT(*) AS total FROM movies WHERE genre LIKE '%$genre%'";
$resultCount = $connection->query($sqlCount);
$rowCount = $resultCount->fetch_assoc();
$totalItems = $rowCount['total']; // Tổng số phim theo thể loại
$totalPages = ceil($totalItems / $itemsPerPage); // Tổng số trang

// Xử lý khi người dùng nhấp vào nút Đến trang hoặc bấm Enter
if (isset($_POST['go']) || isset($_POST['targetPage'])) {
    $targetPage = isset($_POST['targetPage']) ? $_POST['targetPage'] : $_POST['targetPageEnter'];
    // Kiểm tra xem trang hợp lệ hay không
    if ($targetPage >= 1 && $targetPage <= $totalPages) {
        $page = $targetPage;
        $offset = ($page - 1) * $itemsPerPage;
        $sql = "SELECT * FROM movies WHERE genre LIKE '%$genre%' LIMIT $itemsPerPage OFFSET $offset";
        $result = $connection->query($sql);
    }
}

// Đầu trang HTML
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ManhwaMovies - Thể loại</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="img/fav-icon.png" type="image/x-icon">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="dropdown.css">
    <style>
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 1.5rem;
            flex-direction: row;
        }

        .page-link {
            display: inline-block;
            padding: 0.5rem 1rem;
            background-color: var(--container-color);
            color: var(--text-color);
            border-radius: 6px;
            margin-right: 0.5rem;
            font-size: 0.938rem;
            transition: background-color 0.3s ease;
        }

        .page-link:hover {
            background-color: red;
        }

        .active {
            background-color: var(--main-color);
            color: var(--text-color);
        }

        .page-input-form {
            display: flex;
            align-items: center;
        }

        .page-input {
            width: 100px;
            padding: 0.3rem;
            font-size: 0.938rem;
            border: 1px solid var(--container-color);
            border-radius: 4px;
            margin-right: 0.5rem;
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
                        <a href="search.php"><i class="bx bx-search"></i> </a>
                    </button>
                </form>
            </div>
            <a href="#" class="user">
                <img src="img/images.png" alt="" class="user-img">
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
                            <a href="Theloai.php?genre=Hài hước&user_id=<?= $_SESSION['user_id'] ?>">Hài hước</a>
                            <a href="Theloai.php?genre=Hành động&user_id=<?= $_SESSION['user_id'] ?>">Hành động</a>
                            <a href="Theloai.php?genre=Phiêu lưu&user_id=<?= $_SESSION['user_id'] ?>">Phiêu lưu</a>
                            <a href="Theloai.php?genre=Tình cảm&user_id=<?= $_SESSION['user_id'] ?>">Tình cảm</a>
                            <a href="Theloai.php?genre=Học đường&user_id=<?= $_SESSION['user_id'] ?>">Học đường</a>
                            <a href="Theloai.php?genre=Võ thuật&user_id=<?= $_SESSION['user_id'] ?>">Võ thuật</a>
                            <a href="Theloai.php?genre=Tài liệu&user_id=<?= $_SESSION['user_id'] ?>">Tài liệu</a>
                        </div>
                        <div class="column">
                            <a href="Theloai.php?genre=Viễn tưởng&user_id=<?= $_SESSION['user_id'] ?>">Viễn tưởng</a>
                            <a href="Theloai.php?genre=Hoạt hình&user_id=<?= $_SESSION['user_id'] ?>">Hoạt hình</a>
                            <a href="Theloai.php?genre=Thể thao&user_id=<?= $_SESSION['user_id'] ?>">Thể thao</a>
                            <a href="Theloai.php?genre=Âm nhạc&user_id=<?= $_SESSION['user_id'] ?>">Âm nhạc</a>
                            <a href="Theloai.php?genre=Gia đình&user_id=<?= $_SESSION['user_id'] ?>">Gia đình</a>
                            <a href="Theloai.php?genre=Kinh dị&user_id=<?= $_SESSION['user_id'] ?>">Kinh dị</a>
                            <a href="Theloai.php?genre=Tâm lý&user_id=<?= $_SESSION['user_id'] ?>">Tâm lý</a>
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
    
    <section class="popular container" id="popular" style="margin-top: 80px;">
        <div class="heading">
            <h2 class="heading-title">Danh sách phim thể loại '<?= $genre ?>' - Trang <?= $page ?></h2>
        </div>
        <div class="popular-content">
            <div class="movie-grid">
<?php        
// Hiển thị danh sách phim theo thể loại
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
?>
        <div class="movie-box">
            <img src="<?= $row['image'] ?>" alt="" class="movie-box-img">
            <div class="box-text">
                <h2 class="movie-title"><?= $row['title'] ?></h2>
                <span class="movie-type"><?= $row['genre'] ?></span>
                <a href="chitietphim.php?id=<?= $row['id'] ?>&user_id=<?= $_SESSION['user_id'] ?>" class="watch-btn play-btn">
                    <i class="bx bx-right-arrow"></i>
                </a>
            </div>
        </div>
<?php
    }
} else {
    echo "Không có phim thuộc thể loại này trong cơ sở dữ liệu.";
}

// Hiển thị khung phân trang
?>
            </div>
        </div>
        <div class="pagination">
<?php
// Kiểm tra trang hiện tại
if ($page > 1) {
?>
    <a href="Theloai.php?genre=<?= $genre ?>&page=<?= ($page - 1) ?>&user_id=<?= $_SESSION['user_id'] ?>" class="page-link">Trang trước</a>
<?php
}

?>
    <form method="get" class="page-input-form" id="page-form" action="Theloai.php">
        <input type="hidden" name="genre" value="<?= $genre ?>">
        <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
        <input type="number" name="page" min="1" max="<?= $totalPages ?>" class="page-input" placeholder="Số trang" id="target-page">
    </form>
<?php
// Kiểm tra trang tiếp theo
if ($page < $totalPages) {
?>
    <a href="Theloai.php?genre=<?= $genre ?>&page=<?= ($page + 1) ?>&user_id=<?= $_SESSION['user_id'] ?>" class="page-link">Trang sau</a>
<?php
}

?>
        </div>
    </section>

    <script src="js/main.js"></script>
    <script src="dropdown.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var input = document.getElementById("target-page");

            input.addEventListener("keyup", function(event) {
                if (event.keyCode === 13) { // Kiểm tra nếu phím nhấn là Enter
                    event.preventDefault(); // Ngăn chặn hành vi mặc định của phím Enter (gửi biểu mẫu)

                    var targetPage = parseInt(input.value);
                    if (targetPage >= 1 && targetPage <= <?= $totalPages ?>) {
                        document.getElementById("page-form").submit(); // Gửi biểu mẫu để chuyển đến trang tương ứng
                    }
                }
            });
        });
    </script>

</body>
</html>
<?php
// Đóng kết nối cơ sở dữ liệu
$connection->close();
?>

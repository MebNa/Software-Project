<?php
// Kết nối đến cơ sở dữ liệu
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "movie_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Không thể kết nối đến cơ sở dữ liệu: " . $conn->connect_error);
}

// Lấy dữ liệu từ biểu mẫu
$title = $_POST['title'];
$image = $_POST['image'];
$releaseYear = $_POST['release_year'];
$country = $_POST['country'];
$genre = $_POST['genre'];
$status = $_POST['status'];
$episodes = $_POST['episodes'];
$actors = $_POST['actors'];
$director = $_POST['director'];
$summary = $_POST['summary'];

// Thực thi truy vấn để thêm dữ liệu vào bảng "movies"
$sql = "INSERT INTO movies (title, image, release_year, country, genre, status, episodes, actors, director, summary) 
        VALUES ('$title', '$image', '$releaseYear', '$country', '$genre', '$status', '$episodes', '$actors', '$director', '$summary')";

if ($conn->query($sql) === TRUE) {
    echo '<script>alert("Thêm phim thành công");</script>';
} else {
    echo "Lỗi: " . $conn->error;
}

if ($conn->connect_error) {
    echo '<script>alert("Không thể kết nối đến cơ sở dữ liệu: ' . $conn->connect_error . '");</script>';
    die("Không thể kết nối đến cơ sở dữ liệu: " . $conn->connect_error);
}

// Đóng kết nối
$conn->close();
?>

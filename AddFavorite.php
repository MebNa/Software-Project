<?php
// Kết nối đến cơ sở dữ liệu
include 'db_connection.php';

session_start();

// Kiểm tra xem user_id đã tồn tại trong $_SESSION hay chưa
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = null;
}

// Kiểm tra xem user đã đăng nhập hay chưa
if ($user_id !== null) {
    // Kiểm tra xem id phim đã được truyền vào hay chưa
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Truy vấn thông tin phim dựa trên id
        $sql = "SELECT * FROM movies WHERE id = $id";
        $result = $connection->query($sql);

        // Kiểm tra xem có kết quả trả về hay không
        if ($result->num_rows > 0) {
            // Kiểm tra xem bộ phim đã có trong danh sách yêu thích của user chưa
            $checkSql = "SELECT * FROM favorites WHERE user_id = '$user_id' AND movie_id = '$id'";
            $checkResult = $connection->query($checkSql);

            if ($checkResult->num_rows > 0) {
                // Bộ phim đã có trong danh sách yêu thích của user
                echo "<script>
                    alert('Bộ phim đã có trong danh sách yêu thích của bạn.');
                    window.location.href = 'chitietphim.php?id=$id&user_id=$user_id';
                </script>";
            } else {
                // Thêm bộ phim vào danh sách yêu thích
                $insertSql = "INSERT INTO favorites (user_id, movie_id) VALUES ('$user_id', '$id')";
                $insertResult = $connection->query($insertSql);

                if ($insertResult === true) {
                    // Bộ phim đã được thêm vào danh sách yêu thích của user
                    echo "<script>
                        alert('Bộ phim đã được thêm vào danh sách yêu thích của bạn.');
                        window.location.href = 'chitietphim.php?id=$id&user_id=$user_id';
                    </script>";
                } else {
                    // Xảy ra lỗi khi thêm bộ phim vào danh sách yêu thích
                    echo "<script>
                        alert('Đã xảy ra lỗi. Vui lòng thử lại sau.');
                        window.location.href = 'chitietphim.php?id=$id&user_id=$user_id';
                    </script>";
                }
            }
        } else {
            // Không tìm thấy phim
            echo "<script>
                alert('Không tìm thấy phim.');
                window.location.href = 'chitietphim.php?id=$id&user_id=$user_id';
            </script>";
        }
    } else {
        // Không có id phim được truyền vào
        echo "<script>
            alert('Không có id phim được truyền vào.');
            window.location.href = 'chitietphim.php?id=$id&user_id=$user_id';
        </script>";
    }
} else {
    // Người dùng chưa đăng nhập
    echo "<script>
        alert('Bạn phải đăng nhập để thực hiện thao tác này.');
        window.location.href = 'chitietphim.php?id=$id&user_id=$user_id';
    </script>";
}

// Đóng kết nối cơ sở dữ liệu
$connection->close();
?>

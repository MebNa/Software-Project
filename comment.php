<?php
// Kết nối đến cơ sở dữ liệu
include 'db_connection.php';

// Kiểm tra xem id phim đã được truyền vào hay chưa
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Lấy user_id từ tham số truy vấn (nếu tồn tại)
    $userId = isset($_GET['user_id']) ? $_GET['user_id'] : null;

    // Truy vấn danh sách bình luận dựa trên id phim
    $commentsSql = "SELECT c.comment, c.created_at, u.username, u.avatar_link FROM comments c JOIN users u ON c.user_id = u.id WHERE c.movie_id = $id";

    // Kiểm tra tùy chọn sắp xếp
    $sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';

    if ($sort == 'newest') {
        $commentsSql .= " ORDER BY c.created_at DESC";
    } elseif ($sort == 'oldest') {
        $commentsSql .= " ORDER BY c.created_at ASC";
    }

    // Truy vấn danh sách bình luận
    $commentsResult = $connection->query($commentsSql);

    if ($commentsResult) {
        // Lấy tổng số bình luận
        $totalComments = $commentsResult->num_rows;

        // Số bình luận hiển thị trên mỗi trang
        $commentsPerPage = 5;

        // Tính số trang bình luận
        $totalPages = ceil($totalComments / $commentsPerPage);

        // Xác định trang hiện tại
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

        // Xác định giới hạn bắt đầu và kết thúc của các bình luận trên trang hiện tại
        $limitStart = ($currentPage - 1) * $commentsPerPage;
        $limitEnd = $limitStart + $commentsPerPage;

        // Truy vấn danh sách bình luận với giới hạn trang hiện tại
        $commentsSql .= " LIMIT $limitStart, $commentsPerPage";
        $commentsResult = $connection->query($commentsSql);

        // Xử lý gửi bình luận
        if (isset($_POST['comment']) && isset($_POST['user_id'])) {
            $userId = $_POST['user_id'];
            $comment = $_POST['comment'];

            // Kiểm tra xem user_id có tồn tại trong bảng "users" hay không
            $checkUserQuery = "SELECT id FROM users WHERE id = '$userId'";
            $result = $connection->query($checkUserQuery);

            if ($result->num_rows > 0) {
                // User_id tồn tại trong bảng "users"
                $insertCommentSql = "INSERT INTO comments (movie_id, comment, created_at, user_id) VALUES ('$id', '$comment', NOW(), '$userId')";
                if ($connection->query($insertCommentSql) === TRUE) {
                    // Hiển thị thông báo JavaScript
                    echo "<script>
                            alert('Bình luận đã được gửi thành công.');
                            window.location.href = 'chitietphim.php?id=$id&sort=$sort&page=$currentPage&user_id=$userId';
                        </script>";
                    exit;
                } else {
                    echo "Lỗi: " . $insertCommentSql . "<br>" . $connection->error;
                }
            }
        }

        // Hiển thị khung bình luận và danh sách bình luận trong cùng một div
        ?>
        <style>
            .comment-container {
                margin-bottom: 20px;
                width: 100%;
            }

            .commenth2 {
                font-size: 30px;
                margin-bottom: 15px;
                color: #E91A46;
            }

            .comment-container form {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
            }

            .comment-container textarea {
                width: 100%;
                height: 80px;
                margin-bottom: 10px;
                padding: 8px;
                resize: vertical;
                border-radius: 10px;
            }

            .comment-container button {
                padding: 8px 20px;
                background-color: var(--main-color);
                color: var(--text-color);
                border: none;
                border-radius: 8px;
                cursor: pointer;

            }

            .comment-container button:hover {
                background-color: var(--hover-color);
            }

            .comment-list {
                margin-bottom: 15px;
                width: 100%;
                margin-top: 45px;
            }

            .comment-list h2 {
                font-size: 30px;
                margin-bottom: 25px;
                color: #E91A46;
            }

            .comment {
                margin-bottom: 10px;
                padding: 10px;
                background-color: var(--container-color);
                border-radius: 10px;
                padding-top: 15px;
            }

            .comment p:first-child {
                font-weight: bold;
                margin-bottom: 5px;
            }

            .pagination {
                margin-top: 20px;
            }

            .pagination a {
                display: inline-block;
                padding: 4px 8px;
                background-color: var(--container-color);
                color: var(--text-color);
                border-radius: 4px;
                margin-right: 5px;
                text-decoration: none;
            }

            .pagination a.current {
                background-color: var(--main-color);
                color: var(--text-color);
            }

            .pagination a.active {
                background-color: red;
            }

            /* New CSS rules */
            .comment-container .avatar-comment {
                display: flex;
                padding-bottom: 15px;
            }

            .comment-container .avatar {
                margin-right: 10px;
                width: 50px;
                height: 50px;
            }

            .comment-container .comment-content {
                flex: 1;
                background-color: var(--container-color);
                margin-left: 10px;
                padding-bottom: 20px;
            }

            .comment-container .comment-content .username {
                background-color: #E91A46;
                color: white;
                padding: 10px;
                display: inline-block;
                margin-bottom: 20px;
                width: 100%;
                font-size: 20px;
            }

            .comment-container .comment-content .content {
                padding: 5px;
                padding-left: 15px;
            }

            .comment-container .timestamp {
                padding-bottom: 10px;
                margin-left: 400px;
            }

            /* Các định dạng CSS khác */

            .comment-container p {
                color: white;
                margin-bottom: 10px;
                margin-top: 10px;
            }

            .comment-container a {
                color: red;
            }

            .comment-container a:hover {
                color: var(--hover-color);
            }
        </style>

        <h2 class="commenth2">Bình luận</h2>
        <div class="comment-container">
            <?php
            if (isset($_GET['user_id'])) {
                $userId = $_GET['user_id'];
                $checkUserQuery = "SELECT id FROM users WHERE id = '$userId'";
                $result = $connection->query($checkUserQuery);

                if ($result->num_rows > 0) { ?>
                    <form method="post" action="">
                        <input type="hidden" name="movie_id" value="<?php echo $id; ?>">
                        <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
                        <textarea name="comment" placeholder="Nhập bình luận của bạn"></textarea>
                        <button type="submit">Gửi</button>
                    </form>
                <?php } else {
                    echo "<p>Vui lòng đăng nhập trước khi bình luận.</p>";
                    echo "<a href='Dangnhap.php'>Đăng nhập</a>";
                }
            }
            ?>

            <div class="comment-list">
                <?php
                if ($commentsResult->num_rows > 0) {
                    while ($comment = $commentsResult->fetch_assoc()) {
                        echo "<div class='comment'>";
                        echo "<div class='avatar-comment'>";
                        echo "<div class='avatar'>";
                        echo "<img src='" . $comment['avatar_link'] . "' alt='Avatar'>";
                        echo "</div>";
                        echo "<div class='comment-content'>";
                        echo "<p class='username'>" . $comment['username'] . "</p>";
                        echo "<p class='content'>" . $comment['comment'] . "</p>";
                        echo "</div>";
                        echo "</div>";
                        echo "<p class='timestamp'>" . $comment['created_at'] . "</p>";
                        echo "</div>";
                    }
                } else {
                    echo "Chưa có bình luận nào.";
                }
                ?>
            </div>
        </div>

        <?php
        // Hiển thị phân trang nếu có nhiều hơn 1 trang
        if ($totalPages > 1) {
            echo "<div class='pagination'>";
            echo "<a href='chitietphim.php?id=$id&page=1&sort=newest&user_id=$userId' class='" . ($sort == 'newest' ? 'active' : '') . "'>Newest</a>";
            echo "<a href='chitietphim.php?id=$id&page=1&sort=oldest&user_id=$userId' class='" . ($sort == 'oldest' ? 'active' : '') . "'>Oldest</a>";
            for ($i = 1; $i <= $totalPages; $i++) {
                $activeClass = ($i == $currentPage) ? "current" : "";
                echo "<a href='chitietphim.php?id=$id&page=$i&sort=$sort&user_id=$userId' class='$activeClass'>$i</a>";
            }
            echo "</div>";
        }
    } else {
        echo "Đã xảy ra lỗi khi truy vấn cơ sở dữ liệu.";
    }
} else {
    echo "Không có id phim được truyền vào.";
}

// Đóng kết nối cơ sở dữ liệu

?>

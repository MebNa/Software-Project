<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách yêu thích</title>
    <style>
       <style>
        /* CSS */
        * {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            scroll-behavior: smooth;
            box-sizing: border-box;
            scroll-padding-top: 2rem;
        }

        :root {
            --main-color: #e70634;
            --hover-color: hsl(37, 94%, 57%);
            --body-color: #1e1e2a;
            --container-color: #2d2e37;
            --text-color: #fcfeff;
        }

        body {
            background: var(--body-color);
            color: var(--text-color);
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .favorite-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .favorite-movie {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 220px;
            border-radius: 8px;
            background-color: var(--container-color);
            padding: 10px;
        }

        .favorite-movie img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .movie-info {
            text-align: center;
        }

        .movie-title {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 10px;
            color: var(--text-color);
        }

        .movie-type {
            font-size: 0.9rem;
            line-height: 1.5;
            color: var(--text-color);
        }

        .delete-button {
            background-color: var(--main-color);
            color: var(--text-color);
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            font-size: 1rem;
            cursor: pointer;
            margin-top: 20px;
        }

        .delete-button:hover {
            background-color: var(--hover-color);
        }

        .no-favorite {
            text-align: center;
            color: var(--text-color);
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <?php
    // Kết nối đến cơ sở dữ liệu
    include 'db_connection.php';

    // Bắt đầu phiên làm việc với session
    session_start();

    // Kiểm tra xem user_id đã tồn tại trong $_SESSION hay chưa
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // Truy vấn danh sách phim yêu thích của user
        $sql = "SELECT movies.* FROM movies
                INNER JOIN favorites ON movies.id = favorites.movie_id
                WHERE favorites.user_id = $user_id";
        $result = $connection->query($sql);

        // Kiểm tra xem có phim yêu thích hay không
        if ($result->num_rows > 0) {
    ?>
            <div class='container'>
                <form id='favorite-form' method='POST'>
                    <div class='favorite-container'>
                        <!-- Hiển thị danh sách phim yêu thích -->
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <div class='favorite-movie'>
                                <input type='checkbox' name='favorite[]' value='<?php echo $row['id']; ?>'>
                                <img src='<?php echo $row['image']; ?>' alt='Movie Poster'>
                                <div class='movie-info'>
                                    <h2 class='movie-title'><?php echo $row['title']; ?></h2>
                                    <p class='movie-type'><?php echo $row['summary']; ?></p>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <button type='submit' name='delete' onclick='return confirm("Bạn có chắc chắn muốn xóa?")' class='delete-button'>Xóa khỏi danh sách yêu thích</button>
                </form>
            </div>
    <?php
        } else {
            echo "<div class='container'>";
            echo "<p class='no-favorite'>Bạn chưa có bộ phim nào trong danh sách yêu thích.</p>";
            echo "</div>";
        }

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
                echo "<script>window.location.href = 'Yeuthich.php';</script>";
            }
        }
    } else {
        echo "<div class='container'>";
        echo "<p class='no-favorite'>Bạn phải đăng nhập để xem danh sách yêu thích.</p>";
        echo "</div>";
        // Hiển thị nút Đăng nhập và điều hướng đến trang Đăng nhập
        echo "<div class='container'>";
        echo "<a href='Dangnhap.php'>Đăng nhập</a>";
        echo "</div>";
    }

    // Đóng kết nối cơ sở dữ liệu
    $connection->close();
    ?>
</body>

</html>

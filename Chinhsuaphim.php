<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa thông tin phim</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins&display=swap">
    <link rel="shortcut icon" href="img/fav-icon.png" type="image/x-icon">
    <style>
        /* Your additional CSS styles here */

        /* Remaining CSS styles from your previous code */

        /* Google Fonts */
        body {
            font-family: 'Poppins', sans-serif;
        }

        /* Add your custom styles here */

        /* Container */
        .container {
            background: var(--container-color);
            padding: 2rem;
            border-radius: 0.5rem;
            margin-top: 5rem;
        }

        /* Heading */
        .container h1 {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 2rem;
            color: var(--main-color);
        }

        /* Form */
        form div {
            margin-bottom: 1rem;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 15px;
            color: var(--text-color);
        }

        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
            margin-bottom: 15px;
            background: transparent;
            color: var(--text-color);
            resize: vertical;
        }

        textarea {
            height: 120px;
        }

        button {
            background-color: var(--main-color);
            color: var(--text-color);
            padding: 10px 30px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
        }

        button:hover {
            background-color: var(--hover-color);
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <!-- Your header content here -->
    </header>

    <section class="container">
        <h1>Chỉnh sửa thông tin phim</h1>
        <?php
        // Kết nối đến cơ sở dữ liệu
        include 'db_connection.php';

        // Kiểm tra xem user_id đã tồn tại trong $_SESSION hay chưa
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
        } else {
            echo '<script>
                alert("Vui lòng đăng nhập trước khi vào trang chỉnh sửa");
                window.location.href = "Dangnhap.php";
                </script>';
            exit();
        }

        // Lấy thông tin phim từ cơ sở dữ liệu
        $movie_id = $_GET['movie_id'];
        $sql = "SELECT * FROM movies WHERE id = '$movie_id'";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            $movie = $result->fetch_assoc();
        } else {
            echo '<script>
                alert("Phim không tồn tại");
                window.location.href = "DanhSachPhim.php";
                </script>';
            exit();
        }

        // Xử lý yêu cầu cập nhật thông tin phim
        if (isset($_POST['update_movie'])) {
            $title = $_POST['title'];
            $image = $_POST['image'];
            $release_year = $_POST['release_year'];
            $country = $_POST['country'];
            $genre = $_POST['genre'];
            $status = $_POST['status'];
            $episodes = $_POST['episodes'];
            $actors = $_POST['actors'];
            $director = $_POST['director'];
            $summary = $_POST['summary'];
            $othertitle = $_POST['othertitle'];

            $sql = "UPDATE movies SET 
                    title = '$title', 
                    image = '$image', 
                    release_year = '$release_year', 
                    country = '$country', 
                    genre = '$genre', 
                    status = '$status', 
                    episodes = '$episodes', 
                    actors = '$actors', 
                    director = '$director', 
                    summary = '$summary', 
                    othertitle = '$othertitle' 
                    WHERE id = '$movie_id'";

            $result = $connection->query($sql);

            if ($result === true) {
                echo '<script>
                    alert("Cập nhật thông tin phim thành công");
                    window.location.href = "DanhSachPhim.php";
                    </script>';
                exit();
            } else {
                echo "Lỗi khi cập nhật thông tin phim: " . $connection->error;
            }
        }

        // Đóng kết nối cơ sở dữ liệu
        $connection->close();
        ?>

        <form method="POST" action="">
            <div>
                <label for="title">Tên phim:</label>
                <input type="text" name="title" id="title" value="<?php echo $movie['title']; ?>" required>
            </div>
            <div>
                <label for="image">Đường dẫn ảnh:</label>
                <input type="text" name="image" id="image" value="<?php echo $movie['image']; ?>" required>
            </div>
            <div>
                <label for="release_year">Năm phát hành:</label>
                <input type="number" name="release_year" id="release_year" value="<?php echo $movie['release_year']; ?>" required>
            </div>
            <div>
                <label for="country">Quốc gia:</label>
                <input type="text" name="country" id="country" value="<?php echo $movie['country']; ?>" required>
            </div>
            <div>
                <label for="genre">Thể loại:</label>
                <input type="text" name="genre" id="genre" value="<?php echo $movie['genre']; ?>" required>
            </div>
            <div>
                <label for="status">Tình trạng:</label>
                <input type="text" name="status" id="status" value="<?php echo $movie['status']; ?>" required>
            </div>
            <div>
                <label for="episodes">Số tập:</label>
                <input type="number" name="episodes" id="episodes" value="<?php echo $movie['episodes']; ?>" required>
            </div>
            <div>
                <label for="actors">Diễn viên:</label>
                <textarea name="actors" id="actors" required><?php echo $movie['actors']; ?></textarea>
            </div>
            <div>
                <label for="director">Đạo diễn:</label>
                <input type="text" name="director" id="director" value="<?php echo $movie['director']; ?>" required>
            </div>
            <div>
                <label for="summary">Tóm tắt:</label>
                <textarea name="summary" id="summary" required><?php echo $movie['summary']; ?></textarea>
            </div>
            <div>
                <label for="othertitle">Tiêu đề khác:</label>
                <input type="text" name="othertitle" id="othertitle" value="<?php echo $movie['othertitle']; ?>" required>
            </div>
            <div>
                <button type="submit" name="update_movie">Cập nhật phim</button>
            </div>
        </form>
    </section>

    <script src="js/main.js"></script>
</body>

</html>

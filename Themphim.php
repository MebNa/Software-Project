<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm thông tin phim</title>
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
        <h1>Thêm thông tin phim</h1>
        <form method="POST" action="">
            <div>
                <label for="title">Tên phim:</label>
                <input type="text" name="title" id="title" required>
            </div>
            <div>
                <label for="image">Đường dẫn ảnh:</label>
                <input type="text" name="image" id="image" required>
            </div>
            <div>
                <label for="release_year">Năm phát hành:</label>
                <input type="number" name="release_year" id="release_year" required>
            </div>
            <div>
                <label for="country">Quốc gia:</label>
                <input type="text" name="country" id="country" required>
            </div>
            <div>
                <label for="genre">Thể loại:</label>
                <input type="text" name="genre" id="genre" required>
            </div>
            <div>
                <label for="status">Tình trạng:</label>
                <input type="text" name="status" id="status" required>
            </div>
            <div>
                <label for="episodes">Số tập:</label>
                <input type="number" name="episodes" id="episodes" required>
            </div>
            <div>
                <label for="actors">Diễn viên:</label>
                <textarea name="actors" id="actors" required></textarea>
            </div>
            <div>
                <label for="director">Đạo diễn:</label>
                <input type="text" name="director" id="director" required>
            </div>
            <div>
                <label for="summary">Tóm tắt:</label>
                <textarea name="summary" id="summary" required></textarea>
            </div>
            <div>
                <label for="othertitle">Tiêu đề khác:</label>
                <input type="text" name="othertitle" id="othertitle" required>
            </div>
            <div>
                <button type="submit" name="add_movie">Thêm phim</button>
            </div>
        </form>
    </section>

    <script src="js/main.js"></script>
</body>

</html>

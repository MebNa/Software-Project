<?php
session_start();

// Kết nối đến cơ sở dữ liệu
include 'db_connection.php';

// Kiểm tra xem user_id đã tồn tại trong $_SESSION hay chưa
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = null;
}

// Lấy thông tin người dùng từ cơ sở dữ liệu
if ($user_id !== null) {
    $sql = "SELECT * FROM users WHERE id = '$user_id'";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        $user = null;
    }
} else {
    $user = null;
}

$connection->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Info</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="img/fav-icon.png" type="image/x-icon">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
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

        /* Rest of the CSS styles go here */

        /* Header */
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: var(--body-color);
            z-index: 100;
        }

        .container {
            max-width: 1068px;
            margin: auto;
            width: 100%;
        }

        .nav {
            display: flex;
            align-items: center;
            justify-self: center;
            padding: 20px 0;
        }

        .logo {
            font-size: 1.4rem;
            color: var(--text-color);
            font-weight: 600;
            text-transform: uppercase;
            margin: 0 auto 0 0;
        }

        .logo span {
            color: var(--main-color);
        }

        .search-box {
            max-width: 240px;
            width: 100%;
            display: flex;
            align-items: center;
            column-gap: 0.7rem;
            padding: 8px 15px;
            background: var(--container-color);
            border-radius: 4rem;
            margin-right: 1rem;
        }

        .search-box .bx {
            font-size: 1.1rem;
        }

        .search-box .bx:hover {
            color: var(--main-color);
        }

        #search-input {
            width: 100%;
            border: none;
            outline: none;
            color: var(--text-color);
            background: transparent;
            font-size: 0.938rem;
        }

        .user {
            display: flex;
            align-items: center;
        }

        .user-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            object-position: center;
        }

        /* Section */
        section {
            padding: 3rem 0 2rem;
        }

        .user-info {
            display: flex;
            align-items: center;
        }

        .user-info img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 1rem;
        }

        .info p {
            margin-bottom: 0.5rem;
        }

        form div {
            margin-bottom: 1rem;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
        }

        button[type="submit"] {
            background-color: var(--main-color);
            color: var(--text-color);
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
        }
    </style>
</head>

<body>
    <header>
        <div class="container">
            <nav class="nav">
                <a href="Trangchu.php?user_id=<?php echo $_SESSION['user_id']; ?>" class="logo">
                    Movie<span>Manhwa</span>
                </a>
                <div class="search-box">
                    <input type="text" name="noidung" autocomplete="off" id="search-input" placeholder="Search Movies">
                    <button class="search-button" type="submit" name="btn">
                        <a href="Search.html"><i class='bx bx-search'></i> </a>
                    </button>
                </div>
                <div class="user">
                    <a href="<?php echo isset($_SESSION['user_id']) ? 'UserInfo.php?user_id=' . $_SESSION['user_id'] : 'Dangnhap.php'; ?>">
                        <img class="user-img" src="<?php echo $user['avatar_link']; ?>" alt="User Avatar">
                    </a>
                </div>
            </nav>
        </div>
    </header>

    <section class="container">
        <h1>User Info</h1>
        <div class="user-info">
            <img src="<?php echo $user['avatar_link']; ?>" alt="Avatar">
            <div class="info">
                <p><strong>Username:</strong> <?php echo $user['username']; ?></p>
                <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
            </div>
        </div>

        <h2>Update Info</h2>
        <form method="POST" action="">
            <div>
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" value="<?php echo $user['username']; ?>">
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="<?php echo $user['email']; ?>">
            </div>
            <div>
                <label for="avatar_link">Avatar Link:</label>
                <input type="text" name="avatar_link" id="avatar_link" value="<?php echo $user['avatar_link']; ?>">
            </div>
            <button type="submit" name="update">Update</button>
        </form>

        <form method="POST" action="">
            <button type="submit" name="logout">Logout</button>
        </form>
    </section>
</body>

</html>

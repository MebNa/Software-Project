<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "manhuamovies";


    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Kết nối thất bại: " . mysqli_connect_error());
    }
    mysqli_query($conn, "SET NAMES 'utf8'");
?>
<?php
if (!function_exists('connectData')) {
    function connectData()
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "_qlbh_";

        $conn = new mysqli($servername, $username, $password, $database);

        if ($conn->connect_error) {
            die("❌ Kết nối thất bại: " . $conn->connect_error);
        }

        return $conn;
    }
}

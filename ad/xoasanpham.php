<?php
include ".././connect_DB/connect_db.php";
$conn = connectData();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM sanpham WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $conn->query("SET @num = 0");
        $conn->query("UPDATE sanpham SET id = @num := @num + 1");

        $conn->query("ALTER TABLE sanpham AUTO_INCREMENT = 1");

        header("Location: .././admin.php");
        exit();
    } else {
        echo "Lỗi khi xóa: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
